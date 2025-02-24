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

$carnetVacunasArchivo = $usuario['carnet_vacunas'];
$carnetVacunasRuta = $uploadsDir . basename($carnetVacunasArchivo);

if (!file_exists($carnetVacunasRuta)) {
    die("El archivo del Carnet de Vacunas no existe.");
}

$usuariosDir = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/';
if (!file_exists($usuariosDir)) {
    mkdir($usuariosDir, 0777, true);
}

$pdf = new TcpdfFpdi();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

if ($carnetVacunasRuta !== null) {
    if (pathinfo($carnetVacunasRuta, PATHINFO_EXTENSION) == 'pdf') {
        $pageCount = $pdf->setSourceFile($carnetVacunasRuta);
        for ($i = 1; $i <= $pageCount; $i++) {
            $tpl = $pdf->importPage($i);
            $pdf->useTemplate($tpl, 10, 10, 190);

            if ($i < $pageCount) {
                $pdf->AddPage();
            }
        }
    } elseif (in_array(pathinfo($carnetVacunasRuta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
        list($width, $height) = getimagesize($carnetVacunasRuta);
        $imageHeight = (180 * $height) / $width;

        $pdf->Image($carnetVacunasRuta, 10, 50, 180, $imageHeight, pathinfo($carnetVacunasRuta, PATHINFO_EXTENSION));
    }
} else {
    $pdf->Write(0, "No se encuentra el archivo del Carnet de Vacunas.");
}

$pdfOutput = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/' . 'Carnet De Vacunas.pdf';

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
