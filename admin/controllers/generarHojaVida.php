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

$hojaVida = $usuario['hoja_vida'];

$hojaVidaRuta = null;

if (!empty($hojaVida)) {
    $hojaVidaRuta = $uploadsDir . basename($hojaVida); 

    if (!file_exists($hojaVidaRuta)) {
        $hojaVidaRuta = null; 
    }
}

$usuariosDir = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/';
if (!file_exists($usuariosDir)) {
    mkdir($usuariosDir, 0777, true); 
}

$pdf = new TcpdfFpdi();
$pdf->AddPage(); 

$pdf->SetFont('helvetica', '', 12);

if ($hojaVidaRuta !== null) {
    if (pathinfo($hojaVidaRuta, PATHINFO_EXTENSION) == 'pdf') {
        $pageCount = $pdf->setSourceFile($hojaVidaRuta); 
        for ($i = 1; $i <= $pageCount; $i++) {
            $tpl = $pdf->importPage($i);
            $pdf->useTemplate($tpl, 10, 10, 190);

            if ($i < $pageCount) {
                $pdf->AddPage(); 
            }
        }
    }
    elseif (in_array(pathinfo($hojaVidaRuta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
        $imageHeight = 0; 
        list($width, $height) = getimagesize($hojaVidaRuta);
        $imageHeight = (180 * $height) / $width; 

        $pdf->Image($hojaVidaRuta, 10, 50, 180, $imageHeight, pathinfo($hojaVidaRuta, PATHINFO_EXTENSION));
    }
} else {
    $pdf->Write(0, "No se encuentra el archivo de la Hoja de Vida.");
}

$pdfOutput = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/' . 'Hoja de Vida.pdf';

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
