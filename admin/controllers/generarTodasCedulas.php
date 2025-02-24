<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../config/db.php');
require('../../vendor/autoload.php');

use TCPDF;
use setasign\Fpdi\TcpdfFpdi;

// Verificar si se ha recibido el parámetro anio_id
if (!isset($_GET['anio_id'])) {
    die("anio_id no especificado.");
}

$anio_id = $_GET['anio_id']; 

// Consulta para obtener todos los usuarios con cédulas subidas en el año especificado
$sql = "SELECT ur.*, u.anio_id FROM usuarios_r ur JOIN usuarios u ON ur.cedula = u.cedula WHERE ur.subir_cedula IS NOT NULL AND u.anio_id = '$anio_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error al ejecutar la consulta: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("No se encontraron cédulas para el año especificado.");
}

$uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/controllers/uploads/';
$zipFile = $_SERVER['DOCUMENT_ROOT'] . "/usuarios/Cedulas_Proyecto$anio_id.zip";
$zip = new ZipArchive();

if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("No se pudo crear el archivo ZIP.");
}

while ($usuario = mysqli_fetch_assoc($result)) {
    $cedulaArchivo = $usuario['subir_cedula'];
    $cedulaRuta = $uploadsDir . basename($cedulaArchivo);
    $pdfOutput = $_SERVER['DOCUMENT_ROOT'] . "/usuarios/Cédula_de_{$usuario['nombres']}_{$usuario['apellidos']}.pdf";
    
    $pdf = new TcpdfFpdi();
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 12);

    if (file_exists($cedulaRuta)) {
        $pdf->AddPage();
        if (pathinfo($cedulaRuta, PATHINFO_EXTENSION) == 'pdf') {
            $pageCount = $pdf->setSourceFile($cedulaRuta);
            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $pdf->importPage($i);
                $pdf->useTemplate($tpl, 10, 10, 190);
                if ($i < $pageCount) {
                    $pdf->AddPage();
                }
            }
        } elseif (in_array(pathinfo($cedulaRuta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
            list($width, $height) = getimagesize($cedulaRuta);
            $imageHeight = (180 * $height) / $width;
            $pdf->Image($cedulaRuta, 10, 50, 180, $imageHeight, pathinfo($cedulaRuta, PATHINFO_EXTENSION));
        }
    } else {
        $pdf->Write(0, "No se encuentra el archivo de la cédula para el usuario con cédula: " . $usuario['cedula']);
    }
    
    $pdf->Output($pdfOutput, 'F');
    $zip->addFile($pdfOutput, basename($pdfOutput));
}

$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="Cédulas_del_Proyecto.zip"');
header('Content-Length: ' . filesize($zipFile));
readfile($zipFile);
exit;
?>