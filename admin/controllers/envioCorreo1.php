<?php
error_reporting(E_ALL); // Mostrar todos los errores
ini_set('display_errors', 1); // Habilitar la visualización de errores

// Incluir el autoload de Composer para cargar PHPMailer y otras dependencias
require_once '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Función para enviar correos electrónicos con un enlace
function enviarCorreoConLink($correo, $link) {
    $mail = new PHPMailer(true);  // Crear una nueva instancia de PHPMailer
    $mail->isSMTP();             // Establecer el uso de SMTP
    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
    $mail->SMTPAuth = true;         // Habilitar la autenticación SMTP
    $mail->Username = 'pruebasoftwarerc@gmail.com';
    $mail->Password = 'abkgbjoekgsvhtnj'; // Contraseña de la aplicación generada en Google
    $mail->SMTPSecure = 'tls';      // Encriptación TLS
    $mail->Port = 587;              // Puerto para TLS
    
    // Activar depuración para mostrar detalles del error (útil para verificar problemas)
    $mail->SMTPDebug = 2; // Modo de depuración para ver información de conexión
    $mail->Debugoutput = 'html'; // Salida de la depuración en formato HTML

    try {
        $mail->setFrom('pruebassoftaware@gmail.com'); // Dirección desde la que se envía
        $mail->addAddress($correo); // Dirección del destinatario
    
        // Configurar el correo
        $mail->isHTML(true); // Configurar el correo como HTML
        $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres como UTF-8 para permitir caracteres especiales
        $mail->Subject = 'Solicitud Documentación Proceso de Selección / TF Auditores y Asesores S.A.S. BIC'; // Asunto del correo
        
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

        // Intentar enviar el correo
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Retornar el error si el correo no se envió
        return "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}    

// Obtener los correos seleccionados desde el formulario
if (isset($_POST['usuarios']) && is_array($_POST['usuarios'])) {
    $correosSeleccionados = $_POST['usuarios'];
} else {
    die('No se seleccionaron usuarios.');
}

// Obtener el anio_id de la URL
$anio_id = $_GET['anio_id'] ?? null;

if (!$anio_id) {
    // Si no se pasa el anio_id, redirigir o mostrar error
    die('No se especificó el anio_id.');
}

// Enlace que se enviará
$link = 'http://localhost:3000/admin/public/formularios/form1.php'; // Enlace proporcionado

// Variable para almacenar el resultado
$mensajeEnviado = false;
$resultado = '';
$errores = [];

// Enviar el correo solo a los usuarios seleccionados
foreach ($correosSeleccionados as $correo) {
    $envio = enviarCorreoConLink($correo, $link);
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
    // Si no hubo errores, marcar el mensaje como enviado
    $mensajeEnviado = true;
}

// Obtener la URL de referencia (página anterior)
$paginaAnterior = $_SERVER['HTTP_REFERER'] ?? '/admin/public/registrarUsuarios.php'; // Si no hay página anterior, redirige a esta página por defecto

// Preparar los mensajes para la redirección
if ($mensajeEnviado) {
    $mensaje = 'El mensaje se envió correctamente a los siguientes usuarios: ' . $resultado;
    $status = 'success';
} else {
    $mensaje = 'Hubo un problema al enviar el mensaje. Detalles: ' . $resultado;
    $status = 'error';
}

// Redirigir con el mensaje y el estado
header("Location: $paginaAnterior?status=$status&message=" . urlencode($mensaje));
exit; // Detener la ejecución del script
?>
