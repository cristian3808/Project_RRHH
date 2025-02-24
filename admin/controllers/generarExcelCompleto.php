<?php
include('../../config/db.php'); 
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

if (!isset($_GET['anio_id'])) {
    die("ID de proyecto no especificado.");
}
$anio_id = $_GET['anio_id'];

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet(); 
    $sheet->setTitle("Usuarios"); 

    $sheet->mergeCells('A1:E1'); 
    $sheet->setCellValue('A1', 'REQUISITOS DE CONTRATACIÓN'); 

    $sheet->mergeCells('Z2:AC2');
    $sheet->setCellValue('Z2', 'AFILIACIONES'); 

     $styleHeaderGreenLight = [
        'font' => ['bold' => true, 'color'], 
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'C4D79B'], 
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, 
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];

    $sheet->setCellValue('Z3', 'EPS');
    $sheet->setCellValue('AA3', 'AFP');
    $sheet->setCellValue('AB3', 'ARL');
    $sheet->setCellValue('AC3', 'CCF');
    $sheet->setCellValue('AD3', 'NOMBRE');
    $sheet->setCellValue('AE3', 'TELEFONO');

    $sheet->getStyle('Z2:AE2')->applyFromArray($styleHeaderGreenLight);
    $sheet->getStyle('Z3:AE3')->applyFromArray($styleHeaderGreenLight);

    $sheet->mergeCells('Z2:AC2'); 
    $sheet->mergeCells('AD2:AE2'); 
    $sheet->setCellValue('Z2', 'AFILIACIONES'); 
    $sheet->setCellValue('AD2', 'CONTACTO EN CASO DE EMERGENCIA');
     
    $sheet->mergeCells('AD2:AE2');
    $sheet->setCellValue('AD2', 'CONTACTO EN CASO DE EMERGENCIA'); 

    $sheet->mergeCells('F1:AM1'); 
    $sheet->setCellValue('F1', 'SELECCIÓN-VINCULACIÓN-SEGUIMIENTO Y TERMINACIÓN'); 

    $styleHeaderGray = [
        'font' => ['bold' => true], 
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'D9D9D9'], 
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER, 
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN, 
                'color' => ['rgb' => '000000'], 
            ],
        ],
    ];
    $sheet->getStyle('A1:E1')->applyFromArray($styleHeaderGray);
    $styleHeaderGreen = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4F6228'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, 
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'], 
            ],
        ],
    ];
    $sheet->getStyle('F1:Y1')->applyFromArray($styleHeaderGreen);
    $sheet->getRowDimension(1)->setRowHeight(20);
    $styleHeaderGreenLightBold = [
        'font' => ['bold' => true], 
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'C4D79B'], 
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, 
            'vertical' => Alignment::VERTICAL_CENTER, 
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN, 
                'color' => ['rgb' => '000000'], 
            ],
        ],
    ];

    $sheet->setCellValue('Z3', 'EPS');
    $sheet->setCellValue('AA3', 'AFP');
    $sheet->setCellValue('AB3', 'ARL');
    $sheet->setCellValue('AC3', 'CCF');
    $sheet->setCellValue('AD3', 'NOMBRE');
    $sheet->setCellValue('AE3', 'TELEFONO');
    $sheet->mergeCells('AF2:AF3'); 
    $sheet->setCellValue('AF2', 'CARNET DE VACUNAS');
    $styleHeaderCarnetVacunas = [
        'font' => ['bold' => true, 'color'],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'C4D79B'], 
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, 
            'vertical' => Alignment::VERTICAL_CENTER, 
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN, 
                'color' => ['rgb' => '000000'], 
            ],
        ],
    ];
    $textoCelda = [
        'AG' => 'CARNET CLIENTE',
        'AH' => 'CARNET TF',
        'AI' => 'EVALUACION DE DESEMPEÑO',
        'AJ' => 'CARTA DE TERMINACION',
        'AK' => 'ENVIO DE LIQUIDACION',
        'AL' => 'PAGO DE LIQUIDACION',
        'AM' => 'PAGO DE CERTIFICACION LABORAL',
    ];
    foreach ($textoCelda as $columna => $texto) {
        $sheet->mergeCells($columna . '2:' . $columna . '3'); 
        $sheet->setCellValue($columna . '2', $texto); 
        $sheet->getStyle($columna . '2:' . $columna . '3')->applyFromArray($styleHeaderCarnetVacunas);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
    }
    $headers = [
        'CARGO', 'EXPERIENCIA', 'TIPO DE CONTRATO', 'TIPO DE MANO DE OBRA', 
        'PERSONAL DE LA COMUNIDAD', 'CIUDAD DE CONTRATACION', 'NOMBRES', 'APELLIDOS', 
        'CEDULA', 'TELEFONO', 'FECHA DE NACIMIENTO', 'LUGAR DE NACIMIENTO', 'FECHA DE EXPEDICION', 
        'LUGAR DE EXPEDICION', 'RH', 'DIRECCIÓN', 'EMAIL', 'CERTIFICADO DE REGIONALIDAD', 
        'SOLICITUD DE PERSONAL', 'EXAMEN MEDICO', 'ENTREVISTA', 'PRUEBAS TECNICAS', 
        'FECHA DE INICIO CONTRATO', 'FECHA FIN CONTRATO', 'CONTRATO FIRMADO', 
        'NOMBRE DE CONTACTO', 'TELÉFONO DE CONTACTO', 'EPS','FONDO PENSION','ARL'
    ];
    $columnIndex = 'A'; 
    $maxColumn = 'Y'; 
    foreach ($headers as $header) {
        if ($columnIndex > $maxColumn) {
            break; 
        }
        $mergeRange = $columnIndex . '2:' . $columnIndex . '3'; 
        $sheet->mergeCells($mergeRange); 
        $sheet->setCellValue($columnIndex . '2', $header); 
        $sheet->getStyle($mergeRange)->applyFromArray($styleHeaderGreenLightBold); 
        $columnIndex++; 
    }
    $sheet->getRowDimension(2)->setRowHeight(20);
    $sheet->getRowDimension(3)->setRowHeight(20);
    $rowIndex = 4;
    $sql = "
        SELECT ur.nombres, ur.apellidos, ur.cedula, ur.telefono, ur.fecha_nacimiento, ur.lugar_nacimiento, 
               ur.fecha_expedicion_cedula, ur.lugar_nacimiento AS lugar_expedicion, ur.tipo_sangre, ur.direccion, ur.correo, 
               ur.nombre_contacto, ur.telefono_contacto, ur.eps, ur.fondo_pension, ur.arl
        FROM usuarios_r ur
        JOIN usuarios u ON ur.cedula = u.cedula
        WHERE u.anio_id = ?
    ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $anio_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('G' . $rowIndex, $row['nombres']);
            $sheet->setCellValue('H' . $rowIndex, $row['apellidos']);
            $sheet->setCellValue('I' . $rowIndex, $row['cedula']);
            $sheet->setCellValue('J' . $rowIndex, $row['telefono']);
            $sheet->setCellValue('K' . $rowIndex, $row['fecha_nacimiento']);
            $sheet->setCellValue('L' . $rowIndex, $row['lugar_nacimiento']);
            $sheet->setCellValue('M' . $rowIndex, $row['fecha_expedicion_cedula']);
            $sheet->setCellValue('N' . $rowIndex, $row['lugar_expedicion']);
            $sheet->setCellValue('O' . $rowIndex, $row['tipo_sangre']);
            $sheet->setCellValue('P' . $rowIndex, $row['direccion']);
            $sheet->setCellValue('Q' . $rowIndex, $row['correo']);
            $sheet->setCellValue('Z' . $rowIndex, $row['eps']); 
            $sheet->setCellValue('AA' . $rowIndex, $row['fondo_pension']); 
            $sheet->setCellValue('AB' . $rowIndex, $row['arl']); 
            $sheet->setCellValue('AD' . $rowIndex, $row['nombre_contacto']); 
            $sheet->setCellValue('AE' . $rowIndex, $row['telefono_contacto']); 
            $sheet->getStyle("A$rowIndex:AM$rowIndex")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, 
                        'color' => ['rgb' => '000000'], 
                    ],
                ],
            ]);
            $sheet->getStyle('AF2:AF3')->applyFromArray($styleHeaderCarnetVacunas);
            $rowIndex++;
        }
    } else {
        if (!file_exists($certificadoTerritorialidadRuta)) {
            $_SESSION['error'] = 'No se encontraron usuarios para el proyecto especificado.'; // Guarda el mensaje de error
            header("Location: ../public/rtaPrimerForm.php?anio_id=" . $_GET['anio_id']); // Redirige a la página
            exit;
        }
    }
    $writer = new Xlsx($spreadsheet);
    $fileName = 'Proyectos 2025.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
} catch (Exception $e) {
    echo "Error al crear el archivo Excel: " . $e->getMessage();
}
?>
