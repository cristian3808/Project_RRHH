<?php
session_start();
include('..//../config/db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Obtener el anio_id de la URL
if (isset($_GET['anio_id'])) {
    $anio_id = $_GET['anio_id'];
} 

// Obtener el nombre del proyecto
$sql_project = "SELECT titulo FROM proyectos WHERE id = '$anio_id'";
$result_project = mysqli_query($conn, $sql_project);
$project_name = '';

if (mysqli_num_rows($result_project) > 0) {
    $row_project = mysqli_fetch_assoc($result_project);
    $project_name = $row_project['titulo'];
}

// Manejar la creación de un usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['cedula']) && isset($_POST['correo']) && !isset($_POST['id'])) {
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $sql = "INSERT INTO usuarios (nombres, apellidos, cedula, correo, anio_id) VALUES ('$nombre', '$apellido', '$cedula', '$correo', '$anio_id')";    
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . mysqli_error($conn);
    }
}

// Manejar la actualización de un usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['cedula']) && isset($_POST['correo'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $sql = "UPDATE usuarios SET nombres = '$nombre', apellidos = '$apellido', cedula = '$cedula', correo = '$correo' WHERE id = '$id' AND anio_id = '$anio_id'";
    
    if (!mysqli_query($conn, $sql)) {
        echo "Error al actualizar el usuario: " . mysqli_error($conn);
    }
}

// Manejar la eliminación de un usuario
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM usuarios WHERE id = '$delete_id' AND anio_id = '$anio_id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=$anio_id"); 
        exit;
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conn);
    }
}

// Obtener todos los usuarios del proyecto filtrados por anio_id
$sql = "SELECT * FROM usuarios WHERE anio_id = '$anio_id'";
$result = mysqli_query($conn, $sql);
$usuarios = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usuarios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="../includes/css/registrar_usuario.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registrar Usuarios - Proyecto</title>
</head>
<body class="bg-[#E1EEE2] font-sans">
<header class="w-full bg-white mb-10 border-b-4 border-green-900">
    <div class="container mx-auto flex flex-wrap p-5 items-center justify-between">
        <!-- Logo: más pequeño en pantallas pequeñas -->
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
            <a href="/admin/public/rtaPrimerForm.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">RTA DATOS PERSONALES</a>
            <a href="#" onclick="mostrarFormularioUsuarios();" class="text-green-900 hover:text-lime-600 font-bold py-2 px-4 rounded-md border-2 border-green-900 hover:bg-green-900 hover:text-white transition">
                ENV FORM DATOS PERSONALES
            </a>
        </nav>

        <!-- Botón de cierre de sesión -->
        <div class="hidden lg:block">
            <a href="../../../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-xs md:text-sm flex items-center">
            <img src="/admin/includes/imgs/cerrarsesion.png" class="w-4 h-4 mr-2" alt="Cerrar Sesión"/>
            CERRAR SESIÓN
            </a>
        </div>
    </div>

    <!-- Formulario oculto con lista de usuarios -->
    <div id="formularioUsuarios" class="fixed top-0 right-0 bottom-0 left-0 flex justify-center items-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white p-6 border border-gray-300 rounded-lg shadow-lg w-full max-w-lg relative">
            <!-- Botón de cierre "X" -->
            <button onclick="cerrarFormulario()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 font-bold text-lg">
                &times;
            </button>

            <h2 class="text-xl font-semibold text-center mb-4">Selecciona los usuarios para enviar el correo</h2>
            <form action="../controllers/envioCorreo1.php?anio_id=<?php echo $anio_id; ?>" method="POST">
                <div class="mb-4">
                    <label for="usuarios" class="block text-lg font-medium text-gray-700">Usuarios:</label>
                    <div class="mt-2">
                        <?php
                            // Incluir el archivo de configuración para la conexión a la base de datos
                            include('../../config/db.php');

                            $project_id = $_GET['anio_id'] ?? null;
                            if ($project_id) {
                                $query = "SELECT id, nombres, apellidos, correo FROM usuarios WHERE anio_id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $project_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Iterar sobre los resultados y crear los checkboxes
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="flex items-center mb-2">';
                                    echo '<input type="checkbox" name="usuarios[]" value="' . $row['correo'] . '" id="usuario_' . $row['id'] . '" class="h-5 w-5 text-green-900 focus:ring-0">';
                                    echo '<label for="usuario_' . $row['id'] . '" class="ml-2 text-gray-700">' . $row['nombres'] . ' ' . $row['apellidos'] . ' (' . $row['correo'] . ')</label>';
                                    echo '</div>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" value="Enviar Correo" class="bg-[#2FA74D] text-white py-2 px-4 rounded-md hover:bg-lime-600 transition cursor-pointer">
                </div>
            </form>
        </div>
    </div>
    </div>
</header>
                                                
<!-- Modal para agregar un nuevo usuario -->
<div id="userModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Nuevo Usuario</h2>
            <span onclick="closeModal()" class="text-2xl font-bold text-gray-600 cursor-pointer">&times;</span>
        </div>
        <form method="POST" action="">
            <input type="text" name="nombres" placeholder="Nombres" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
            <input type="text" name="apellidos" placeholder="Apellidos" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
            <input type="text" name="cedula" placeholder="Cédula" class="w-full p-3 mb-4 border border-gray-300 rounded-md " maxlength="10" required>
            <input type="email" name="correo" placeholder="Correo" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
            <button type="submit" class="w-full bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-6 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-100 focus:ring-opacity-50">Registrar</button>
        </form>
    </div>
</div>

<!-- Tabla de usuarios registrados -->
<div class="mt-6 bg-white rounded-lg shadow-md p-6 border-2 border-green-900 mx-auto w-[1260px]">

    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 w-[1200px]">
        <p class="text-sm sm:text-base mb-6">Registrar Usuarios para el Proyecto: <strong><?php echo htmlspecialchars($project_name); ?></strong></p>
        <button class="bg-green-600 hover:bg-lime-500 text-white py-2 px-3 rounded-lg shadow-md sm:w-64 h-10 flex items-center justify-center hover:scale-85 duration-200 mt-4 sm:mt-0" onclick="openModal()">
            <img src="../includes/imgs/agregar.svg" alt="agregar" class="w-6 h-6">
            <span>Agregar</span> 
        </button>
    </div>

    <!-- Tabla con scroll horizontal en dispositivos pequeños -->
    <div class="overflow-x-auto">
        <table class="table-auto w-[1200px] bg-white shadow-md rounded-lg overflow-hidden border-collapse mt-6">   
            <thead>
                <tr class="bg-green-800 text-white">
                    <th class="py-2 px-4 text-center w-[250px]">Nombres</th>
                    <th class="py-2 px-4 text-center w-[250px]">Apellidos</th>
                    <th class="py-2 px-4 text-center w-[250px]">Cédula</th>
                    <th class="py-2 px-4 text-center w-[300px]">Correo</th>
                    <th class="py-2 px-4 text-center w-[100px]">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr class="border-b">
                        <td class="py-2 px-4 text-center"><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                        <td class="py-2 px-4 text-center"><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                        <td class="py-2 px-4 text-center"><?php echo htmlspecialchars($usuario['cedula']); ?></td>
                        <td class="py-2 px-4 text-center"><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td class="py-2 px-4 text-center">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <img src="../includes/imgs/editar.svg" alt="Editar" onclick="openEditModal('<?php echo $usuario['id']; ?>', '<?php echo htmlspecialchars($usuario['nombres']); ?>', '<?php echo htmlspecialchars($usuario['apellidos']); ?>','<?php echo htmlspecialchars($usuario['cedula']); ?>', '<?php echo htmlspecialchars($usuario['correo']); ?>')" class="cursor-pointer" width="24" height="24">
                                <img src="../includes/imgs/eliminar.svg" alt="Eliminar" onclick="openDeleteModal('<?php echo $usuario['id']; ?>')" class="cursor-pointer" width="24" height="24">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Eliminación -->
<div id="deleteUserModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Eliminar Usuario</h2>
            <span onclick="closeDeleteModal()" class="text-2xl font-bold text-gray-600 cursor-pointer">&times;</span>
        </div>
        <form id="deleteForm" method="GET" action="">
            <input type="hidden" id="deleteUserId" name="delete_id">
            <input type="hidden" name="anio_id" value="<?php echo $anio_id; ?>"> 
            <p>¿Estás seguro de que deseas eliminar este usuario?</p>
            <div class="flex justify-center space-x-4 mt-4">
                <button type="submit" class="bg-red-600 text-white font-bold py-3 px-6 rounded-lg">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Edición -->
<div id="editUserModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Editar Usuario</h2>
            <span onclick="closeEditModal()" class="text-2xl font-bold text-gray-600 cursor-pointer">&times;</span>
        </div>
        <form id="editUserForm" method="POST" action="">
            <input type="hidden" id="editUserId" name="id">
            <input type="text" id="editNombre" name="nombres" placeholder="Nombres" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
            <input type="text" id="editApellido" name="apellidos" placeholder="Apellidos" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
            <input type="text" id="editCedula" name="cedula" placeholder="Cédula" class="w-full p-3 mb-4 border border-gray-300 rounded-md" maxlength="10" required>
            <input type="email" id="editCorreo" name="correo" placeholder="Correo" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
            <button type="submit" class="w-full bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-6 rounded-lg shadow-md">Actualizar Usuario</button>
        </form>
    </div>
</div>
<div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>
<script src="/admin/includes/js/registrarUsuarios.js"></script>
</body>
</html>