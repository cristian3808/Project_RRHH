<?php
require('../../config/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $genero = $_POST['genero'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $lugar_nacimiento = $_POST['lugar_nacimiento'];
    $direccion = $_POST['direccion'];
    $eps = $_POST['eps'];
    $fecha_expedicion_cedula = $_POST['fecha_expedicion_cedula'];
    $correo = $_POST['correo'];
    $municipio_residencia = $_POST['municipio_residencia'];
    $nombre_1 = $_POST['nombre_contacto'];
    $telefono_1 = $_POST['telefono_contacto'];
    $tipo_sangre = $_POST['tipo_sangre'];
    $certificadosEps = $_POST['certificados_eps'];
    $carnetVacunas = $_POST['carnet_vacunas'];
    $certificacionBancaria = $_POST['certificacion_bancaria'];
    $certificadosAntecedentes = $_POST['certificado_antecedentes'];
    $certificadosAfp = $_POST['certificado_afp'];
    $fondo_pension = $_POST['fondo_pension'];
    $arl = $_POST['arl'];
    $talla_camisa = $_POST['talla_camisa'];
    $talla_pantalon = $_POST['talla_pantalon'];
    $talla_botas = $_POST['talla_botas'];
    $talla_nomex = $_POST['talla_nomex'];
    $enviado = 0;

    $sql_check = "SELECT COUNT(*) FROM usuarios_r WHERE cedula = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $cedula);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();
    
    if ($count > 0) {
        echo "Datos registrados exitosamente...";
    } else {
        if (isset($_FILES['certificados_territorialidad']) && $_FILES['certificados_territorialidad']['error'] === UPLOAD_ERR_OK) {
            $certificadosTerritoriales = $_FILES['certificados_territorialidad']['name'];
            $certificadosTerritorialesTemp = $_FILES['certificados_territorialidad']['tmp_name'];
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileTerritoriales = $uploadDir . basename($certificadosTerritoriales);
            move_uploaded_file($certificadosTerritorialesTemp, $uploadFileTerritoriales); 
        } else {
            $uploadFileTerritoriales = 'no'; 
        }
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoImagen = $_FILES['foto']['name'];
            $fotoImagenTemp = $_FILES['foto']['tmp_name'];
            $uploadDirImagenes = "uploads/";
            if (!is_dir($uploadDirImagenes)) {
                mkdir($uploadDirImagenes, 0777, true);  
            }
            $uploadFileImagen = $uploadDirImagenes . basename($fotoImagen);
            move_uploaded_file($fotoImagenTemp, $uploadFileImagen); 
        } else {
            $uploadFileImagen = '';  
        }

        if (isset($_FILES['hoja_vida']) && $_FILES['hoja_vida']['error'] === UPLOAD_ERR_OK) {
            $hojaVida = $_FILES['hoja_vida']['name'];
            $hojaVidaTemp = $_FILES['hoja_vida']['tmp_name'];
            // Verificar si el archivo es un PDF
            $fileType = mime_content_type($hojaVidaTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo debe ser un PDF.");
            }
            // Contar el número de páginas del PDF
            $pdfContent = file_get_contents($hojaVidaTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            // Si el PDF tiene más de 3 páginas, mostrar un error y redirigir
            if ($numPages > 3) {
                // Mostrar la modal con el mensaje de error
                echo 'Error: La hoja de vida no puede tener más de 3 páginas.';
                exit; // Detenemos la ejecución del script PHP
            }
            // Si pasa todas las validaciones, entonces guardamos el archivo
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $uploadFile = $uploadDir . basename($hojaVida);
            // Mover el archivo cargado al directorio de destino
            if (move_uploaded_file($hojaVidaTemp, $uploadFile)) {
            } else {
                echo "Error al guardar el archivo hoja de vida.";
            }
        }

        if (isset($_FILES['certificados_laborales']) && $_FILES['certificados_laborales']['error'] === UPLOAD_ERR_OK) {
            $certificadosLaborales = $_FILES['certificados_laborales']['name'];
            $certificadosLaboralesTemp = $_FILES['certificados_laborales']['tmp_name'];
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }

            $uploadFileLaborales = $uploadDir . basename($certificadosLaborales);
            move_uploaded_file($certificadosLaboralesTemp, $uploadFileLaborales); 
        } else {
            $uploadFileLaborales = '';  
        }

        if (isset($_FILES['certificados_estudio']) && $_FILES['certificados_estudio']['error'] === UPLOAD_ERR_OK) {
            $certificadosEstudio = $_FILES['certificados_estudio']['name'];
            $certificadosEstudioTemp = $_FILES['certificados_estudio']['tmp_name'];
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }

            $uploadFileEstudios = $uploadDir . basename($certificadosEstudio);
            move_uploaded_file($certificadosEstudioTemp, $uploadFileEstudios);  
        } else {
            $uploadFileEstudios = '';  
        }
        
        if (isset($_FILES['certificados_eps']) && $_FILES['certificados_eps']['error'] === UPLOAD_ERR_OK) {
            $certificadosEps = $_FILES['certificados_eps']['name'];
            $certificadosEpsTemp = $_FILES['certificados_eps']['tmp_name'];
            $fileType = mime_content_type($certificadosEpsTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificados EPS debe ser un PDF.");
            }
            $pdfContent = file_get_contents($certificadosEpsTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            if ($numPages > 1) {
                echo 'Error: El archivo de certificados EPS no puede tener más de 1 página.';
                exit; 
            }
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileEps = $uploadDir . basename($certificadosEps);
            if (move_uploaded_file($certificadosEpsTemp, $uploadFileEps)) {
            } else {
                echo "Error al guardar el archivo de certificados EPS.";
            }
        }
        
        if (isset($_FILES['carnet_vacunas']) && $_FILES['carnet_vacunas']['error'] === UPLOAD_ERR_OK) {
            $carnetVacunas = $_FILES['carnet_vacunas']['name'];
            $carnetVacunasTemp = $_FILES['carnet_vacunas']['tmp_name'];
            $fileType = mime_content_type($carnetVacunasTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de carnet de vacunas debe ser un PDF.");
            }
            $pdfContent = file_get_contents($carnetVacunasTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            if ($numPages > 5) {
                echo 'Error: El archivo de carnet de vacunas no puede tener más de 5 páginas.';
                exit;
            }
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileVacunas = $uploadDir . basename($carnetVacunas);
            if (move_uploaded_file($carnetVacunasTemp, $uploadFileVacunas)) {
                // El archivo se guardó correctamente
            } else {
                echo "Error al guardar el archivo de carnet de vacunas.";
                $uploadFileVacunas = "no";  // En caso de error al mover el archivo, asignamos "no"
            }
            
            // Otro bloque else para cuando no se haya cargado ningún archivo
            if (!isset($_FILES['carnet_vacunas']) || $_FILES['carnet_vacunas']['error'] !== UPLOAD_ERR_OK) {
                $uploadFileVacunas = "no";  // Si no se cargó el archivo correctamente, asignamos "no"
            }            
        } 
        
        if (isset($_FILES['certificacion_bancaria']) && $_FILES['certificacion_bancaria']['error'] === UPLOAD_ERR_OK) {
            $certificacionBancaria = $_FILES['certificacion_bancaria']['name'];
            $certificacionBancariaTemp = $_FILES['certificacion_bancaria']['tmp_name'];
            $fileType = mime_content_type($certificacionBancariaTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificación bancaria debe ser un PDF.");
            }
            $pdfContent = file_get_contents($certificacionBancariaTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            if ($numPages > 1) {
                echo 'Error: El archivo de certificación bancaria no puede tener más de 1 página.';
                exit;
            }
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileBancaria = $uploadDir . basename($certificacionBancaria);
            if (move_uploaded_file($certificacionBancariaTemp, $uploadFileBancaria)) {
            } else {
                echo "Error al guardar el archivo de certificación bancaria.";
            }
        } 
        
        if (isset($_FILES['certificado_antecedentes']) && $_FILES['certificado_antecedentes']['error'] === UPLOAD_ERR_OK) {
            $certificadosAntecedentes = $_FILES['certificado_antecedentes']['name'];
            $certificadosAntecedentesTemp = $_FILES['certificado_antecedentes']['tmp_name'];
            $fileType = mime_content_type($certificadosAntecedentesTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificado de antecedentes debe ser un PDF.");
            }
            $pdfContent = file_get_contents($certificadosAntecedentesTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            if ($numPages > 1) {
                echo 'Error: El archivo de certificado de antecedentes no puede tener más de 1 página.';
                exit;
            }
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileAntecedentes = $uploadDir . basename($certificadosAntecedentes);
            if (move_uploaded_file($certificadosAntecedentesTemp, $uploadFileAntecedentes)) {
            } else {
                echo "Error al guardar el archivo de certificado de antecedentes.";
            }
        }
        
        if (isset($_FILES['certificado_afp']) && $_FILES['certificado_afp']['error'] === UPLOAD_ERR_OK) {
            $certificadosAfp = $_FILES['certificado_afp']['name'];
            $certificadosAfpTemp = $_FILES['certificado_afp']['tmp_name'];
            $fileType = mime_content_type($certificadosAfpTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificado de AFP debe ser un PDF.");
            }
            $pdfContent = file_get_contents($certificadosAfpTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            if ($numPages > 1) {
                echo 'Error: El archivo de certificado de AFP no puede tener más de 1 página.';
                exit;
            }
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileAfp = $uploadDir . basename($certificadosAfp);
            if (move_uploaded_file($certificadosAfpTemp, $uploadFileAfp)) {
            } else {
                echo "Error al guardar el archivo de certificado de AFP.";
            }
        } 
        
        if (isset($_FILES['subir_cedula']) && $_FILES['subir_cedula']['error'] === UPLOAD_ERR_OK) {
            $subirCedula = $_FILES['subir_cedula']['name'];
            $subirCedulaTemp = $_FILES['subir_cedula']['tmp_name'];
            $fileType = mime_content_type($subirCedulaTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de la cédula debe ser un PDF.");
            }
            $pdfContent = file_get_contents($subirCedulaTemp);
            $numPages = preg_match_all("/\/Type\s*\/Page[^s]/", $pdfContent, $matches);
            if ($numPages > 1) {
                echo 'Error: El archivo de la cédula no puede tener más de 1 página.';
                exit;
            }
            $uploadDir = "../../uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileCedula = $uploadDir . basename($subirCedula);
            if (move_uploaded_file($subirCedulaTemp, $uploadFileCedula)) {
            } else {
                echo "Error al guardar el archivo de la cédula.";
            }
        } else {
            $uploadFileCedula = '';  
        }

        $stmt = $conn->prepare("INSERT INTO usuarios_r (nombres, apellidos,genero, cedula, telefono, fecha_nacimiento, lugar_nacimiento, direccion,
                                fecha_expedicion_cedula, correo, municipio_residencia, nombre_contacto, telefono_contacto, tipo_sangre, eps, fondo_pension, arl, hoja_vida, subir_cedula, certificados_estudio, 
                                certificados_laborales, foto, certificados_eps,carnet_vacunas,certificacion_bancaria,certificado_antecedentes,certificado_afp,certificados_territorialidad,talla_camisa, 
                                talla_pantalon,talla_botas,talla_nomex, enviado) 
                                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Vincular parámetros a la sentencia SQL
        $stmt->bind_param(
            "ssssssssssssssssssssssssssssssssi",
            $nombres,$apellidos,$genero,$cedula,$telefono,$fechaNacimiento,$lugar_nacimiento,$direccion,
            $fecha_expedicion_cedula,$correo,$municipio_residencia,$nombre_1,$telefono_1,$tipo_sangre,$eps,$fondo_pension,$arl,$uploadFile,
            $uploadFileCedula,$uploadFileEstudios,$uploadFileLaborales,$uploadFileImagen,$uploadFileEps,$uploadFileVacunas,
            $uploadFileBancaria,$uploadFileAntecedentes,$uploadFileAfp,$uploadFileTerritoriales,$talla_camisa,$talla_pantalon,
            $talla_botas,$talla_nomex,$enviado
        );
        
        if ($stmt->execute()) {
            echo "Datos registrados exitosamente...";
        } else {
            echo "Error: " . $stmt->error;
        }       
        $stmt->close();
    }
}
$conn->close();
?>
