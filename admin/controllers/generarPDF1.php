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

$archivos = [
    'hoja_vida' => $usuario['hoja_vida'],
    'subir_cedula' => $usuario['subir_cedula'],
    'certificados_estudio' => $usuario['certificados_estudio'],
    'certificados_laborales' => $usuario['certificados_laborales'],
    'foto' => $usuario['foto'],
    'certificados_eps' => $usuario['certificados_eps'],
    'carnet_vacunas' => $usuario['carnet_vacunas'],
    'certificacion_bancaria' => $usuario['certificacion_bancaria'],
    'certificado_antecedentes' => $usuario['certificado_antecedentes'],
    'certificado_afp' => $usuario['certificado_afp'],
];

// Solo agregar 'certificados_territorialidad' si el valor no es 'no'
if ($usuario['certificados_territorialidad'] !== 'no') {
    $archivos['certificados_territorialidad'] = $usuario['certificados_territorialidad'];
}

$archivosDisponibles = [];

foreach ($archivos as $clave => $archivo) {
    if (!empty($archivo)) {
        $rutaArchivo = $uploadsDir . basename($archivo);
        
        if (file_exists($rutaArchivo)) {
            $archivosDisponibles[$clave] = $rutaArchivo;
        } else {
            $archivosDisponibles[$clave] = null; 
        }
    }
}

$usuariosDir = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/';
if (!file_exists($usuariosDir)) {
    mkdir($usuariosDir, 0777, true); 
}

$pdf = new TcpdfFpdi();
$pdf->AddPage(); 

$pdf->SetFont('helvetica', '', 12);

foreach ($archivosDisponibles as $tipo => $ruta) {
    if ($ruta !== null) {
        if (pathinfo($ruta, PATHINFO_EXTENSION) == 'pdf') {
            $pageCount = $pdf->setSourceFile($ruta); 
            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $pdf->importPage($i);
                $pdf->useTemplate($tpl, 10, 10, 190); 
                if ($i < $pageCount) {
                    $pdf->AddPage(); 
                }
            }
        }
        elseif (in_array(pathinfo($ruta, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
            $imageHeight = 0; 
            list($width, $height) = getimagesize($ruta);
            $imageHeight = (180 * $height) / $width; 

            $pdf->Image($ruta, 10, 50, 180, $imageHeight, pathinfo($ruta, PATHINFO_EXTENSION));
        }
    } else {
        $pdf->Write(0, "No se encuentra el archivo.");
    }
    if ($tipo != array_key_last($archivosDisponibles)) {
        $pdf->AddPage(); 
    }
}

$pdfOutput = $_SERVER['DOCUMENT_ROOT'] . '/usuarios/' . 'Informe Completo.pdf';

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
