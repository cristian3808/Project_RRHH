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
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $tipo_sangre = $_POST['tipo_sangre'];
    $certificadosEps = $_POST['certificados_eps'];
    $carnetVacunas = $_POST['carnet_vacunas'];
    $certificacionBancaria = $_POST['certificacion_bancaria'];
    $certAntecedentePolicia = $_POST['cert_antecedente_policia'];
    $certAntecedenteContraloria = $_POST['cert_antecedente_contraloria'];
    $certAntecedenteProcuraduria = $_POST['cert_antecedente_procuraduria'];
    $certificadosAfp = $_POST['certificado_afp'];
    $fondo_pension = $_POST['fondo_pension'];
    $arl = $_POST['arl'];
    $talla_camisa = $_POST['talla_camisa'];
    $talla_pantalon = $_POST['talla_pantalon'];
    $talla_botas = $_POST['talla_botas'];
    $talla_nomex = $_POST['talla_nomex'];
    $enviado = 0;
    $estado_civil = $_POST['estado_civil'];
    $nombre_pareja = $_POST['nombre_pareja'];
    $tiene_hijos = $_POST['tiene_hijos'];
    $cuantos_hijos = $_POST['cuantos_hijos'];

    $nombre_completo_hijo = $_POST['nombre_completo_hijo'];
    $tipo_documento_hijo = $_POST['tipo_documento_hijo'];
    $numero_documento_hijo = $_POST['numero_documento_hijo'];
    $parentesco_hijo = $_POST['parentesco_hijo'];
    $edad_hijo = $_POST['edad_hijo'];

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
           
            //Guardar el archivo
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
        
        if (isset($_FILES['cert_antecedente_policia']) && $_FILES['cert_antecedente_policia']['error'] === UPLOAD_ERR_OK) {
            $certAntecedentePolicia = $_FILES['cert_antecedente_policia']['name'];
            $certAntecedentePoliciaTemp = $_FILES['cert_antecedente_policia']['tmp_name'];
            $fileType = mime_content_type($certAntecedentePoliciaTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificado de antecedentes debe ser un PDF.");
            }
           
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileAntecedentePolicial = $uploadDir . basename($certAntecedentePolicia);
            if (move_uploaded_file($certificadosAntecedentePolicialTemp, $uploadFileAntecedentePolicial)) {
            } else {
                echo "Error al guardar el archivo de certificado de antecedente policia.";
            }
        }

        if (isset($_FILES['cert_antecedente_contraloria']) && $_FILES['cert_antecedente_contraloria']['error'] === UPLOAD_ERR_OK) {
            $certAntecedenteContraloria = $_FILES['cert_antecedente_contraloria']['name'];
            $certAntecedenteContraloriaTemp = $_FILES['cert_antecedente_contraloria']['tmp_name'];
            $fileType = mime_content_type($certAntecedenteContraloriaTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificado de antecedentes debe ser un PDF.");
            }
           
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileAntecedenteContraloria = $uploadDir . basename($certAntecedenteContraloria);
            if (move_uploaded_file($certificadosAntecedenteContraloriaTemp, $uploadFileAntecedenteContraloria)) {
            } else {
                echo "Error al guardar el archivo de certificado de antecedente contraloria.";
            }
        }

        if (isset($_FILES['cert_antecedente_procuraduria']) && $_FILES['cert_antecedente_procuraduria']['error'] === UPLOAD_ERR_OK) {
            $certAntecedenteProcuraduria = $_FILES['cert_antecedente_procuraduria']['name'];
            $certAntecedenteProcuraduriaTemp = $_FILES['cert_antecedente_procuraduria']['tmp_name'];
            $fileType = mime_content_type($certAntecedenteProcuraduriaTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificado de antecedentes debe ser un PDF.");
            }
           
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  
            }
            $uploadFileAntecedenteProcuraduria = $uploadDir . basename($certAntecedenteProcuraduria);
            if (move_uploaded_file($certificadosAntecedenteProcuraduriaTemp, $uploadFileAntecedenteProcuraduria)) {
            } else {
                echo "Error al guardar el archivo de certificado de antecedente policia.";
            }
        }
        
        if (isset($_FILES['certificado_afp']) && $_FILES['certificado_afp']['error'] === UPLOAD_ERR_OK) {
            $certificadosAfp = $_FILES['certificado_afp']['name'];
            $certificadosAfpTemp = $_FILES['certificado_afp']['tmp_name'];
            $fileType = mime_content_type($certificadosAfpTemp);
            if ($fileType !== 'application/pdf') {
                die("Error: El archivo de certificado de AFP debe ser un PDF.");
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

        // Insertar en la tabla usuarios_r
        $stmt_usuarios = $conn->prepare("INSERT INTO usuarios_r (
            nombres, apellidos, genero, cedula, telefono, fecha_nacimiento, lugar_nacimiento, direccion,
            fecha_expedicion_cedula, correo, municipio_residencia, nombre_contacto, telefono_contacto, tipo_sangre, eps, 
            fondo_pension, arl, hoja_vida, subir_cedula, certificados_estudio, certificados_laborales, foto, certificados_eps, 
            carnet_vacunas, certificacion_bancaria, cert_antecedente_policia,cert_antecedente_contraloria,cert_antecedente_procuraduria, 
            certificado_afp, certificados_territorialidad,talla_camisa, talla_pantalon, talla_botas, talla_nomex, enviado, estado_civil, 
            nombre_pareja, tiene_hijos, cuantos_hijos) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt_usuarios) {
            die("Error en la preparación de la consulta de usuarios: " . $conn->error);
        }

        $stmt_usuarios->bind_param(
            "sssssssssssssssssssssssssssssssssissssi",
            $nombres, $apellidos, $genero, $cedula, $telefono, $fechaNacimiento, $lugar_nacimiento, $direccion,
            $fecha_expedicion_cedula, $correo, $municipio_residencia, $nombre_contacto, $telefono_contacto, $tipo_sangre, $eps, 
            $fondo_pension, $arl, $uploadFile, $uploadFileCedula, $uploadFileEstudios, $uploadFileLaborales, $uploadFileImagen, 
            $uploadFileEps, $uploadFileVacunas, $uploadFileBancaria, $uploadFileAntecedentePolicial, $uploadFileAntecedenteContraloria, 
            $uploadFileAntecedenteProcuraduria,$uploadFileAfp, $uploadFileTerritoriales, $talla_camisa, $talla_pantalon, $talla_botas, 
            $talla_nomex, $enviado, $estado_civil, $nombre_pareja, $tiene_hijos, $cuantos_hijos
        );

        // Ejecutar inserción en `usuarios_r`
        if ($stmt_usuarios->execute()) {
            // Obtener el ID del usuario recién insertado
            $usuario_id = $stmt_usuarios->insert_id;
            
            // Insertar en la tabla hijos
            $stmt_hijos = $conn->prepare("INSERT INTO hijos (usuario_id,nombre_completo_hijo,tipo_documento_hijo,numero_documento_hijo,parentesco_hijo,edad_hijo) 
            VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt_hijos) {
                die("Error en la preparación de la consulta de hijos: " . $conn->error);
            }
            
            $stmt_hijos->bind_param("isssss", $usuario_id, $nombre_completo_hijo, $tipo_documento_hijo, $numero_documento_hijo, $parentesco_hijo, $edad_hijo);
            
            // Recorrer los nombres de los hijos y guardarlos
            for ($i = 1; $i <= intval($_POST["cuantos_hijos"]); $i++) {
                if (isset($_POST["nombre_completo_hijo_$i"],$_POST["tipo_documento_hijo_$i"])) {
                    $nombre_completo_hijo = $_POST["nombre_completo_hijo_$i"];
                    $tipo_documento_hijo = $_POST["tipo_documento_hijo_$i"];
                    $numero_documento_hijo = $_POST["numero_documento_hijo_$i"];
                    $parentesco_hijo = $_POST["parentesco_hijo_$i"];
                    $edad_hijo = $_POST["edad_hijo_$i"];
                    $stmt_hijos->execute();
                }
            }
            
            echo "Usuario y sus hijos registrados correctamente.";
        } else {
            echo "Error al insertar usuario: " . $stmt_usuarios->error;
        }
    }
}
$conn->close();
?>
