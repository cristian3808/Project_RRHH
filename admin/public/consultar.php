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

// Manejar la actualización de un usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['cedula']) && isset($_POST['correo'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $sql = "UPDATE usuarios_r SET nombres = '$nombre', apellidos = '$apellido', cedula = '$cedula', correo = '$correo' WHERE id = '$id' AND anio_id = '$anio_id'";
    
    if (!mysqli_query($conn, $sql)) {
        echo "Error al actualizar el usuario: " . mysqli_error($conn);
    }
}

// Manejar la eliminación de un usuario
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM usuarios_r WHERE id = '$delete_id' AND anio_id = '$anio_id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=$anio_id"); 
        exit;
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conn);
    }
}

// Obtener todos los usuarios del proyecto filtrados por anio_id y unir con usuarios_r por cedula
$sql = "SELECT 
            u.id AS usuario_id, u.nombres, u.apellidos, u.cedula, u.correo, u.anio_id,
            ur.id AS usuario_r_id, ur.genero, ur.telefono, ur.fecha_nacimiento, ur.lugar_nacimiento, 
            ur.direccion, ur.fecha_expedicion_cedula, ur.municipio_residencia, ur.nombre_contacto, 
            ur.telefono_contacto, ur.tipo_sangre, ur.eps, ur.fondo_pension, ur.arl, ur.talla_camisa,
            ur.talla_pantalon, ur.talla_botas, ur.talla_nomex, ur.estado_civil, 
            ur.nombre_pareja, ur.tiene_hijos, ur.cuantos_hijos, 
            h.id AS hijo_id, h.nombre_completo_hijo, h.tipo_documento_hijo, 
            h.numero_documento_hijo, h.edad_hijo
        FROM usuarios u
        INNER JOIN usuarios_r ur ON u.cedula = ur.cedula
        LEFT JOIN hijos h ON ur.id = h.usuario_id
        WHERE u.anio_id = '$anio_id'";

$result = mysqli_query($conn, $sql);
$usuarios = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usuario_id = $row['usuario_id'];

        // Si el usuario aún no está en la lista, lo agregamos
        if (!isset($usuarios[$usuario_id])) {
            $usuarios[$usuario_id] = [
                'id' => $row['usuario_id'],
                'nombres' => $row['nombres'] ?? '',
                'apellidos' => $row['apellidos'] ?? '',
                'cedula' => $row['cedula'] ?? '',
                'correo' => $row['correo'] ?? '',
                'anio_id' => $row['anio_id'] ?? '',
                'genero' => $row['genero'] ?? '',
                'telefono' => $row['telefono'] ?? '',
                'fecha_nacimiento' => $row['fecha_nacimiento'] ?? '',
                'lugar_nacimiento' => $row['lugar_nacimiento'] ?? '',
                'direccion' => $row['direccion'] ?? '',
                'municipio_residencia' => $row['municipio_residencia'] ?? '',
                'fecha_expedicion_cedula' => $row['fecha_expedicion_cedula'] ?? '',
                'nombre_contacto' => $row['nombre_contacto'] ?? '',
                'telefono_contacto' => $row['telefono_contacto'] ?? '',
                'tipo_sangre' => $row['tipo_sangre'] ?? '',
                'eps' => $row['eps'] ?? '',
                'fondo_pension' => $row['fondo_pension'] ?? '',
                'arl' => $row['arl'] ?? '',
                'talla_camisa' => $row['talla_camisa'] ?? '',
                'talla_pantalon' => $row['talla_pantalon'] ?? '',
                'talla_botas' => $row['talla_botas'] ?? '',
                'talla_nomex' => $row['talla_nomex'] ?? '',
                'estado_civil' => $row['estado_civil'] ?? '',
                'nombre_pareja' => $row['nombre_pareja'] ?? 'N/A',
                'tiene_hijos' => $row['tiene_hijos'] ?? '',
                'cuantos_hijos' => $row['cuantos_hijos'] ?? '',
                'hijos' => [] // Inicializa la lista de hijos
            ];
        }

        // Agregar hijo si existe
        if (!empty($row['hijo_id'])) {
            $usuarios[$usuario_id]['hijos'][] = [
                'hijo_id' => $row['hijo_id'],
                'nombre_completo_hijo' => $row['nombre_completo_hijo'] ?? '',
                'tipo_documento_hijo' => $row['tipo_documento_hijo'] ?? '',
                'numero_documento_hijo' => $row['numero_documento_hijo'] ?? '',
                'edad_hijo' => $row['edad_hijo'] ?? ''
            ];
        }
    }
}

// Convertimos el array asociativo en un array simple
$usuarios = array_values($usuarios);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <link rel="icon" type="image/png" href="/static/img/TF.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="../includes/css/registrar_usuario.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.4/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tf auditores y asesores SAS BIC</title>
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
            <form id="miFormulario" action="../controllers/envioCorreo1.php?anio_id=<?php echo $anio_id; ?>" method="POST" onsubmit="resetForm(event)">
                <div class="mb-4">
                    <label for="usuarios" class="block text-lg font-medium text-gray-700">Usuarios:</label>
                    
                    <!-- Contenedor con scroll -->
                    <div class="mt-2 overflow-y-auto max-h-[550px] border border-gray-300 p-2 rounded-md">
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

                                // Iterar sobre los resultados y crear los checkboxes + input de asunto en columna
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="flex flex-col mb-2 p-2 border border-gray-200 rounded-lg">';
                                    echo '  <div class="flex items-center">';
                                    echo '      <input type="checkbox" name="usuarios[]" value="' . $row['correo'] . '" id="usuario_' . $row['id'] . '" class="h-5 w-5 text-green-900 focus:ring-0">';
                                    echo '      <label for="usuario_' . $row['id'] . '" class="ml-2 text-gray-700">' . $row['nombres'] . ' ' . $row['apellidos'] . ' (' . $row['correo'] . ')</label>';
                                    echo '  </div>';
                                    echo '  <input type="text" name="asunto[' . $row['correo'] . ']" placeholder="Asunto" class="mt-2 p-2 border border-gray-300 rounded w-full">';
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
            <script>
                function resetForm(event) {
                    event.preventDefault(); // Evita el envío inmediato del formulario
                    let form = document.getElementById("miFormulario");

                    // Simular envío del formulario y limpiar los campos después
                    fetch(form.action, {
                        method: form.method,
                        body: new FormData(form)
                    }).then(response => {
                        if (response.ok) {
                            form.reset(); // Limpia el formulario si el envío fue exitoso
                        } else {
                            alert("Hubo un error al enviar el correo");
                        }
                    }).catch(error => {
                        alert("Error en la solicitud: " + error);
                    });
                }
            </script>
        </div>
        </div>
    </div>
</header>
<div class="flex justify-center"><div class="w-full max-w-3xl mt-10">
    <!-- 🔎 Caja de búsqueda -->
    <input type="text" id="buscador" onkeyup="filtrarUsuarios()" placeholder="Buscar por Nombre, Apellido o Cédula..."
        class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-600 focus:outline-none">

    <div class="overflow-y-auto max-h-80 border border-gray-300 rounded-lg shadow-md">
        <table class="w-full border-collapse bg-white">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Nombres</th>
                    <th class="border border-gray-300 px-4 py-2">Apellidos</th>
                    <th class="border border-gray-300 px-4 py-2">Cédula</th>
                    <th class="border border-gray-300 px-4 py-2">Correo</th>
                    <th class="border border-gray-300 px-4 py-2">Acción</th>
                </tr>
            </thead>
            <tbody id="tablaUsuarios">
                <?php foreach ($usuarios as $usuario): ?>
                    <tr class="hover:bg-gray-100 text-center">
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($usuario['nombres'] ?? ''); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($usuario['apellidos'] ?? ''); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($usuario['correo'] ?? ''); ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button 
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 flex items-center"
                                onclick="mostrarModal(<?php echo htmlspecialchars(json_encode($usuario), ENT_QUOTES, 'UTF-8'); ?>)">
                                <img src="/admin/includes/imgs/lupa.svg" alt="" class="w-4 h-4 mr-2">Consultar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filtrarUsuarios() {
    let input = document.getElementById("buscador").value.toLowerCase();
    let filas = document.querySelectorAll("#tablaUsuarios tr");

    filas.forEach(fila => {
        let nombre = fila.children[0].textContent.toLowerCase();
        let apellido = fila.children[1].textContent.toLowerCase();
        let cedula = fila.children[2].textContent.toLowerCase();

        if (nombre.includes(input) || apellido.includes(input) || cedula.includes(input)) {
            fila.style.display = "";
        } else {
            fila.style.display = "none";
        }
    });
}
</script>
<!-- Modal Del Boton Consultar -->
<div id="modalUsuario" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-lg shadow-2xl w-full max-w-4xl relative max-h-[90vh] overflow-y-auto">
        
        <!-- Botón de cierre flotante -->
        <button class="absolute top-3 right-3 text-gray-600 hover:text-gray-800 text-2xl" onclick="cerrarModal()">✖</button>

        <h2 class="text-xl md:text-2xl font-semibold mb-4 md:mb-6 text-center text-gray-800 border-b pb-2">
            Detalles del Usuario
        </h2>

        <!-- Contenido del modal -->
        <div id="contenidoModal" class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 text-sm">
            
            <!-- Información Personal -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <img src="/admin/includes/imgs/persona.svg" alt="" class="w-5 h-5 mr-2"> Información Personal
                </h3>
                <p><strong>Nombre:</strong> <span id="modalNombres"></span></p>
                <p><strong>Apellidos:</strong> <span id="modalApellidos"></span></p>
                <p><strong>Género:</strong> <span id="modalGenero"></span></p>
                <p><strong>Cédula:</strong> <span id="modalCedula"></span></p>
                <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
                <p><strong>Correo:</strong> <span id="modalCorreo"></span></p>
            </div>

            <!-- Ubicación -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <img src="/admin/includes/imgs/ubicacion.svg" alt="" class="w-5 h-5 mr-2"> Ubicación
                </h3>
                <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
                <p><strong>Municipio:</strong> <span id="modalMunicipio"></span></p>
                <p><strong>Lugar de Nacimiento:</strong> <span id="modalLugarNacimiento"></span></p>
                <p><strong>Fecha de Nacimiento:</strong> <span id="modalFechaNacimiento"></span></p>
                <p><strong>Fecha Exp. Cédula:</strong> <span id="modalFechaExpedicionCedula"></span></p>
            </div>

            <!-- Datos de Contacto -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <img src="/admin/includes/imgs/telefono.svg" alt="" class="w-5 h-5 mr-2"> Contacto De Emergencia
                </h3>
                <p><strong>Nombre:</strong> <span id="modalNombreContacto"></span></p>
                <p><strong>Teléfono:</strong> <span id="modalTelefonoContacto"></span></p>
            </div>

            <!-- Salud -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <img src="/admin/includes/imgs/salud.svg" alt="" class="w-5 h-5 mr-2"> Salud
                </h3>
                <p><strong>Tipo de Sangre:</strong> <span id="modalTipoSangre"></span></p>
                <p><strong>EPS:</strong> <span id="modalEps"></span></p>
                <p><strong>Fondo de Pensión:</strong> <span id="modalFondoPension"></span></p>
                <p><strong>ARL:</strong> <span id="modalArl"></span></p>
            </div>

            <!-- Tallas -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <img src="/admin/includes/imgs/tallas.svg" alt="" class="w-5 h-5 mr-2"> Tallas
                </h3>
                <p><strong>Camisa:</strong> <span id="modalTallaCamisa"></span></p>
                <p><strong>Pantalón:</strong> <span id="modalTallaPantalon"></span></p>
                <p><strong>Botas:</strong> <span id="modalTallaBotas"></span></p>
                <p><strong>Nomex:</strong> <span id="modalTallaNomex"></span></p>
            </div>

            <!-- Estado Civil -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <img src="/admin/includes/imgs/estado_civil.svg" alt="" class="w-5 h-5 mr-2"> Estado Civil
                </h3>
                <p><strong>Estado Civil:</strong> <span id="modalEstadoCivil"></span></p>
                <p><strong>Nombre de Pareja:</strong> <span id="modalNombrePareja"></span></p>
                <p><strong>Tiene Hijos:</strong> <span id="modalTieneHijos"></span></p>
                <p><strong>Cuántos Hijos:</strong> <span id="modalCuantosHijos"></span></p>
            </div>
        </div>

        <!-- Sección: Hijos -->
        <div class="mt-6 hidden" id="modalHijosContainer">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Hijos</h3>
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2">Nombre</th>
                        <th class="border border-gray-300 px-3 py-2">Tipo Documento</th>
                        <th class="border border-gray-300 px-3 py-2">Número</th>
                        <th class="border border-gray-300 px-3 py-2">Edad</th>
                    </tr>
                </thead>
                <tbody id="modalHijos"></tbody>
            </table>
        </div>
    </div>
</div>

<script>function mostrarModal(usuario) {
    // Función para formatear fechas de YYYY-MM-DD a DD/MM/YYYY
    function formatearFecha(fechaISO) {
        if (!fechaISO) return "N/A"; // Si la fecha es nula o vacía
        let partes = fechaISO.split("-");
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }

    // Lista de campos a llenar
    const campos = {
        "modalNombres": usuario.nombres,
        "modalApellidos": usuario.apellidos,
        "modalGenero": usuario.genero,
        "modalCedula": usuario.cedula,
        "modalTelefono": usuario.telefono,
        "modalCorreo": usuario.correo,
        "modalDireccion": usuario.direccion,
        "modalMunicipio": usuario.municipio_residencia,
        "modalLugarNacimiento": usuario.lugar_nacimiento,
        "modalFechaNacimiento": formatearFecha(usuario.fecha_nacimiento), // Formateo aquí
        "modalFechaExpedicionCedula": formatearFecha(usuario.fecha_expedicion_cedula), // Formateo aquí
        "modalNombreContacto": usuario.nombre_contacto,
        "modalTelefonoContacto": usuario.telefono_contacto,
        "modalTipoSangre": usuario.tipo_sangre,
        "modalEps": usuario.eps,
        "modalFondoPension": usuario.fondo_pension,
        "modalArl": usuario.arl,
        "modalTallaCamisa": usuario.talla_camisa,
        "modalTallaPantalon": usuario.talla_pantalon,
        "modalTallaBotas": usuario.talla_botas,
        "modalTallaNomex": usuario.talla_nomex,
        "modalEstadoCivil": usuario.estado_civil,
        "modalNombrePareja": usuario.nombre_pareja,
        "modalTieneHijos": usuario.tiene_hijos ? "Sí" : "No",
        "modalCuantosHijos": usuario.cuantos_hijos || "0"
    };

    // Llenar los datos en el modal
    Object.keys(campos).forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.innerText = campos[id] || "N/A";
        }
    });

    // Manejo de hijos (No se modificó esta parte)
    const hijosContainer = document.getElementById("modalHijosContainer");
    const tablaHijos = document.getElementById("modalHijos");
    tablaHijos.innerHTML = "";

    if (usuario.hijos && usuario.hijos.length > 0) {
        hijosContainer.classList.remove("hidden");
        usuario.hijos.forEach(hijo => {
            tablaHijos.innerHTML += `
                <tr>
                    <td class="border border-gray-300 px-3 py-2">${hijo.nombre_completo_hijo || 'N/A'}</td>
                    <td class="border border-gray-300 px-3 py-2">${hijo.tipo_documento_hijo || 'N/A'}</td>
                    <td class="border border-gray-300 px-3 py-2">${hijo.numero_documento_hijo || 'N/A'}</td>
                    <td class="border border-gray-300 px-3 py-2">${hijo.edad_hijo || 'N/A'}</td>
                </tr>`;
        });
    } else {
        hijosContainer.classList.add("hidden");
    }

    // Mostrar el modal
    document.getElementById("modalUsuario").classList.remove("hidden");
}

function cerrarModal() {
    document.getElementById("modalUsuario").classList.add("hidden");
}

</script>

                    
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