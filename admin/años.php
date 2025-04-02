<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

// Manejar la creación de un nuevo proyecto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title = $_POST['title'];
    $sql = "INSERT INTO anios (titulo) VALUES ('$title')";
    mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="icon" href="/static/img/TF.ico" type="image/x-icon">
    <link rel="stylesheet" href="/admin/includes/css/años.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tf auditores y asesores SAS BIC</title>

    <!-- Estilos adicionales para ajustar la alerta -->
    <style>
        /* En pantallas pequeñas (celulares) ajustamos el header */
        @media (max-width: 640px) {
            header {
                padding-top: 10px; /* Menos espacio en la parte superior */
                padding-bottom: 10px; /* Menos espacio en la parte inferior */
            }
            /* Deja la alerta debajo del header */
            #toast-warning {
                top: 100px; /* Ajuste en celulares */
            }
        }

        /* En pantallas grandes (como escritorios) mantenemos el header estándar */
        @media (min-width: 641px) {
            header {
                padding-top: 10px; 
                padding-bottom: 10px;
            }
            /* Mueve la alerta un poco más arriba en escritorios */
            #toast-warning {
                top: 4px; /* Ajuste en PC, un poco más arriba */
            }
        }

        /* Estilo para la alerta debajo del header */
        #toast-warning {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: none;
        }
    </style>
</head>
<body class="bg-[#E1EEE2] font-sans">
<header class="w-full bg-white mb-7 border-b-4 border-green-900">
    <div class="container mx-auto flex flex-wrap p-2.5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <img src="/static/img/TF.png" alt="" class="h-20 ml-2.5">
        </a>
        <div class="flex flex-wrap items-center text-base justify-center" style="transform: translateX(1149px);"> 
            <a href="../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-xs md:text-sm flex items-center">
                <img src="/admin/includes/imgs/cerrarsesion.png" class="w-4 h-4 mr-2" alt="Cerrar Sesión"/>  
                CERRAR SESIÓN
            </a>
        </div>
    </div>
</header>
<div class="mx-4 sm:mx-12">
    <!-- Botón para abrir el modal, centrado -->
    <div class="flex justify-center">
        <button class="bg-green-600 hover:bg-lime-500 text-white font-bold py-2 px-8 sm:py-4 sm:px-16 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-100 focus:ring-opacity-50" onclick="openModal()">
            <strong>Crear año</strong>
        </button>
    </div>

    <!-- Modal para ingresar el título -->
    <div id="projectModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Nuevo año</h2>
                <span onclick="closeModal()" class="text-2xl font-bold text-gray-600 cursor-pointer">&times;</span>
            </div>
            <input type="text" id="projectTitle" placeholder="Título del año" class="w-full p-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" maxlength="4">
            <button onclick="submitProject()" class="w-full bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-100 focus:ring-opacity-50">
                Crear 
            </button>
        </div>
    </div>

    <!-- Contenedor de proyectos centrado con grid y 4 columnas max por fila -->
    <div id="projectsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mt-5 justify-center max-w-screen-lg mx-auto">
        <?php
            $sql = "SELECT * FROM anios";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <div class='project-container bg-slate-50 text-red rounded-lg p-6 w-full text-center font-medium shadow-lg flex-col justify-between items-center' data-id='{$row['id']}'>
                        <a href='index.php?anio_id={$row['id']}' class='title font-bold mb-3 text-lg text-black'>
                            {$row['titulo']}
                        </a>
                    </div>";
                }
            } else {
                echo "<p class='w-full text-center text-lg text-gray-700'>No hay proyectos disponibles.</p>";
            }
        ?>
    </div>
</div>

<!-- Toast de advertencia -->
<div id="toast-warning" class="flex items-center w-full max-w-xs p-4 text-black bg-orange-100 rounded-lg shadow border border-orange-500 dark:text-gray-400 dark:bg-gray-800" role="alert">
    <div class="ms-3 text-sm font-normal">El registro siempre se mantiene.</div>
    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-black hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 border border-orange-500" data-dismiss-target="#toast-warning" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>

<script src="/admin/includes/js/años.js"></script>
</body>
</html>
