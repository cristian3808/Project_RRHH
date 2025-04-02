<?php
session_start();
include('../config/db.php'); // Configuración de la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

// Verificar si se ha pasado el parámetro anio_id en la URL
$anio_id = isset($_GET['anio_id']) ? (int)$_GET['anio_id'] : 1; // Default a 1 si no se pasa el parámetro

// Manejar la creación de un nuevo proyecto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    // Insertar el nuevo proyecto asociado al año
    $sql = "INSERT INTO proyectos (titulo, anio_id) VALUES ('$title', $anio_id)";
    if (!mysqli_query($conn, $sql)) {
        echo "Error al crear el proyecto: " . mysqli_error($conn);
    }
}

// Manejar la edición de un proyecto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id']) && isset($_POST['edit_title'])) {
    $edit_id = (int)$_POST['edit_id'];
    $edit_title = mysqli_real_escape_string($conn, $_POST['edit_title']);

    $sql = "UPDATE proyectos SET titulo = '$edit_title' WHERE id = $edit_id";
    if (!mysqli_query($conn, $sql)) {
        echo "Error al editar el proyecto: " . mysqli_error($conn);
    }
}

// Manejar la eliminación de un proyecto
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    // Eliminar el proyecto de la tabla 'proyectos'
    $sql = "DELETE FROM proyectos WHERE id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        echo "Proyecto eliminado exitosamente.";
        // Redirigir a la página actual para actualizar la lista de proyectos
        header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=" . $anio_id);
        exit;
    } else {
        echo "Error al eliminar el proyecto: " . mysqli_error($conn);
    }
}

// Obtener el nombre del proyecto
$sql_project = "SELECT titulo FROM anios WHERE id = '$anio_id'";
$result_project = mysqli_query($conn, $sql_project);
$project_name = '';

if (mysqli_num_rows($result_project) > 0) {
    $row_project = mysqli_fetch_assoc($result_project);
    $project_name = $row_project['titulo'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="/admin/includes/css/index.css">
    <link rel="icon" href="/static/img/TF.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tf auditores y asesores SAS BIC</title>
</head>
<body class="bg-[#E1EEE2] font-sans">
<header class="w-full bg-white mb-10 border-b-4 border-green-900">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <img src="/static/img/TF.png" alt="" class="h-20">
        </a>
        <div class="ml-auto flex flex-wrap items-center text-base justify-center"> 
            <a href="../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-xs md:text-sm flex items-center">
            <img src="/admin/includes/imgs/cerrarsesion.png" class="w-4 h-4 mr-2" alt="Cerrar Sesión"/>  
            CERRAR SESIÓN</a>
        </div>
    </div>
</header>
<div class="px-4 sm:px-10 lg:px-60">
    
    <p class="text-m mb-6">Crear proyecto para el año : <strong><?php echo htmlspecialchars($project_name); ?></strong></p>
    <!-- Botón para abrir el modal -->
    <button class="bg-green-600 hover:bg-lime-500 text-white font-bold py-4 px-8 sm:px-10 lg:px-16 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-100 focus:ring-opacity-50" onclick="openModal()">
        <strong>Crear Proyecto</strong>
    </button>

    <!-- Modal para ingresar el título -->
<div id="projectModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-96">
        <div class="flex justify-center items-center mb-4 relative">
            <h2 class="text-xl font-semibold">Nuevo Proyecto</h2>
            <!-- X centrada verticalmente con respecto al título -->
            <span onclick="closeModal()" class="text-2xl font-bold text-gray-600 cursor-pointer absolute right-[-20px] top-[-10px] transform -translate-y-1/2">
                &times;
            </span>
        </div>

        <input type="text" id="projectTitle" placeholder="Título del Proyecto" class="w-full p-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#2FA74D]">

        <!-- Botón centrado y con mejor tamaño -->
        <div class="flex justify-center">
            <button class="bg-green-600 hover:bg-lime-500 text-white font-bold px-6 py-2 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-100 focus:ring-opacity-50" onclick="submitProject()">
                <strong>Crear</strong>
            </button>
        </div>
    </div>
</div>

    <!-- Modal para editar el título -->
<div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-96">
        <div class="flex justify-center items-center mb-4 relative">
            <h2 class="text-xl font-semibold">Editar Proyecto</h2>
            <span onclick="closeEditModal()" class="text-2xl font-bold text-gray-600 cursor-pointer absolute top-[-30px] right-[-20px]">
                &times;
            </span>
        </div>

        <input type="text" id="editProjectTitle" placeholder="Nuevo Título del Proyecto" class="w-full p-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

        <button onclick="submitEditProject()" class="w-full bg-blue-500 hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-lg shadow-md">Actualizar</button>
    </div>
</div>

    <!-- Modal de confirmación para eliminar el proyecto -->
    <div id="deleteModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-96">
            <h2 class="text-xl font-semibold mb-4">¿Estás seguro de que deseas eliminar este proyecto?</h2>
            <div class="flex justify-center">
                <div class="flex justify-center items-center gap-2.5">
                    <button onclick="closeDeleteModal()" class="bg-white hover:bg-blue-300 text-black font-bold py-2 px-6 rounded-lg border border-gray-300 flex items-center">
                        <img src="/admin/includes/imgs/cancelar.svg" alt="Cancelar" class='w-5 h-5 mr-2'>
                        Cancelar</button>
                    <button id="confirmDeleteButton" class="bg-white hover:bg-red-300 text-black font-bold py-2 px-6 rounded-lg border border-gray-300 flex items-center">
                        <img src='/admin/includes/imgs/eliminar.svg' alt='Eliminar' class='w-5 h-5 mr-2'>
                        Eliminar
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Contenedor de proyectos -->
    <div id="projectsContainer" class="flex flex-wrap gap-5 mt-5 justify-start">
        <?php
        // Obtener los proyectos del año seleccionado
        $sql = "SELECT * FROM proyectos WHERE anio_id = $anio_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='project-container bg-slate-50 text-red rounded-lg p-6 w-full sm:w-72 lg:w-72 text-center font-medium shadow-lg flex flex-col justify-between items-center' data-id='{$row['id']}'>
                    <a href='/admin/public/registrarUsuarios.php?anio_id={$row['id']}' class='title font-bold mb-3 text-lg text-black'>
                    {$row['titulo']}
                    </a>
                    <div class='flex gap-3 w-full mt-3 project-buttons'>
                        <button class='bg-slate-50 hover:bg-blue-100 text-black font-bold py-2 px-4 rounded-lg flex items-center justify-center w-full border' 
                            onclick='openEditModal({$row["id"]}, \"{$row["titulo"]}\")'>
                            <img src='/admin/includes/imgs/editar.svg' alt='Editar' class='w-5 h-5 mr-2'> 
                            Editar
                        </button>
                        <button onclick='openDeleteModal({$row["id"]})' class='bg-slate-50 hover:bg-red-100 text-black font-bold py-2 px-4 rounded-lg flex items-center justify-center w-full border'>
                            <img src='/admin/includes/imgs/eliminar.svg' alt='Eliminar' class='w-5 h-5 mr-2'> 
                            Eliminar
                        </button>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='w-full text-center text-lg text-gray-700'>No hay proyectos disponibles para este año.</p>";
        }
        ?>
    </div>
</div>

<script>
let deleteProjectId = null;

function openDeleteModal(projectId) {
    deleteProjectId = projectId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    deleteProjectId = null;
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    if (deleteProjectId) {
        window.location.href = "?delete_id=" + deleteProjectId;
    }
});
</script>
<script src="/admin/includes/js/index.js"></script>
</body>
</html>
