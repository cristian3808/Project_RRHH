<?php
require('../../fpdf/fpdf.php');
include('../../config/db.php');

// Aseguramos que la conexión esté en UTF-8
mysqli_set_charset($conn, 'utf8');

if (isset($_GET['action']) && $_GET['action'] === 'getUsers') {
    // Verificar si el parámetro anio_id está presente en la URL
    if (isset($_GET['anio_id'])) {
        $anio_id = intval($_GET['anio_id']); // Sanear el parámetro anio_id

        // Construir la consulta SQL para seleccionar usuarios según el anio_id
        $sql = "SELECT u.id, u.nombres, u.apellidos, u.cedula,
            CASE
                WHEN ur.cedula IS NOT NULL THEN 'Ya diligencio'
                ELSE 'No lo ha hecho'
            END AS estado
        FROM usuarios u
        LEFT JOIN usuarios_r ur ON u.cedula = ur.cedula
        WHERE u.anio_id = $anio_id";

        $result = mysqli_query($conn, $sql);
        $usuarios = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $usuarios[] = [
                    'id' => $row['id'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'estado' => $row['estado']
                ];
            }
        }

        // Devolver los usuarios en formato JSON
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    } else {
        // Si no se pasa el anio_id, devolver una respuesta vacía o un error
        echo json_encode([]);
    }
    exit;
}

$userIds = isset($_POST['userIds']) ? $_POST['userIds'] : [];

if (empty($userIds)) {
    echo "No se seleccionaron usuarios.";
    exit;
}

// Constantes de diseño
define('CUADRO_WIDTH', 58); // Ancho uniforme para todos los cuadros
define('CUADRO_HEIGHT', 92);
define('ESPACIO_ENTRE_USUARIOS', 90);
define('HEADER_Y_OFFSET', -1);
define('FOOTER_Y_OFFSET', 78); // Reducir 3 mm para subir la imagen
define('MAX_USUARIOS_POR_FILA', 3);
define('USUARIOS_POR_PAGINA', 6);

$pdf = new FPDF('L', 'mm', array(350, 225));
$pdf->SetMargins(0, 0, 0);
$pdf->AddPage();

$yPos = 10;

foreach ($userIds as $index => $id) {
    if ($index > 0 && $index % USUARIOS_POR_PAGINA == 0) {
        $pdf->AddPage();
        $yPos = 10;
    }

    $sql = "SELECT ur.id, ur.nombres, ur.apellidos, ur.cedula, ur.tipo_sangre, ur.eps, ur.arl, ur.foto 
        FROM usuarios u
        JOIN usuarios_r ur ON u.cedula = ur.cedula
        WHERE u.id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);

        $foto = $usuario['foto'];
        $fotoPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/controllers/' . $foto;

        $rutaFoto = (file_exists($fotoPath) && !empty($foto)) ? $fotoPath : $_SERVER['DOCUMENT_ROOT'] . '/admin/controllers/uploads/fotoMal.jpg';

        $xPos = ($index % MAX_USUARIOS_POR_FILA) * (CUADRO_WIDTH * 2); // Ajustar espacio entre cuadros

        $xIzquierda = $xPos;
        $yArriba = $yPos;

        // Primer cuadro
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($xIzquierda, $yArriba);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(CUADRO_WIDTH, CUADRO_HEIGHT, '', 0, 0, 'C', true);
        $pdf->Rect($xIzquierda, $yArriba, CUADRO_WIDTH, CUADRO_HEIGHT);

        $headerImagePath = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/imgs/headerimg.png';
        if (file_exists($headerImagePath)) {
            $headerWidth = CUADRO_WIDTH;
            list($imgWidth, $imgHeight) = getimagesize($headerImagePath);
            $headerHeight = ($headerWidth * $imgHeight) / $imgWidth;
            $pdf->Image($headerImagePath, $xIzquierda, $yArriba + HEADER_Y_OFFSET, $headerWidth, $headerHeight / 1.5);
        }

        $logoTFPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/imgs/TF.png';
        if (file_exists($logoTFPath)) {
            $pdf->Image($logoTFPath, $xIzquierda + 12, $yArriba + 4, 32, 15);
        }

        $pdf->Image($rutaFoto, $xIzquierda + 19, $yArriba + 22, 20, 25);

        $pdf->SetFont('Arial','B',10);
        $lineHeight = 6;
        $totalTextHeight = $lineHeight * 2;

        // Centrar verticalmente el contenido base
        $centeredY = $yArriba + (CUADRO_HEIGHT - $totalTextHeight) / 2;

        // Ajuste para el apellido (ahora ocupará la posición del nombre)
        $apellidoCompleto = utf8_decode($usuario['apellidos']); // Convertir a ISO-8859-1
        $apellidoDesplazamiento = 9; // Desplazamiento adicional para el apellido
        $pdf->SetXY($xIzquierda, $centeredY + $apellidoDesplazamiento);
        $pdf->Cell(CUADRO_WIDTH, $lineHeight, $apellidoCompleto, 0, 1, 'C');

        // Ajuste para el nombre (ahora ocupará la posición del apellido)
        $nombreCompleto = utf8_decode($usuario['nombres']); // Convertir a ISO-8859-1
        $nombreDesplazamiento = 7; // Desplazamiento adicional para el nombre
        $pdf->SetXY($xIzquierda, $centeredY + $lineHeight + $nombreDesplazamiento);
        $pdf->Cell(CUADRO_WIDTH, $lineHeight, $nombreCompleto, 0, 1, 'C');


        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($xIzquierda + 11, $yArriba + 61);
        $pdf->Cell(0, 5, 'ID:          ' . $usuario['cedula'], 0, 1, 'L');
        $pdf->SetXY($xIzquierda + 11, $yArriba + 65);
        $pdf->Cell(0, 5, 'RH:        ' . $usuario['tipo_sangre'], 0, 1, 'L');
        $pdf->SetXY($xIzquierda + 11, $yArriba + 69);
        $pdf->Cell(0, 5, 'EPS:      ' . strtoupper($usuario['eps']), 0, 1, 'L');
        $pdf->SetXY($xIzquierda + 11, $yArriba + 73);
        $pdf->Cell(0, 5, 'ARL:      ' . $usuario['arl'], 0, 1, 'L');

        $footerImagePath = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/imgs/footerimg.png';
        if (file_exists($footerImagePath)) {
            $footerWidth = CUADRO_WIDTH;
            list($imgWidth, $imgHeight) = getimagesize($footerImagePath);

            // Incrementar la altura de la imagen del footer
            $footerHeight = ($footerWidth * $imgHeight) / $imgWidth * 1.5; // Aumentar 50% su altura original

            // Centrar horizontalmente
            $xFooterCentered = $xIzquierda + (CUADRO_WIDTH - $footerWidth) / 2;

            $pdf->Image($footerImagePath, $xFooterCentered, $yArriba + FOOTER_Y_OFFSET, $footerWidth, $footerHeight);
        }

        // Segundo cuadro
        $xDerecha = $xIzquierda + CUADRO_WIDTH;
        $pdf->SetXY($xDerecha, $yArriba);
        $pdf->Cell(CUADRO_WIDTH, CUADRO_HEIGHT, '', 0, 0, 'C', true);
        $pdf->Rect($xDerecha, $yArriba, CUADRO_WIDTH, CUADRO_HEIGHT);

        if (file_exists($headerImagePath)) {
            $pdf->Image($headerImagePath, $xDerecha, $yArriba + HEADER_Y_OFFSET, $headerWidth, $headerHeight / 1.5);
        }

        $firmaPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/imgs/firma.png';
        if (file_exists($firmaPath)) {
            $pdf->Image($firmaPath, $xDerecha + 0, $yArriba + 8, 58);
        }

        if (file_exists($footerImagePath)) {
            $footerWidth = CUADRO_WIDTH;
            $xFooterCentered = $xDerecha + (CUADRO_WIDTH - $footerWidth) / 2;

            $pdf->Image($footerImagePath, $xFooterCentered, $yArriba + FOOTER_Y_OFFSET, $footerWidth, $footerHeight);
        }

        if (($index + 1) % MAX_USUARIOS_POR_FILA == 0) {
            $yPos += ESPACIO_ENTRE_USUARIOS + 5;
        }
    }
}

$pdf->Output('D', 'PDF de Carnets.pdf');
?>
