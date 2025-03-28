<?php
session_start();
if (isset($_SESSION['email_sent']) && $_SESSION['email_sent'] === true) {
    die('El correo ya fue enviado.');
}
$_SESSION['email_sent'] = true;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoConLink($correo, $link, $asunto) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pruebasoftwarerc@gmail.com';
    $mail->Password = 'abkgbjoekgsvhtnj';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('pruebassoftaware@gmail.com');
    $mail->addAddress($correo);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $asunto; // Asunto personalizado

    // Cuerpo del correo con el mensaje completo (incluyendo la imagen)
    $mail->Body = "<p>Buen día</p>
    <p>Estimado (a) Aspirante,</p>
    <p>Cordial saludo.</p>
    <p>Dando continuidad al proceso de selección, agradecemos nos envíe en su mayor brevedad y por este medio la siguiente información; la cual entraría en proceso de revisión y validación:</p>
    <ul>
        <li>Hoja de vida actualizada</li>
        <li>Fotocopia de la cédula ampliada al 150% (Legible)</li>
        <li>Certificados de estudios</li>
        <li>Certificaciones laborales (Que especifiquen el cargo y la experiencia)</li>
        <li>Certificado de EPS y Pensiones AFP (Expedido en los últimos 30 días)</li>
        <li>Carnet de vacunas (Tétano, Fiebre Amarilla y Covid-19)</li>
        <li>Certificación bancaria vigente</li>
        <li>Foto con fondo blanco (3x4)</li>
        <li>Talla de dotación (Camisa, Pantalón, Botas y Nomex)</li>
        <li>Nombre y número de contacto de persona en caso de emergencia</li>
        <li>Certificado de antecedentes (Policía, Contraloría y Procuraduría)</li>
        <li>Certificado de Territorialidad vigente (Expedido por la Alcaldía Municipal)</li>
    </ul>
    <p>Tenga en cuenta que solo se recibirán documentos a través del formulario, por lo que le pedimos no enviarlos como respuesta a este correo.</p>
    <p>Para completar el proceso, haga clic en el siguiente enlace y diligencie el formulario: <a href='$link'>$link</a></p>
    <p>Si tiene alguna duda o inquietud, no dude en escribirnos.</p>
    <p>Quedamos atentos.</p>
    <p>Cordialmente,</p>
    <p><img src='https://ci3.googleusercontent.com/mail-sig/AIorK4xDtnmL2WFQQ7IRuTdhbImcO-A1y00KZeOwt2ILLlaWg76zGD38C9qf4752x3_5Quf5iLnx8Onyz5zh' alt='Imagen TFAYA' style='display: block; width: 40%; margin: 10px;'></p>
    <p style='color: #3E761D;'>Este mensaje y sus archivos adjuntos van dirigidos exclusivamente a su destinatario pudiendo contener información confidencial sometida a secreto profesional. No está permitida su reproducción o distribución sin la autorización expresa de TF Auditores y Asesores S.A.S BIC. Si usted no es el destinatario final por favor elimínelo e infórmenos por esta vía. De acuerdo con la Ley Estatutaria 1581 de 2012 de Protección de Datos y con el Decreto 1074 de 2015, el titular presta su consentimiento para que sus datos, facilitados voluntariamente pasen a formar parte de una base de datos, cuyo responsable es TF Auditores y Asesores S.A.S BIC, cuyas finalidades son: la gestión administrativa de la entidad, así como la gestión de carácter comercial y el envío de comunicaciones comerciales sobre nuestros productos y/o servicios.</p>
    <p style='color: #3E761D;'>Puede usted ejercitar los derechos de acceso, corrección, supresión, revocación o reclamo por infracción sobre sus datos, mediante escrito dirigido a TF Auditores y Asores S.A.S BIC, a la dirección de correo electrónico pqr@tfauditores.com, indicando en el asunto el derecho que desea ejercitar.</p>";

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}

// Obtener los correos seleccionados desde el formulario
if (isset($_POST['usuarios']) && is_array($_POST['usuarios'])) {
    $correosSeleccionados = array_unique($_POST['usuarios']);
} else {
    die('No se seleccionaron usuarios.');
}

// Obtener los asuntos personalizados
$asuntos = $_POST['asunto'] ?? [];

// Enlace que se enviará
$link = 'http://localhost:3000/admin/public/formularios/form1.php';

// Variable para almacenar el resultado
$mensajeEnviado = false;
$resultado = '';
$errores = [];

// Enviar el correo solo a los usuarios seleccionados
foreach ($correosSeleccionados as $correo) {
    $asunto = $asuntos[$correo] ?? 'Solicitud Documentación Proceso de Selección / TF Auditores y Asesores S.A.S. BIC'; // Asunto personalizado o predeterminado

    $envio = enviarCorreoConLink($correo, $link, $asunto);
    
    if ($envio !== true) {
        $errores[] = $envio;
    } else {
        $resultado .= 'El mensaje se envió correctamente a ' . $correo . '<br>';
    }
}

// Si hubo errores, mostramos los mensajes de error
if (count($errores) > 0) {
    $resultado = implode('<br>', $errores);
} else {
    $mensajeEnviado = true;
}

// Redirigir con el mensaje y el estado
$paginaAnterior = $_SERVER['HTTP_REFERER'] ?? '/admin/public/registrarUsuarios.php'; 
$mensaje = $mensajeEnviado ? 'El mensaje se envió correctamente a los siguientes usuarios: ' . $resultado 
                           : 'Hubo un problema al enviar el mensaje. Detalles: ' . $resultado;
$status = $mensajeEnviado ? 'success' : 'error';
header("Location: $paginaAnterior?status=$status&message=" . urlencode($mensaje));
exit;
