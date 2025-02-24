<?php
include('../../config/db.php'); 
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_GET['anio_id'])) {
    die("ID de proyecto no especificado.");
}

$anio_id = $_GET['anio_id']; 

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Usuarios");
    
    $headers = ['Nombres','Apellidos','Cédula','Teléfono', 'Fecha Nacimiento','Lugar Nacimiento','Fecha Expedicion','Lugar Expedicion','Direccion', 'Correo', 'Nombre Contacto', 'Telefono Contacto', 'Tipo sangre','Eps','Arl'];
    $columnIndex = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($columnIndex . '1', $header);
        $columnIndex++;
    }

    $sql = "
        SELECT ur.nombres, ur.apellidos, ur.cedula, ur.telefono, ur.fecha_nacimiento, ur.lugar_nacimiento, ur.fecha_expedicion_cedula,ur.lugar_nacimiento ,ur.direccion, ur.correo, ur.nombre_contacto, ur.telefono_contacto, ur.tipo_sangre, ur.eps, ur.arl
        FROM usuarios_r ur
        JOIN usuarios u ON ur.cedula = u.cedula
        WHERE u.anio_id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $anio_id); 
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $rowIndex = 2; 
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('A' . $rowIndex, $row['nombres']);
            $sheet->setCellValue('B' . $rowIndex, $row['apellidos']);
            $sheet->setCellValue('C' . $rowIndex, $row['cedula']);
            $sheet->setCellValue('D' . $rowIndex, $row['telefono']);
            $sheet->setCellValue('E' . $rowIndex, $row['fecha_nacimiento']);
            $sheet->setCellValue('F' . $rowIndex, $row['lugar_nacimiento']);
            $sheet->setCellValue('G' . $rowIndex, $row['fecha_expedicion_cedula']);
            $sheet->setCellValue('H' . $rowIndex, $row['lugar_nacimiento']);
            $sheet->setCellValue('I' . $rowIndex, $row['direccion']);
            $sheet->setCellValue('J' . $rowIndex, $row['correo']);
            $sheet->setCellValue('K' . $rowIndex, $row['nombre_contacto']);
            $sheet->setCellValue('L' . $rowIndex, $row['telefono_contacto']);
            $sheet->setCellValue('M' . $rowIndex, $row['tipo_sangre']);
            $sheet->setCellValue('N' . $rowIndex, $row['eps']);
            $sheet->setCellValue('O' . $rowIndex, $row['arl']);

            $rowIndex++;
        }
    } else {
        die("No se encontraron usuarios para el proyecto especificado.");
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'DATOS PERSONALES.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
} catch (Exception $e) {
    echo "Error al crear el archivo Excel: " . $e->getMessage();
}
?>
