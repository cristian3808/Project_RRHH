<?php
session_start();
include('../../config/db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['anio_id'])) {
    die("ID de proyecto no especificado.");
}

$anio_id = $_GET['anio_id']; 
$cedula_filter = ''; 
$usuario_datos = null;

$talla_camisa_hombres = [];
$talla_pantalon_hombres = [];
$talla_botas_hombres = [];
$talla_nomex_hombres = [];

$talla_camisa_mujeres = [];
$talla_pantalon_mujeres = [];
$talla_botas_mujeres = [];
$talla_nomex_mujeres = [];

if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
    $cedula_filter = $_GET['cedula'];
}

try {
    $sql = "SELECT u.nombres, u.apellidos, ur.genero, ur.talla_camisa, ur.talla_pantalon, ur.talla_botas, ur.talla_nomex, ur.enviado FROM usuarios_r ur JOIN usuarios u ON ur.cedula = u.cedula WHERE u.anio_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $anio_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['accion']) && $_POST['accion'] === 'actualizar_dotacion') {
            if (isset($_POST['usuarios'])) {
                $usuarios_seleccionados = $_POST['usuarios'];
    
                foreach ($usuarios_seleccionados as $cedula) {
                    $sql_usuario = "SELECT ur.genero FROM usuarios_r ur WHERE ur.cedula = '$cedula'";
                    $resultado_usuario = $conn->query($sql_usuario);
                    if ($resultado_usuario->num_rows > 0) {
                        $row = $resultado_usuario->fetch_assoc();
                        $genero = $row['genero'];
                        echo "Usuario con cédula $cedula actualizado con género $genero.<br>";
                    }
                }
            }
        }

        if (isset($_POST['accion']) && $_POST['accion'] === 'devolver_usuarios') {
            if (isset($_POST['devolver_usuarios'])) {
                $usuarios_devolver = $_POST['devolver_usuarios'];
                foreach ($usuarios_devolver as $cedula) {
                    echo "Usuario con cédula $cedula devuelto.<br>";
                }
            }
        }
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (isset($row['enviado'], $row['genero'], $row['talla_camisa'], $row['talla_pantalon'], $row['talla_botas'], $row['talla_nomex'])) {
                if ($row['enviado'] == 1) {
                    if ($row['genero'] === 'masculino') {
                        $talla_camisa_hombres[$row['talla_camisa']][] = [$row['nombres'], $row['apellidos']];
                        $talla_pantalon_hombres[$row['talla_pantalon']][] =[$row['nombres'], $row['apellidos']];
                        $talla_botas_hombres[$row['talla_botas']][] = [$row['nombres'], $row['apellidos']];
                        $talla_nomex_hombres[$row['talla_nomex']][] = [$row['nombres'], $row['apellidos']];
                    } else {
                        $talla_camisa_mujeres[$row['talla_camisa']][] = [$row['nombres'], $row['apellidos']];
                        $talla_pantalon_mujeres[$row['talla_pantalon']][] = [$row['nombres'], $row['apellidos']];
                        $talla_botas_mujeres[$row['talla_botas']][] = [$row['nombres'], $row['apellidos']];
                        $talla_nomex_mujeres[$row['talla_nomex']][] = [$row['nombres'], $row['apellidos']];
                    }
                }
            } 
        }
    } 

    // Si hay un filtro por cédula, obtener los datos específicos del usuario
    if (!empty($cedula_filter)) {
        $sql_usuario = "
            SELECT u.nombres, u.apellidos, u.cedula, ur.genero, ur.talla_camisa, ur.talla_pantalon, ur.talla_botas, ur.talla_nomex
            FROM usuarios_r ur
            JOIN usuarios u ON ur.cedula = u.cedula
            WHERE u.anio_id = ? AND u.cedula = ?";
        $stmt_usuario = mysqli_prepare($conn, $sql_usuario);
        mysqli_stmt_bind_param($stmt_usuario, "is", $anio_id, $cedula_filter);
        mysqli_stmt_execute($stmt_usuario);
        $result_usuario = mysqli_stmt_get_result($stmt_usuario);
        if ($result_usuario->num_rows > 0) {
            $usuario_datos = mysqli_fetch_assoc($result_usuario);
        } 
    }
} catch (Exception $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Cristian Alejandro Jiménez Mora">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Resumen de Dotación por Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="font-sans" style="background-color: #E1EEE2;">
<header class="w-full bg-white mb-10 border-b-4 border-green-900 sticky top-0 z-50">
    <div class="container mx-auto flex flex-wrap p-5 items-center justify-between">
        <a href="../index.php" class="text-gray-900">
            <img src="/static/img/TF.png" alt="Logo" class="h-16 md:h-20">
        </a>
        <div class="block lg:hidden">
            <button id="menuToggle" class="text-green-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <nav id="navMenu" class="hidden lg:flex lg:items-center lg:space-x-8">
            <a href="/admin/años.php" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">AÑOS</a>
            <a href="/admin/index.php" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">PROYECTOS</a>
            <a href="/admin/public/registrarUsuarios.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">USUARIOS</a>
            <a href="/admin/public/rtaPrimerForm.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">RTA DATOS PERSONALES</a>
            <a href="/admin/public/almacen.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold py-2 px-4 rounded-md border-2 border-green-900 hover:bg-green-900 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-green-900">
                Entrar al almacen
            </a>
        </nav>
        <div class="hidden lg:block">
            <a href="../../../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-xs md:text-sm flex items-center">
                <img src="/admin/includes/imgs/cerrarsesion.png" class="w-4 h-4 mr-2" alt="Cerrar Sesión" />
                CERRAR SESIÓN
            </a>
        </div>
    </div>
</header>

<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });
</script>
<?php
include('../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['usuarios'])) {
        $usuarios_seleccionados = $_POST['usuarios'];

        foreach ($usuarios_seleccionados as $cedula) {
            $sql_usuario = "SELECT ur.genero FROM usuarios_r ur WHERE ur.cedula = '$cedula'";
            $resultado_usuario = $conn->query($sql_usuario);

            if ($resultado_usuario->num_rows > 0) {
                $usuario = $resultado_usuario->fetch_assoc();
                $genero_usuario = $usuario['genero'];
                if ($genero_usuario == 'Hombre') {
                    $cantidad_camisa_hombres--;
                    $cantidad_pantalon_hombres--;
                    $cantidad_botas_hombres--;
                    $cantidad_nomex_hombres--;
                } elseif ($genero_usuario == 'Mujer') {
                    $cantidad_camisa_mujeres--;
                    $cantidad_pantalon_mujeres--;
                    $cantidad_botas_mujeres--;
                    $cantidad_nomex_mujeres--;
                }
            }
            $update_sql = "UPDATE usuarios_r SET enviado = 1 WHERE cedula = '$cedula'";
            $conn->query($update_sql);
        }
        header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=$anio_id");
        exit();
    }

    if (isset($_POST['devolver_usuarios'])) {
        $usuarios_a_devolver = $_POST['devolver_usuarios'];

        foreach ($usuarios_a_devolver as $cedula) {
            $sql_usuario = "SELECT ur.genero FROM usuarios_r ur WHERE ur.cedula = '$cedula'";
            $resultado_usuario = $conn->query($sql_usuario);

            if ($resultado_usuario->num_rows > 0) {
                $usuario = $resultado_usuario->fetch_assoc();
                $genero_usuario = $usuario['genero'];
                if ($genero_usuario == 'Hombre') {
                    $cantidad_camisa_hombres++;
                    $cantidad_pantalon_hombres++;
                    $cantidad_botas_hombres++;
                    $cantidad_nomex_hombres++;
                } elseif ($genero_usuario == 'Mujer') {
                    $cantidad_camisa_mujeres++;
                    $cantidad_pantalon_mujeres++;
                    $cantidad_botas_mujeres++;
                    $cantidad_nomex_mujeres++;
                }
            }
            $update_sql = "UPDATE usuarios_r SET enviado = 0 WHERE cedula = '$cedula'";
            $conn->query($update_sql);
        }
        header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=$anio_id");
        exit();
    }
}
$anio_id = isset($_GET['anio_id']) ? $_GET['anio_id'] : null;
if (!$anio_id || !is_numeric($anio_id)) {
    echo "El parámetro 'anio_id' no es válido o no está presente.";
    exit();
}
$sql_enviados = "SELECT u.nombres, u.apellidos, u.cedula, ur.genero, ur.talla_camisa, ur.talla_pantalon, ur.talla_botas, ur.talla_nomex, ur.enviado
                 FROM usuarios u
                 INNER JOIN usuarios_r ur ON u.cedula = ur.cedula
                 WHERE ur.enviado = 0 AND u.anio_id = ?"; 

if ($stmt_enviados = mysqli_prepare($conn, $sql_enviados)) {
    mysqli_stmt_bind_param($stmt_enviados, "i", $anio_id); 
    mysqli_stmt_execute($stmt_enviados);
    $result_enviados = mysqli_stmt_get_result($stmt_enviados); 
} else {
    echo "Error al preparar la consulta para usuarios no enviados.";
    exit();
}

if (!$anio_id || !is_numeric($anio_id)) {
    echo "El parámetro 'anio_id' no es válido o no está presente.";
    exit();
}

$sql_completados = "SELECT u.nombres, u.apellidos, u.cedula, ur.genero, ur.talla_camisa, ur.talla_pantalon, ur.talla_botas, ur.talla_nomex, ur.enviado
                    FROM usuarios u
                    INNER JOIN usuarios_r ur ON u.cedula = ur.cedula
                    WHERE ur.enviado = 1 AND u.anio_id = ?"; 

if ($stmt_completados = mysqli_prepare($conn, $sql_completados)) {
    mysqli_stmt_bind_param($stmt_completados, "i", $anio_id); 
    mysqli_stmt_execute($stmt_completados);
    $result_completados = mysqli_stmt_get_result($stmt_completados); 
} else {
    echo "Error al preparar la consulta para usuarios ya enviados.";
    exit();
}
?>
<div class="bg-white rounded-lg p-5 w-full sm:w-5/6 ml-40 -mt-6">
    <form action="" method="POST">
        <input type="hidden" name="accion" value="actualizar_dotacion">

        <div class="flex justify-between items-center mt-0">
            <h3 class="text-xl font-semibold text-gray-800 -mt-4">Lista de pedidos sin enviar.</h3>
            <button type="submit" class="bg-green-600 text-white font-bold py-2 px-3 rounded-lg -mt-2 flex items-center">
                <img src="/admin/includes/imgs/enviar.png" class="w-5 h-5 mr-2" alt="Icono" />
                ENVIAR
            </button>
        </div>
        <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden border-collapse mt-2">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-center text-sm font-semibold">NOMBRES</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">APELLIDOS</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">CÉDULA</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">GÉNERO</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA CAMISA</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA PANTALÓN</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA BOTAS</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA NOMEX</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">ENVIADOS</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php
                if ($result_enviados->num_rows > 0) {
                    while ($row = $result_enviados->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['nombres']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['apellidos']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['cedula']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['genero']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_camisa']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_pantalon']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_botas']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_nomex']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>"
                            . "<input type='checkbox' name='usuarios[]' value='" . $row['cedula'] . "'>"
                            . "</td>";
                        echo "<td class='py-3 px-4 text-center'>
                            <button type='button' class='bg-white text-blue-500 border border-blue-500 py-1 px-3 rounded flex items-center hover:bg-blue-300 ' 
                            onclick='openEditModal(" . $row['cedula'] . ", \"" 
                                . htmlspecialchars($row['genero']) . "\", \"" 
                                . htmlspecialchars($row['talla_camisa']) . "\", \"" 
                                . htmlspecialchars($row['talla_pantalon']) . "\", \"" 
                                . htmlspecialchars($row['talla_botas']) . "\", \"" 
                                . htmlspecialchars($row['talla_nomex']) . "\")'>
                                <img src='/admin/includes/imgs/editar.svg' class='w-4 h-4 mr-2' alt='Editar' />
                                Editar
                            </button>
                        </td>";
                                                          
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='py-3 px-4 text-center'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</div>
<!-- Modal para editar usuario -->
<div id="editModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
        <h3 class="text-xl font-semibold text-gray-900 border-b pb-3 mb-4">Editar Usuario</h3>
        <form id="editForm" class="space-y-4">
            <div>
                <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                <input type="text" id="cedula" name="cedula" readonly class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-100">
            </div>
            <div>
                <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
                <input type="text" id="genero" name="genero" readonly class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-100">
            </div>
            <div>
                <label for="talla_camisa" class="block text-sm font-medium text-gray-700">Talla Camisa</label>
                <select id="talla_camisa" name="talla_camisa" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Seleccionar</option>
                </select>
            </div>
            <div>
                <label for="talla_pantalon" class="block text-sm font-medium text-gray-700">Talla Pantalón</label>
                <select id="talla_pantalon" name="talla_pantalon" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Seleccionar</option>
                </select>
            </div>
            <div>
                <label for="talla_botas" class="block text-sm font-medium text-gray-700">Talla Botas</label>
                <select id="talla_botas" name="talla_botas" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Seleccionar</option>
                </select>
            </div>
            <div>
                <label for="talla_nomex" class="block text-sm font-medium text-gray-700">Talla Nomex</label>
                <select id="talla_nomex" name="talla_nomex" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Seleccionar</option>
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Cancelar</button>
                <button type="button" onclick="guardarDatos()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-lg p-5 w-full sm:w-5/6 ml-40 mt-2">
    <form action="" method="POST">
        <!-- Campo oculto para identificar el formulario -->
        <input type="hidden" name="accion" value="devolver_usuarios">

        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-800 -mt-4">Lista de pedidos enviados.</h3>
            <button type="submit" class="bg-red-600 text-white font-bold py-2 px-2 rounded-lg -mt-2 flex items-center space-x-2">
                <img src="/admin/includes/imgs/atras.png" alt="" class="w-5 h-5"> <!-- Ajusta el tamaño del icono -->
                <span>Devolver</span>
            </button>

        </div>
        <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden border-collapse mt-2">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-center text-sm font-semibold">NOMBRES</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">APELLIDOS</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">CÉDULA</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">GÉNERO</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA CAMISA</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA PANTALÓN</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA BOTAS</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">TALLA NOMEX</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">DEVOLVER</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php
                // Mostrar los usuarios que ya han sido enviados
                if ($result_completados->num_rows > 0) {
                    while ($row = $result_completados->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['nombres']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['apellidos']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['cedula']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['genero']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_camisa']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_pantalon']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_botas']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($row['talla_nomex']) . "</td>";
                        echo "<td class='py-3 px-4 text-center'>"
                            . "<input type='checkbox' name='devolver_usuarios[]' value='" . $row['cedula'] . "'>"
                            . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='py-3 px-4 text-center'>No hay datos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
</div>

<div class="flex flex-col sm:flex-row mx-8 sm:mx-8 lg:mx-40 space-x-8 mt-2">
    <div class="float-right bg-white rounded-lg p-4 mb-8" >
        <h3 class="text-xl font-semibold text-gray-800 -mt-2">Dotación por Usuario</h3>
        <form action="" method="GET" class="flex flex-col sm:flex-row sm:items-center">
            <label for="cedula" class="text-sm font-semibold text-gray-700 mr-2 mb-2 sm:mb-0 mt-4">Filtrar por Cédula:</label>
            <input type="text" name="cedula" id="cedula" class="p-2 border border-gray-300 rounded-lg mb-2 sm:mb-0 w-56" maxlength="10" value="<?php echo htmlspecialchars($cedula_filter); ?>" placeholder="Ingrese número de cédula">
            <input type="hidden" name="anio_id" value="<?php echo htmlspecialchars($anio_id); ?>"> <!-- Mantener el anio_id -->
            <button type="submit" class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg sm:ml-4">Filtrar</button>
        </form>

        <?php if (!empty($cedula_filter) && $usuario_datos): ?>
            <div id="user-details" class="bg-gray-100 p-4 rounded-lg mb-6">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario_datos['nombres']); ?></p>
                <p><strong>Apellido:</strong> <?php echo htmlspecialchars($usuario_datos['apellidos']); ?></p>
                <p><strong>Cédula:</strong> <?php echo htmlspecialchars($usuario_datos['cedula']); ?></p>
                <p><strong>Género:</strong> <?php echo htmlspecialchars($usuario_datos['genero']); ?></p>
                <p><strong>Talla Camisa:</strong> <?php echo htmlspecialchars($usuario_datos['talla_camisa']); ?></p>
                <p><strong>Talla Pantalón:</strong> <?php echo htmlspecialchars($usuario_datos['talla_pantalon']); ?></p>
                <p><strong>Talla Botas:</strong> <?php echo htmlspecialchars($usuario_datos['talla_botas']); ?></p>
                <p><strong>Talla Nomex:</strong> <?php echo htmlspecialchars($usuario_datos['talla_nomex']); ?></p>
                <div class="flex justify-center">
                    <button id="toggle-button" onclick="toggleUserDetails()" class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg mt-4">
                        Ocultar
                    </button>
                </div>
                </div>
                    <?php elseif (!empty($cedula_filter)): ?>
                        <p class="text-red-600 font-semibold">No se encontraron datos para la cédula proporcionada.</p>
                    <?php endif; ?>
                </div>

                <!-- Resumen de Dotación por Género (Hombres) -->
                <div class="bg-white rounded-lg p-6 w-full sm:w-1/3 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800">Dotación - Hombres</h3>
                    <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden border-collapse mt-8">
                        <thead class="bg-green-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-center text-sm font-semibold">Tipo de Prenda</th>
                                <th class="py-3 px-4 text-center text-sm font-semibold">Talla</th>
                                <th class="py-3 px-4 text-center text-sm font-semibold">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($talla_camisa_hombres as $talla => $nombres): ?>
                                <?php if (count($nombres) > 0): ?>
                                    <tr>
                                        <td class="py-3 px-4 text-center">Camisa</td>
                                        <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                        <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($talla_pantalon_hombres as $talla => $nombres): ?>
                                <?php if (count($nombres) > 0): ?>
                                    <tr>
                                        <td class="py-3 px-4 text-center">Pantalón</td>
                                        <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                        <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($talla_botas_hombres as $talla => $nombres): ?>
                                <?php if (count($nombres) > 0): ?>
                                    <tr>
                                        <td class="py-3 px-4 text-center">Botas</td>
                                        <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                        <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($talla_nomex_hombres as $talla => $nombres): ?>
                                <?php if (count($nombres) > 0): ?>
                                    <tr>
                                        <td class="py-3 px-4 text-center">Nomex</td>
                                        <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                        <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Resumen de Dotación por Género (Mujeres) -->
                <div class="bg-white rounded-lg p-6 w-full sm:w-1/3 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800">Dotación - Mujeres</h3>
                    <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden border-collapse mt-8">
                        <thead class="bg-green-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-center text-sm font-semibold">Tipo de Prenda</th>
                                <th class="py-3 px-4 text-center text-sm font-semibold">Talla</th>
                                <th class="py-3 px-4 text-center text-sm font-semibold">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($talla_camisa_mujeres as $talla => $nombres): ?>
                                <tr>
                                    <td class="py-3 px-4 text-center">Camisa</td>
                                    <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                    <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php foreach ($talla_pantalon_mujeres as $talla => $nombres): ?>
                                <tr>
                                    <td class="py-3 px-4 text-center">Pantalón</td>
                                    <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                    <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php foreach ($talla_botas_mujeres as $talla => $nombres): ?>
                                <tr>
                                    <td class="py-3 px-4 text-center">Botas</td>
                                    <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                    <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php foreach ($talla_nomex_mujeres as $talla => $nombres): ?>
                                <tr>
                                    <td class="py-3 px-4 text-center">Nomex</td>
                                    <td class="py-3 px-4 text-center"><?php echo htmlspecialchars($talla); ?></td>
                                    <td class="py-3 px-4 text-center"><?php echo count($nombres); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                const openModalBtn = document.getElementById('openModalBtn');
                const closeModalBtns = document.querySelectorAll('#closeModalBtn');
                const modal = document.getElementById('myModal');
                const dotacionForm = document.getElementById('dotacionForm');

                openModalBtn.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                });

                closeModalBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        modal.classList.add('hidden');
                    });
                });

                dotacionForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    
                    fetch(window.location.href, {
                        method: 'POST',
                        body: new FormData(dotacionForm)
                    }).then(() => {
                        dotacionForm.reset();
                        
                        modal.classList.add('hidden');
                        
                        localStorage.setItem('openModal', 'true');
                        
                        location.reload();
                    }).catch((error) => {
                        console.error('Error al enviar el formulario', error);
                    });
                });

                window.addEventListener('load', () => {
                    const openModal = localStorage.getItem('openModal');
                    
                    if (openModal === 'true') {
                        setTimeout(() => {
                            modal.classList.remove('hidden');
                        }, 500); 

                        localStorage.removeItem('openModal');
                    }
                });

                function toggleUserDetails() {
                    var userDetails = document.getElementById('user-details');

                    if (userDetails.style.display === 'none') {
                        userDetails.style.display = 'block';
                        document.getElementById('toggle-button').innerText = 'Ocultar';
                    } else {
                        userDetails.style.display = 'none';
                        document.getElementById('toggle-button').innerText = 'Mostrar';
                    }
                }   

                function openEditModal(cedula, genero, tallaCamisa, tallaPantalon, tallaBotas, tallaNomex) {
                    // Cargar cédula y género
                    document.getElementById('cedula').value = cedula;
                    document.getElementById('genero').value = genero;

                    // Llenar opciones según género
                    updateOptions(genero, tallaCamisa, tallaPantalon, tallaBotas, tallaNomex);

                    // Mostrar modal
                    document.getElementById('editModal').classList.remove('hidden');
                }

                function updateOptions(genero, tallaCamisa, tallaPantalon, tallaBotas, tallaNomex) {
                    const camisa = document.getElementById('talla_camisa');
                    const pantalon = document.getElementById('talla_pantalon');
                    const botas = document.getElementById('talla_botas');
                    const nomex = document.getElementById('talla_nomex');

                    // Opciones predefinidas
                    const tallasCamisaF = ['S', 'M', 'L', 'XL', 'XXL'];
                    const tallasPantalonF = [6, 8, 10, 12, 14, 16, 18, 20, 22];
                    const tallasBotasF = [35, 36, 37, 38];
                    const tallasNomexF = [34, 36, 38, 40];

                    const tallasCamisaM = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                    const tallasPantalonM = [28, 30, 32, 34, 36, 38, 40, 42, 44];
                    const tallasBotasM = [39, 40, 41, 42, 43, 44, 45, 46];
                    const tallasNomexM = [42, 44, 46, 48, 50];

                    // Limpia las opciones actuales
                    camisa.innerHTML = '';
                    pantalon.innerHTML = '';
                    botas.innerHTML = '';
                    nomex.innerHTML = '';

                    // Verifica género y llena opciones
                    let options = {};
                    if (genero.toLowerCase() === 'femenino') {
                        options = { camisas: tallasCamisaF, pantalones: tallasPantalonF, botas: tallasBotasF, nomex: tallasNomexF };
                    } else if (genero.toLowerCase() === 'masculino') {
                        options = { camisas: tallasCamisaM, pantalones: tallasPantalonM, botas: tallasBotasM, nomex: tallasNomexM };
                    } else {
                        console.warn('Género no reconocido: ', genero);
                        return;
                    }

                    // Rellenar selects
                    fillSelect(camisa, options.camisas, tallaCamisa);
                    fillSelect(pantalon, options.pantalones, tallaPantalon);
                    fillSelect(botas, options.botas, tallaBotas);
                    fillSelect(nomex, options.nomex, tallaNomex);
                }

                function fillSelect(select, options, currentValue) {
                    if (currentValue) {
                        // Agrega la opción actual como primera y seleccionada
                        const opt = document.createElement('option');
                        opt.value = currentValue;
                        opt.textContent = currentValue;
                        opt.selected = true;
                        select.appendChild(opt);
                    }

                    // Agregar el resto de opciones
                    options.forEach(option => {
                        if (option !== currentValue) { // Evitar duplicar la opción actual
                            const opt = document.createElement('option');
                            opt.value = option;
                            opt.textContent = option;
                            select.appendChild(opt);
                        }
                    });
                }

                function closeEditModal() {
                    document.getElementById('editModal').classList.add('hidden');
                }

                function guardarDatos() {
                    const form = document.getElementById('editForm');
                    const datos = new FormData(form);

                    const jsonDatos = {};
                    datos.forEach((value, key) => {
                        jsonDatos[key] = value;
                    });

                // Asegúrate de que el estilo se aplique a todo el documento
                document.body.style.fontFamily = '"Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif';
                    fetch('actualizar_usuario.php', {
                    method: 'POST',
                    body: JSON.stringify(jsonDatos),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Solo la alerta de SweetAlert
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Datos actualizados correctamente",
                            showConfirmButton: false,
                            timer: 1500 
                        }).then(() => {
                            // Esperar a que SweetAlert se cierre antes de recargar la página
                            closeEditModal();
                            location.reload();
                        });
                    } else {
                        alert('Hubo un error al actualizar los datos');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al procesar la solicitud');
                });
            }
        </script>
    </body>
</html>
