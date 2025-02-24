<?php
session_start();
include('../../config/db.php');
require('../../vendor/autoload.php');

use ZipArchive;

// Obtener el anio_id de la URL
$anio_id = isset($_GET['anio_id']) ? $_GET['anio_id'] : ""; // Valor predeterminado

// Proceso para descargar archivos seleccionados
if (isset($_POST['cedula']) && isset($_POST['archivos'])) {
    $cedula = $_POST['cedula'];
    $archivosSeleccionados = $_POST['archivos'];

    // Usar consultas preparadas para evitar inyecciones SQL
    $sql = "SELECT * FROM usuarios_r WHERE cedula = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $cedula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($result);

    if ($usuario) {
        $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/controllers/uploads/';
        $archivos = [
            'hoja_vida' => $usuario['hoja_vida'],
            'subir_cedula' => $usuario['subir_cedula'],
            'certificados_estudio' => $usuario['certificados_estudio'],
            'certificados_laborales' => $usuario['certificados_laborales'],
            'foto' => $usuario['foto'],
            'certificados_territorialidad' => $usuario['certificados_territorialidad'],
        ];

        $zip = new ZipArchive();
        $nombreZip = 'archivos_seleccionados_' . $cedula . '.zip';
        $rutaZip = $uploadsDir . $nombreZip;

        if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            die("No se pudo crear el archivo ZIP.");
        }

        foreach ($archivosSeleccionados as $tipo) {
            if (!empty($archivos[$tipo])) {
                $rutaArchivo = $uploadsDir . basename($archivos[$tipo]);
                if (file_exists($rutaArchivo)) {
                    $nombreArchivo = basename($archivos[$tipo]);

                    $i = 1;
                    $archivoOriginal = $nombreArchivo;
                    while ($zip->locateName($nombreArchivo)) {
                        $nombreArchivo = pathinfo($archivoOriginal, PATHINFO_FILENAME) . '_' . $i . '.' . pathinfo($archivoOriginal, PATHINFO_EXTENSION);
                        $i++;
                    }

                    $zip->addFile($rutaArchivo, $nombreArchivo);
                }
            }
        }

        $zip->close();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $nombreZip . '"');
        header('Content-Length: ' . filesize($rutaZip));
        readfile($rutaZip);
        unlink($rutaZip);
        exit;
    } else {
        die("Usuario no encontrado.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <title>Seleccionar Archivos para Descargar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#E1EEE2] font-sans">
<header class="w-full bg-white border-b-4 border-green-900">
    <div class="container mx-auto flex flex-wrap p-5 items-center justify-between">
        <a href="../index.php" class="text-gray-900">
            <img src="/static/img/TF.png" alt="Logo" class="h-16 md:h-20">
        </a>
        <!-- Botón de menú en móviles -->
        <div class="block lg:hidden">
            <button id="menuToggle" class="text-green-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Menú de navegación (se oculta en pantallas pequeñas) -->
        <nav id="navMenu" class="hidden lg:flex lg:items-center lg:space-x-8">
            <a href="/admin/años.php" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">AÑOS</a>
            <a href="/admin/index.php" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">PROYECTOS</a>
            <a href="rtaSegundoForm.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">RTA DATOS EPP</a>
            <a href="#" onclick="mostrarFormularioUsuarios();" class="text-green-900 hover:text-lime-600 font-bold py-2 px-4 rounded-md border-2 border-green-900 hover:bg-green-900 hover:text-white transition text-sm md:text-lg">
                ENV FORM DATOS EPP
            </a>
        </nav>

        <!-- Botón de cierre de sesión -->
        <div class="hidden lg:block">
            <a href="../../../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-sm md:text-base">Cerrar sesión</a>
        </div>
    </div>

    <!-- Menú desplegable en móviles (oculto por defecto) -->
    <div id="mobileMenu" class="lg:hidden bg-white w-full px-5 py-3 space-y-4 text-center hidden">
        <a href="/admin/años.php" class="block text-green-900 hover:text-lime-600 font-bold text-lg">AÑOS</a>
        <a href="/admin/index.php" class="block text-green-900 hover:text-lime-600 font-bold text-lg">PROYECTOS</a>
        <a href="rtaSegundoForm.php?anio_id=<?php echo $anio_id; ?>" class="block text-green-900 hover:text-lime-600 font-bold text-lg">RTA DATOS EPP</a>
        <a href="#" onclick="mostrarFormularioUsuarios();" class="block text-green-900 hover:text-lime-600 font-bold text-lg py-2 px-4 rounded-md border-2 border-green-900 hover:bg-green-900 hover:text-white">
            ENV FORM DATOS EPP
        </a>
        <a href="../../../logout.php" class="block text-green-600 hover:text-lime-500 font-bold py-3 px-4 rounded-lg text-lg">Cerrar sesión</a>
    </div>
</header>

<!-- Script para mostrar/ocultar el menú en móviles -->
<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        var menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });
</script>

<div class="w-full md:w-1/3 mx-auto p-8 bg-white rounded-lg shadow-lg mt-10">
    <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Seleccionar Archivos para Descargar</h1>

    <!-- Formulario de búsqueda de cedula -->
    <form action="" method="get" class="space-y-4 mb-6">
        <input type="hidden" name="anio_id" value="<?php echo $anio_id; ?>">
        <div>
            <label for="cedula" class="block text-gray-700 font-medium">Ingrese la cédula del usuario:</label>
            <input type="text" id="cedula" name="cedula" value="<?php echo isset($_GET['cedula']) ? $_GET['cedula'] : ''; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Buscar Archivos</button>
        </div>
    </form>
    <?php
    if (isset($_GET['cedula'])) {
        $cedula = $_GET['cedula'];
        $sql = "SELECT * FROM usuarios_r WHERE cedula = '$cedula'";
        $result = mysqli_query($conn, $sql);
        $usuario = mysqli_fetch_assoc($result);

        if ($usuario) {
            $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/controllers/uploads/';
            $archivos = [
                'hoja_vida' => $usuario['hoja_vida'],
                'subir_cedula' => $usuario['subir_cedula'],
                'certificados_estudio' => $usuario['certificados_estudio'],
                'certificados_laborales' => $usuario['certificados_laborales'],
                'foto' => $usuario['foto'],
                'certificados_territorialidad' => $usuario['certificados_territorialidad'],
            ];

            echo '<form action="" method="POST" id="downloadForm">';
            echo '<input type="hidden" name="cedula" value="' . $cedula . '">';
            echo '<h2 class="text-xl font-semibold text-gray-800 mb-4">Archivos Disponibles:</h2>';
            echo '<div class="space-y-4">';
            foreach ($archivos as $tipo => $archivo) {
                if (!empty($archivo)) {
                    $rutaArchivo = $uploadsDir . basename($archivo);
                    if (file_exists($rutaArchivo)) {
                        echo '<div class="flex items-center space-x-2">';
                        echo '<input type="checkbox" name="archivos[]" value="' . $tipo . '" id="' . $tipo . '" class="h-5 w-5 text-blue-600 rounded">';
                        echo '<label for="' . $tipo . '" class="text-gray-700">' . ucfirst(str_replace('_', ' ', $tipo)) . '</label>';
                        echo '</div>';
                    }
                }
            }
            echo '</div>';
            echo '<div class="mt-6">';
            echo '<button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Descargar Archivos Seleccionados</button>';
            echo '</div>';
            echo '</form>';
        } else {
            echo '<p class="text-center text-red-600">Usuario no encontrado.</p>';
        }
    }
    ?>
</div>

<script>
    document.getElementById('downloadForm').addEventListener('submit', function() {
        setTimeout(() => {
            Swal.fire({
                title: "Descarga completada",
                text: "Los archivos seleccionados han sido descargados.",
                icon: "success",
                draggable: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const urlParams = new URLSearchParams(window.location.search);
                    const anio_id = urlParams.get('anio_id'); 
                    if (anio_id) {
                        window.location.href = `http://localhost:3000/admin/public/rtaPrimerForm.php?anio_id=${anio_id}`;
                    } else {
                        window.location.href = "http://localhost:3000/admin/index.php";
                    }
                }
            });
        }, 1000);
    });
</script>

</body>
</html>
