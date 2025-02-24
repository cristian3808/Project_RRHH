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

$fotoArchivo = $usuario['foto'];
$fotoRuta = $uploadsDir . basename($fotoArchivo);

if (!file_exists($fotoRuta)) {
    die("El archivo de foto no existe.");
}

$usuariosDir = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/';
if (!file_exists($usuariosDir)) {
    mkdir($usuariosDir, 0777, true); 
}

$pdf = new TcpdfFpdi();
$pdf->AddPage(); 

$pdf->SetFont('helvetica', '', 12);

if ($fotoRuta !== null) {
    if (in_array(pathinfo($fotoRuta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
        list($width, $height) = getimagesize($fotoRuta);
        $imageHeight = (180 * $height) / $width; 

        $pdf->Image($fotoRuta, 10, 50, 180, $imageHeight, pathinfo($fotoRuta, PATHINFO_EXTENSION));
    }
} else {
    $pdf->Write(0, "No se encuentra el archivo de foto.");
}

$pdfOutput = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/' . 'Foto.pdf';

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
