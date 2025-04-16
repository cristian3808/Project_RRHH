<?php
session_start();
include('../../config/db.php');
require('../../vendor/autoload.php');

use TCPDF;
use setasign\Fpdi\TcpdfFpdi;

if (!isset($_GET['cedula']) || !isset($_GET['anio_id'])) {
    die("Cédula o anio_id no especificados.");
}

$cedula = $_GET['cedula'];
$anio_id = $_GET['anio_id'];

$sql = "SELECT * FROM usuarios_r WHERE cedula = '$cedula'";
$result = mysqli_query($conn, $sql);
$usuario = mysqli_fetch_assoc($result);

if (!$usuario) {
    header("Location: ../public/rtaPrimerForm.php?anio_id=" . $_GET['anio_id'] . "&usuario_no_encontrado=true");
    exit;
}

$uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/controllers/uploads/';

$antecedenteProcuraduriaArchivo = $usuario['cert_antecedente_procuraduria'];
$antecedenteProcuraduriaRuta = $uploadsDir . basename($antecedenteProcuraduriaArchivo);

if (!file_exists($antecedenteProcuraduriaRuta)) {
    die("El archivo de Certificado de Antecedentes de la Procuraduría no existe.");
}

$usuariosDir = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/';
if (!file_exists($usuariosDir)) {
    mkdir($usuariosDir, 0777, true);
}

$pdf = new TcpdfFpdi();

// ✅ Desactivar cabecera y pie de página
$pdf->setPrintHeader(false);

$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

if ($antecedenteProcuraduriaRuta !== null) {
    if (pathinfo($antecedenteProcuraduriaRuta, PATHINFO_EXTENSION) == 'pdf') {
        $pageCount = $pdf->setSourceFile($antecedenteProcuraduriaRuta);
        for ($i = 1; $i <= $pageCount; $i++) {
            $tpl = $pdf->importPage($i);
            $pdf->useTemplate($tpl, 10, 10, 190);

            if ($i < $pageCount) {
                $pdf->AddPage();
            }
        }
    } elseif (in_array(pathinfo($antecedenteProcuraduriaRuta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
        list($width, $height) = getimagesize($antecedenteProcuraduriaRuta);
        $imageHeight = (180 * $height) / $width;

        $pdf->Image($antecedenteProcuraduriaRuta, 10, 50, 180, $imageHeight, pathinfo($antecedenteProcuraduriaRuta, PATHINFO_EXTENSION));
    }
} else {
    $pdf->Write(0, "No se encuentra el archivo de Certificado de Antecedentes de la Procuraduría.");
}

$pdfOutput = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/' . 'Certificado de Antecedentes Procuraduría.pdf';

if (file_exists($pdfOutput)) {
    unlink($pdfOutput);
}

$pdf->Output($pdfOutput, 'F');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($pdfOutput) . '"');
header('Content-Length: ' . filesize($pdfOutput));
readfile($pdfOutput);
exit;
?>
