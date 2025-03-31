<?php
session_start();
include('../../config/db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

// Verifica si hay un mensaje de error
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error']; // Obtén el mensaje de error
    unset($_SESSION['error']); // Borra el mensaje después de usarlo
}

if (isset($_GET['anio_id'])) {
    $anio_id = $_GET['anio_id'];
} 

$sql_project = "SELECT titulo FROM proyectos WHERE id = '$anio_id'";
$result_project = mysqli_query($conn, $sql_project);
$project_name = '';

if (mysqli_num_rows($result_project) > 0) {
    $row_project = mysqli_fetch_assoc($result_project);
    $project_name = $row_project['titulo'];
}

$mensaje = "";
$usuarios = [];
$anio_id = "";

// Obtener la lista de proyectos
$sql_proyectos = "SELECT id, titulo FROM proyectos";
$result_proyectos = mysqli_query($conn, $sql_proyectos);
$proyectos = [];

if ($result_proyectos && mysqli_num_rows($result_proyectos) > 0) {
    while ($row = mysqli_fetch_assoc($result_proyectos)) {
        $proyectos[] = $row;
    }
} else {
    $mensaje = "No se encontraron proyectos.";
}

// Obtener el anio_id desde la URL, si está presente
if (isset($_GET['anio_id'])) {
    $anio_id = mysqli_real_escape_string($conn, $_GET['anio_id']);

    // Obtener usuarios filtrados por anio_id
    $sql_usuarios = "SELECT * FROM usuarios WHERE anio_id = ?";
    $stmt = mysqli_prepare($conn, $sql_usuarios);
    mysqli_stmt_bind_param($stmt, 'i', $anio_id);
    mysqli_stmt_execute($stmt);
    $result_usuarios = mysqli_stmt_get_result($stmt);

    if ($result_usuarios && mysqli_num_rows($result_usuarios) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios)) {
            $cedula = $row['cedula'];
            // Verificar si la cédula existe en la tabla usuarios_r
            $sql_verificacion = "SELECT * FROM usuarios_r WHERE cedula = ?";
            $stmt_verificacion = mysqli_prepare($conn, $sql_verificacion);
            mysqli_stmt_bind_param($stmt_verificacion, 's', $cedula);
            mysqli_stmt_execute($stmt_verificacion);
            $result_verificacion = mysqli_stmt_get_result($stmt_verificacion);
            $row['formulario_completado'] = (mysqli_num_rows($result_verificacion) > 0) ? 1 : 0;
            $usuarios[] = $row;
        }
    } else {
        $mensaje = "No se encontraron usuarios registrados para este proyecto.";
    }
}

// Manejar la eliminación de un usuario
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM usuarios WHERE id = ? AND anio_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $delete_id, $anio_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=$anio_id");
        exit;
    } else {
        $mensaje = "Error al eliminar el usuario: " . mysqli_error($conn);
    }
}
$usuarioNoEncontrado = isset($_GET['usuario_no_encontrado']) && $_GET['usuario_no_encontrado'] === 'true';
?>
<?php
// Si hay un mensaje de error, lo mostramos con Tailwind
if (isset($error_message)) {
    echo '
    <div id="errorAlert" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <span>' . $error_message . '</span>
        </div>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById("errorAlert").style.display = "none"; // Oculta la alerta
            location.reload(); // Recarga la página
        }, 1000); // Desaparece después de 2 segundos
    </script>
    ';
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
    <link rel="stylesheet" href="/admin/includes/css/rtaPrimerForm.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Usuarios Registrados</title>
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
            <a href="/admin/public/registrarUsuarios.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">USUARIOS</a>
            <a href="/admin/public/consultar.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">CONSULTAR</a>
        </nav>

        <!-- Botón de cierre de sesión -->
        <div class="hidden lg:block">
            <a href="../../../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-xs md:text-sm flex items-center">
            <img src="/admin/includes/imgs/cerrarsesion.png" class="w-4 h-4 mr-2" alt="Cerrar Sesión" />
            CERRAR SESIÓN</a>
        </div>
    </div>

    <!-- Menú desplegable en móviles (oculto por defecto) -->
    <div id="mobileMenu" class="lg:hidden bg-white w-full px-5 py-3 space-y-4 text-center hidden">
        <a href="/admin/años.php" class="block text-green-900 hover:text-lime-600 font-bold text-lg">AÑOS</a>
        <a href="/admin/index.php" class="block text-green-900 hover:text-lime-600 font-bold text-lg">PROYECTOS</a>
        <a href="../../../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-xs md:text-sm flex items-center">
        <img src="/admin/includes/imgs/cerrarsesion.png" class="w-4 h-4 mr-2" alt="Cerrar Sesión" />
        Cesrrar sesión</a>
        <a href="/admin/public/consultar.php?anio_id=<?php echo $anio_id; ?>" class="block text-green-900 hover:text-lime-600 font-bold text-lg">CONSULTAR</a>
    </div>
</header>
<!-- Formulario de usuarios oculto -->
<div id="formularioUsuarios" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-6 border border-gray-300 rounded-lg shadow-lg w-[500px] max-w-lg relative">
        <button onclick="cerrarFormulario()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 font-bold text-lg">
            &times;
        </button>
        
        <h2 class="text-xl font-semibold text-center mb-4">Selecciona los usuarios para enviar el correo</h2>
        
        <form action="../controllers/envioCorreo2.php?anio_id=<?php echo $anio_id; ?>" method="POST">
            <div class="mb-4">
                <label for="usuarios" class="block text-lg font-medium text-gray-700">Usuarios:</label>
                <div class="mt-2">
                    <div class="usuarios-container" style="max-height: 350px; overflow-y: auto;"> 
                        <?php
                        include('../../config/db.php'); 
                        $project_id = $_GET['anio_id'] ?? null;
                        if ($project_id) {
                            $query = "SELECT id, nombres, apellidos, correo FROM usuarios WHERE anio_id = ?";
                            $stmt = $conn->prepare($query);  
                            $stmt->bind_param("i", $project_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = 0; 
                            while ($row = $result->fetch_assoc()) {
                                if ($count == 5) break; 
                                
                                $correo_usuario = $row['correo'];
                                
                                $query_r = "SELECT 1 FROM usuarios_r WHERE correo = ? LIMIT 1";
                                $stmt_r = $conn->prepare($query_r);  
                                $stmt_r->bind_param("s", $correo_usuario);
                                $stmt_r->execute();
                                $stmt_r->store_result(); 

                                $estado_correo = ($stmt_r->num_rows > 0) ? 'Sí' : 'No';

                                echo '<div class="flex items-center mb-2">';
                                echo '<input type="checkbox" name="usuarios[]" value="' . $row['correo'] . '" id="usuario_' . $row['id'] . '" class="h-5 w-5 text-green-900 focus:ring-0">';
                                echo '<label for="usuario_' . $row['id'] . '" class="ml-2 text-gray-700">' . $row['nombres'] .' '. $row['apellidos']. ' (' . $row['correo'] . ') - Registro en formulario N°1: ' . $estado_correo . '</label>';
                                echo '</div>';
                                $count++; 
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" value="Enviar Correo" class="bg-green-900 text-white py-2 px-4 rounded-md hover:bg-lime-600 transition cursor-pointer">
            </div>
        </form>
    </div>
</div>

<div class="mx-4 sm:mx-8 md:mx-16 lg:mx-32 xl:mx-64 bg-white rounded-lg shadow-lg p-6 mt-8 rounded-lg shadow-md p-6 border-2 border-green-900 mx-auto">
    <?php if ($mensaje): ?>
        <p class="text-red-500 mb-4"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <?php if (!empty($usuarios)): ?>
    <div class="flex flex-col sm:flex-row items-center justify-between  mb-4" >
        <p class="text-xl sm:text-lg mb-6 sm:mb-0 text-center sm:text-left">
            Usuarios Registrados en el Proyecto: <strong><?php echo htmlspecialchars($project_name); ?></strong>
        </p>
        <div class="sm:ml-4 mt-4 sm:mt-0 flex items-center space-x-4 " >
        <button onclick="downloadAllCedulas(<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : 'null'; ?>)" 
            class="bg-[#2FA74D] border-2 border-black hover:bg-[#79CF88] text-white font-medium py-1 px-1 rounded-lg shadow-md flex items-center w-auto text-outline">
            <img src="/admin/includes/imgs/cedula.png" alt="" class="mr-1 w-10 h-10"> 
            Descargar Todas las Cédulas
        </button>
            <a href="../controllers/generarExcelCompleto.php?anio_id=<?php echo $anio_id; ?>" 
                class="bg-[#2FA74D] border-2 border-black hover:bg-[#79CF88] text-white font-medium py-1 px-2 rounded-lg shadow-md flex items-center w-auto text-outline">
                <img src="../includes/imgs/excel.jpg" class="w-10 h-10 mr-1" alt="excel">      
                Descargar Excel
            </a>
            <button class="bg-[#2FA74D] border-2 border-black hover:bg-[#79CF88] text-white font-medium py-1 px-2 rounded-lg shadow-md flex items-center w-auto text-outline" onclick="openModal()">
                <img src="../includes/imgs/carnet.png" class="w-10 h-10 -mr-3" alt="excel">      
                Generar Carnets
            </button>

            <style>
                .text-outline {
                    text-shadow: -1px -1px 0 black,  
                                1px -1px 0 black,  
                                -1px  1px 0 black,  
                                1px  1px 0 black;
                }
            </style>
            <a href="../public/dotacion.php?anio_id=<?php echo $anio_id; ?>" 
                class="bg-amber-300  border-2 border-black hover:bg-amber-200 text-black font-bold py-2 px-4 rounded-lg shadow-md flex items-center">
                <img src="../includes/imgs/casco.png" class="w-13 h-8 mr-2" alt="dotacion">Dotación
            </a>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="overflow-x-auto" >
    <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden border-collapse">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-center text-sm font-semibold">Nombres</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">Apellidos</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">Cédula</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold w-[200px]">Respuestas</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold w-[200px]">Descargar doc</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($usuarios as $usuario): ?>
                    <?php 
                        $boton_clase = ($usuario['formulario_completado'] == 1) ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600';
                    ?>
                    <tr class="hover:bg-gray-100 transition-colors">
                        <td class="py-3 px-4 text-center">
                            <?php echo htmlspecialchars($usuario['nombres']); ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php echo htmlspecialchars($usuario['apellidos']); ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php echo htmlspecialchars($usuario['cedula']); ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="../controllers/generarPDF1.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                class="text-black font-bold  <?php echo $boton_clase; ?> py-2 px-1 rounded-md whitespace-nowrap flex items-center justify-center"
                                style="width: 180px; display: inline-flex;">
                                <img src="/admin/includes/imgs/ojo.png" alt="" class="mr-2 w-5 h-5"> 
                                Informe Completo
                            </a>
                        </td>
                        <td class="py-3 px-4 text-center relative">
                            <div class="relative inline-block text-left">
                                <button onclick="openModalOne(<?php echo $usuario['cedula']; ?>)" 
                                    class="bg-white border-2 border-green-900 text-black px-4 py-1 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300 hover:bg-gray-100 shadow-lg transition duration-200 flex items-center text-base">
                                    <img src="/admin/includes/imgs/descargarDoc.svg" alt="" class="mr-3 w-8 h-8"> 
                                    Documento
                                </button>
                            </div>
                        </td>
                        <!-- Modal -->
                        <div id="modal-<?php echo $usuario['cedula']; ?>" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-60 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-96 p-5">
                                <div class="flex justify-between items-center border-b pb-4 mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 text-center">Selecciona para descargar</h2>
                                <button onclick="closeModalOne(<?php echo $usuario['cedula']; ?>)" class="text-gray-500 hover:text-gray-800 text-2xl">
                                        &times;
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <a href="../controllers/generarHojaVida.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-200 hover:text-green-900 rounded-md transition duration-200 text-center">
                                        HOJA DE VIDA
                                    </a>
                                    <a href="../controllers/generarCedula.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-900 rounded-md transition duration-200 text-center">
                                        CÉDULA
                                    </a>
                                    <a href="../controllers/generarCertificadosEstudio.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-900 rounded-md transition duration-200 text-center">
                                        CERTIFICADOS DE ESTUDIO
                                    </a>
                                    <a href="../controllers/generarCertificadosLaborales.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-900 rounded-md transition duration-200 text-center">
                                        CERTIFICADOS LABORALES
                                    </a>
                                    <a href="../controllers/generarFoto.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-900 rounded-md transition duration-200 text-center">
                                        FOTO
                                    </a>
                                    <a href="../controllers/generarCertificadosEps.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600 rounded-md transition duration-200 text-center">
                                        CERTIFICADO EPS
                                    </a>
                                    <a href="../controllers/generarCarnetVacunas.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600 rounded-md transition duration-200 text-center">
                                        CARNET VACUNAS
                                    </a>
                                    <a href="../controllers/generarCertificacionBancaria.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600 rounded-md transition duration-200 text-center">
                                        CERTIFICACION BANCARIA
                                    </a>
                                    <a href="../controllers/generarCertificacionAntecedentes.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600 rounded-md transition duration-200 text-center">
                                        CERTIFICACION ANTECEDENTES
                                    </a>     
                                    <a href="../controllers/generarCertificadoAfp.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600 rounded-md transition duration-200 text-center">
                                        CERTIFICADO AFP
                                    </a>   
                                    <a href="../controllers/generarCertificadoTerritorialidad.php?cedula=<?php echo $usuario['cedula']; ?>&anio_id=<?php echo isset($_GET['anio_id']) ? $_GET['anio_id'] : ''; ?>" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600 rounded-md transition duration-200 text-center">
                                        CERTIFICADO TERRITORIALIDAD
                                    </a>   
                                                                  
                                </div>
                            </div>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
    </div>
    <script>
         function downloadAllCedulas(anio_id) {
        if (!anio_id) {
            alert("Error: No se especificó el año.");
            return;
        }
        window.location.href = `/admin/controllers/generarTodasCedulas.php?anio_id=${anio_id}`;
    }
        // Función para abrir el modal
        function openModalOne(cedula) {
            const modal = document.getElementById(`modal-${cedula}`);
            modal.classList.remove('hidden'); // Muestra el modal
        }

        // Función para cerrar el modal
        function closeModalOne(cedula) {
            const modal = document.getElementById(`modal-${cedula}`);
            modal.classList.add('hidden'); // Oculta el modal
        }
    </script>
    <div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>
    <script src="/admin/includes/js/rtaPrimerForm.js"></script>
        <?php if ($usuarioNoEncontrado): ?>
            <div id="alerta" class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-md"> No a diligenciado el formulario.</div>
            <script>
                setTimeout(function() {
                    document.getElementById('alerta').style.display = 'none';
                }, 2000);
            </script>
        <?php endif; ?>
    <!-- Modal -->
    <div id="userModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; transition: opacity 0.3s ease;">
        <div style="background: #fff; margin: 10% auto; padding: 30px; max-width: 500px; width: 90%; border-radius: 15px; position: relative; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease;">
            <button onclick="closeModal()" style="position: absolute; top: 10px; right: 10px; font-size: 28px; font-weight: bold; color: #888; background: none; border: none; cursor: pointer; transition: color 0.3s;">
                ×
            </button>
            <h2 class="text-center text-2xl text-[#333] mb-5 font-bold">Selecciona</h2>
            <form id="userForm">
                <div id="userList"></div> 
                <div class="flex justify-center">
                    <button type="button" onclick="generatePDF()" class="mt-4 mx-auto bg-[#2FA74D] border-2 border-black hover:bg-[#79CF88] text-white font-medium py-1 px-2 rounded-lg shadow-md flex items-center w-auto text-outline">
                        Generar Carnets
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
    function openModal() {
        document.getElementById('userModal').style.display = 'block';

        // Solicitar los usuarios al backend, pasando el anio_id
        fetch(`/admin/controllers/generarCarnet.php?action=getUsers&anio_id=<?php echo $anio_id; ?>`)
            .then(response => response.json())
            .then(data => {
                const userList = document.getElementById('userList');
                userList.innerHTML = ''; 

                data.forEach(user => {
                    const checkbox = `<label>
                        <input type="checkbox" name="userIds[]" value="${user.id}"> 
                        ${user.nombres} ${user.apellidos} - <strong>${user.estado}</strong>   
                    </label><br>`;
                    userList.innerHTML += checkbox;
                });
            });
        }
        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
        }
        function generatePDF() {
            const form = document.getElementById('userForm');
            const formData = new FormData(form);

            fetch('/admin/controllers/generarCarnet.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.blob(); // Descargar el archivo generado
                } else {
                    alert('Error al generar el PDF.');
                }
            })
            .then(blob => {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'PDF de Carnets.pdf';
                a.click();
            });
        }
        // Función para mostrar el menú en móviles
        document.getElementById('menuToggle').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
        function mostrarFormularioUsuarios() {
            document.getElementById('formularioUsuarios').classList.remove('hidden');
        }
        function cerrarFormulario() {
            document.getElementById('formularioUsuarios').classList.add('hidden');
        }
    </script>
</body>
</html>
