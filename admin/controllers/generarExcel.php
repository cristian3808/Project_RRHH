<?php
include('../../config/db.php'); 
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_GET['project_id']) || empty($_GET['project_id'])) {
    die("ID de proyecto no especificado.");
}

$project_id = intval($_GET['project_id']);

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Usuarios del Proyecto");
    
    $headers = ['Nombre', 'Apellido', 'Cédula', 'Correo'];
    $columnIndex = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($columnIndex . '1', $header);
        $columnIndex++;
    }

    $sql = "SELECT nombre, apellido, cedula, correo 
            FROM usuarios 
            WHERE project_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $rowIndex = 2; 
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('A' . $rowIndex, $row['nombre']);
            $sheet->setCellValue('B' . $rowIndex, $row['apellido']);
            $sheet->setCellValue('C' . $rowIndex, $row['cedula']);
            $sheet->setCellValue('D' . $rowIndex, $row['correo']);
            $rowIndex++;
        }
    } else {
        die("No se encontraron usuarios para el proyecto especificado.");
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'Usuarios_Proyecto_' . $project_id . '_' . date('YmdHis') . '.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
} catch (Exception $e) {
    echo "Error al crear el archivo Excel: " . $e->getMessage();
}
?>
