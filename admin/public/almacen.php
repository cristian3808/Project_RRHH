<?php
session_start();
include('../../config/db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['anio_id'])) {
    die("ID de proyecto no especificado.");
}

$anio_id = $_GET['anio_id']; 

// Verificar si se ha enviado el formulario para insertar dotación o camisas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {              
    $mensaje = ''; 
    $mensaje_error = '';

    // Verificar si se han enviado los formularios para insertar 
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_camisas') {
        if (isset($_POST['cantidad_camisas'], $_POST['talla_camisas'], $_POST['fecha_subida'])) {
            // Obtener los datos del formulario
            $cantidad_camisas = $_POST['cantidad_camisas'];
            $talla_camisas = $_POST['talla_camisas'];
            $fecha_subida = $_POST['fecha_subida'];

            // Verificar que el valor de talla_camisas no sea vacío
            if (empty($talla_camisas)) {
                $mensaje_error = "Error: La talla de la camisa no ha sido seleccionada.";
            } else {
                // Insertar los datos en la base de datos
                $sql = "INSERT INTO camisas_hombre (cantidad_camisas, talla_camisas, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssi", $cantidad_camisas, $talla_camisas, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                        // $mensaje = 'Camisa insertada correctamente.';
                    } else {
                        $mensaje_error = "Error al insertar camisas: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_jeans') {
        if (isset($_POST['cantidad_jeans'], $_POST['talla_jeans'], $_POST['fecha_subida'])) {
            $cantidad_jeans = $_POST['cantidad_jeans'];
            $talla_jeans = $_POST['talla_jeans'];
            $fecha_subida = $_POST['fecha_subida'];
            if (empty($talla_jeans)) {
                $mensaje_error = "Error: La talla del pantalón no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO jeans_hombre (cantidad_jeans, talla_jeans, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iisi", $cantidad_jeans, $talla_jeans, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar jeans: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_camisas_mujer') {
        if (isset($_POST['cantidad_camisas'], $_POST['talla_camisas'], $_POST['fecha_subida'])) {
            $cantidad_camisas = $_POST['cantidad_camisas'];
            $talla_camisas = $_POST['talla_camisas'];
            $fecha_subida = $_POST['fecha_subida'];

            if (empty($talla_camisas)) {
                $mensaje_error = "Error: La talla de la camisa no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO camisas_mujer (cantidad_camisas, talla_camisas, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssi", $cantidad_camisas, $talla_camisas, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar camisas: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_jeans_mujer') {
        if (isset($_POST['cantidad_jeans'], $_POST['talla_jeans'], $_POST['fecha_subida'])) {
            $cantidad_jeans = $_POST['cantidad_jeans'];
            $talla_jeans = $_POST['talla_jeans'];
            $fecha_subida = $_POST['fecha_subida'];

            if (empty($talla_jeans)) {
                $mensaje_error = "Error: La talla del pantalón no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO jeans_mujer (cantidad_jeans, talla_jeans, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iisi", $cantidad_jeans, $talla_jeans, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar jeans: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_botas') {
        if (isset($_POST['cantidad_botas'], $_POST['talla_botas'], $_POST['fecha_subida'])) {
            $cantidad_botas = $_POST['cantidad_botas'];
            $talla_botas = $_POST['talla_botas'];
            $fecha_subida = $_POST['fecha_subida'];

            if (empty($talla_botas)) {
                $mensaje_error = "Error: La talla de las botas no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO botas (cantidad_botas, talla_botas, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssi", $cantidad_botas, $talla_botas, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar botas: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_nomex') {
        if (isset($_POST['cantidad_nomex'], $_POST['talla_nomex'], $_POST['fecha_subida'])) {
            $cantidad_nomex = $_POST['cantidad_nomex'];
            $talla_nomex = $_POST['talla_nomex'];
            $fecha_subida = $_POST['fecha_subida'];
            if (empty($talla_nomex)) {
                $mensaje_error = "Error: La talla del nomex no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO nomex (cantidad_nomex, talla_nomex, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iisi", $cantidad_nomex, $talla_nomex, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar nomex: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }   
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_gafas') {
        if (isset($_POST['cantidad_gafas'], $_POST['color_gafas'], $_POST['fecha_subida'])) {
            $cantidad_gafas = $_POST['cantidad_gafas'];
            $color_gafas = $_POST['color_gafas'];
            $fecha_subida = $_POST['fecha_subida'];

            if (empty($color_gafas)) {
                $mensaje_error = "Error: El color de las gafas no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO gafas (cantidad_gafas, color_gafas, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "issi", $cantidad_gafas, $color_gafas, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar gafas: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_gafas_especiales') {
        if (isset($_POST['cantidad_gafas_especiales'], $_POST['color_gafas_especiales'], $_POST['fecha_subida'])) {
            $cantidad_gafas_especiales = $_POST['cantidad_gafas_especiales'];
            $color_gafas_especiales = $_POST['color_gafas_especiales'];
            $fecha_subida = $_POST['fecha_subida'];

            if (empty($color_gafas_especiales)) {
                $mensaje_error = "Error: El color de las gafas no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO gafas_especiales (cantidad_gafas_especiales, color_gafas_especiales, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "issi", $cantidad_gafas_especiales, $color_gafas_especiales, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar gafas especiales: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_cascos') {
        if (isset($_POST['cantidad_cascos'], $_POST['fecha_subida'])) {
            $cantidad_cascos = $_POST['cantidad_cascos'];
            $fecha_subida = $_POST['fecha_subida'];

            $sql = "INSERT INTO cascos (cantidad_cascos, fecha_subida, anio_id) 
                        VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "isi", $cantidad_cascos, $fecha_subida, $anio_id);
                if (mysqli_stmt_execute($stmt)) {
                } else {
                    $mensaje_error = "Error al insertar cascos: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_guantes') {
        if (isset($_POST['cantidad_guantes'], $_POST['fecha_subida'])) {
            $cantidad_guantes = $_POST['cantidad_guantes'];
            $fecha_subida = $_POST['fecha_subida'];

            $sql = "INSERT INTO guantes (cantidad_guantes, fecha_subida, anio_id) 
                        VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "isi", $cantidad_guantes, $fecha_subida, $anio_id);
                if (mysqli_stmt_execute($stmt)) {
                } else {
                    $mensaje_error = "Error al insertar guantes: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_tapabocas') {
        if (isset($_POST['cantidad_tapabocas'], $_POST['fecha_subida'])) {
            $cantidad_tapabocas = $_POST['cantidad_tapabocas'];
            $fecha_subida = $_POST['fecha_subida'];

            $sql = "INSERT INTO tapabocas (cantidad_tapabocas, fecha_subida, anio_id) 
                        VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "isi", $cantidad_tapabocas, $fecha_subida, $anio_id);
                if (mysqli_stmt_execute($stmt)) {
                } else {
                    $mensaje_error = "Error al insertar tapabocas: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_mascarillas') {
        if (isset($_POST['cantidad_mascarillas'], $_POST['fecha_subida'])) {
            $cantidad_mascarillas = $_POST['cantidad_mascarillas'];
            $fecha_subida = $_POST['fecha_subida'];

            $sql = "INSERT INTO mascarillas (cantidad_mascarillas, fecha_subida, anio_id) 
                        VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "isi", $cantidad_mascarillas, $fecha_subida, $anio_id);
                if (mysqli_stmt_execute($stmt)) {
                } else {
                    $mensaje_error = "Error al insertar mascarillas: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar_tapa_oidos') {
        if (isset($_POST['cantidad_tapa_oidos'], $_POST['nombre_tapa_oidos'], $_POST['fecha_subida'])) {
            $cantidad_tapa_oidos = $_POST['cantidad_tapa_oidos'];
            $nombre_tapa_oidos = $_POST['nombre_tapa_oidos'];
            $fecha_subida = $_POST['fecha_subida'];

            if (empty($nombre_tapa_oidos)) {
                $mensaje_error = "Error: El tapa oidos no ha sido seleccionada.";
            } else {
                $sql = "INSERT INTO tapa_oidos (cantidad_tapa_oidos, nombre_tapa_oidos, fecha_subida, anio_id) 
                        VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "issi", $cantidad_tapa_oidos, $nombre_tapa_oidos, $fecha_subida, $anio_id);
                    if (mysqli_stmt_execute($stmt)) {
                    } else {
                        $mensaje_error = "Error al insertar tapa oidos: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }   
    if ($mensaje_error) {
        $_SESSION['mensaje_error'] = $mensaje_error;
    } else {
        $_SESSION['mensaje'] = $mensaje;
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?anio_id=" . $anio_id);
    exit();
}

// Aquí puedes manejar la visualización de cualquier mensaje que hayas almacenado en la sesión
if (isset($_SESSION['mensaje'])) {
    echo $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
}

// Obtén el valor de anio_id desde la URL
$anio_id = isset($_GET['anio_id']) ? (int)$_GET['anio_id'] : 0;

// Consulta para obtener el total de camisas de hombres por talla según el anio_id
$sql_totales_por_talla = "SELECT talla_camisas, 
                            SUM(cantidad_camisas) AS total_camisas
                        FROM camisas_hombre
                        WHERE anio_id = ?
                        GROUP BY talla_camisas";

if ($stmt_totales_por_talla = mysqli_prepare($conn, $sql_totales_por_talla)) {
    mysqli_stmt_bind_param($stmt_totales_por_talla, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_talla);
    $result_totales_por_talla = mysqli_stmt_get_result($stmt_totales_por_talla);
    
    $totales_por_talla = [
        'S' => 0,'M' => 0,'L' => 0,'XL' => 0,'XXL' => 0,'XXXL' => 0
    ];
    
    // Llenar el array con los totales por talla
    if ($result_totales_por_talla && mysqli_num_rows($result_totales_por_talla) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_talla)) {
            $talla = strtoupper($row['talla_camisas']);
            if (array_key_exists($talla, $totales_por_talla)) {
                $totales_por_talla[$talla] = $row['total_camisas'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_talla);
} else {
    $totales_por_talla = [
        'S' => 0,'M' => 0,'L' => 0,'XL' => 0,'XXL' => 0,'XXXL' => 0
    ];
}
// Consulta para obtener los usuarios cuyo 'enviado' es 1 y el género es masculino
$sql_usuarios_enviados = "SELECT talla_camisa FROM usuarios_r WHERE enviado = 1 AND genero = 'masculino'";
if ($stmt_usuarios_enviados = mysqli_prepare($conn, $sql_usuarios_enviados)) {
    mysqli_stmt_execute($stmt_usuarios_enviados);
    $result_usuarios_enviados = mysqli_stmt_get_result($stmt_usuarios_enviados);

    // Recorrer los resultados y disminuir el total de camisas de la talla correspondiente
    if ($result_usuarios_enviados && mysqli_num_rows($result_usuarios_enviados) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios_enviados)) {
            $talla_usuario = strtoupper($row['talla_camisa']);
            
            // Si la talla existe en el array, decrementa la cantidad de camisas
            if (array_key_exists($talla_usuario, $totales_por_talla)) {
                $totales_por_talla[$talla_usuario] = max(0, $totales_por_talla[$talla_usuario] - 1); // Evita que el total sea negativo
            }
        }
    }
    mysqli_stmt_close($stmt_usuarios_enviados);
} else {
    $totales_por_talla = [
        'S' => 0,'M' => 0,'L' => 0,'XL' => 0,'XXL' => 0,'XXXL' => 0
    ];
}

// Consulta para obtener el total de jeans de hombres por talla según el anio_id
$sql_totales_por_talla_jeans_h = "SELECT talla_jeans, 
                                    SUM(cantidad_jeans) AS total_jeans
                                FROM jeans_hombre
                                WHERE anio_id = ?
                                GROUP BY talla_jeans";

if ($stmt_totales_por_talla_jeans_h = mysqli_prepare($conn, $sql_totales_por_talla_jeans_h)) {
    mysqli_stmt_bind_param($stmt_totales_por_talla_jeans_h, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_talla_jeans_h);
    $result_totales_por_talla_jeans_h = mysqli_stmt_get_result($stmt_totales_por_talla_jeans_h);
    
    $totales_por_talla_jeans_h = [
        '28' => 0, '30' => 0, '32' => 0, '34' => 0, '36' => 0, 
        '38' => 0, '40' => 0, '42' => 0, '44' => 0
    ];
    
    // Llenar el array con los totales por talla
    if ($result_totales_por_talla_jeans_h && mysqli_num_rows($result_totales_por_talla_jeans_h) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_talla_jeans_h)) {
            $talla = strtoupper($row['talla_jeans']);
            if (array_key_exists($talla, $totales_por_talla_jeans_h)) {
                $totales_por_talla_jeans_h[$talla] = $row['total_jeans'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_talla_jeans_h);
} else {
    $totales_por_talla_jeans_h = [
        '28' => 0, '30' => 0, '32' => 0, '34' => 0, '36' => 0, 
        '38' => 0, '40' => 0, '42' => 0, '44' => 0
    ];
}
// Consulta para obtener los usuarios cuyo 'enviado' es 1 y el género es masculino
$sql_usuarios_enviados_jeans_h = "SELECT talla_pantalon 
                                  FROM usuarios_r 
                                  WHERE enviado = 1 AND genero = 'masculino'";

if ($stmt_usuarios_enviados_jeans_h = mysqli_prepare($conn, $sql_usuarios_enviados_jeans_h)) {
    mysqli_stmt_execute($stmt_usuarios_enviados_jeans_h);
    $result_usuarios_enviados_jeans_h = mysqli_stmt_get_result($stmt_usuarios_enviados_jeans_h);

    // Recorrer los resultados y disminuir el total de jeans de la talla correspondiente
    if ($result_usuarios_enviados_jeans_h && mysqli_num_rows($result_usuarios_enviados_jeans_h) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios_enviados_jeans_h)) {
            $talla_usuario = strtoupper($row['talla_pantalon']);
            
            // Si la talla existe en el array, decrementa la cantidad de jeans
            if (array_key_exists($talla_usuario, $totales_por_talla_jeans_h)) {
                $totales_por_talla_jeans_h[$talla_usuario] = max(0, $totales_por_talla_jeans_h[$talla_usuario] - 1); // Evita que el total sea negativo
            }
        }
    }
    mysqli_stmt_close($stmt_usuarios_enviados_jeans_h);
} else {
    $totales_por_talla_jeans_h = [
        '28' => 0, '30' => 0, '32' => 0, '34' => 0, '36' => 0, 
        '38' => 0, '40' => 0, '42' => 0, '44' => 0
    ];
}

// Consulta para obtener el total de botas por talla según el anio_id
$sql_totales_por_talla_botas = "SELECT talla_botas, 
                                SUM(cantidad_botas) AS total_botas
                            FROM botas
                            WHERE anio_id = ?
                            GROUP BY talla_botas";

if ($stmt_totales_por_talla_botas = mysqli_prepare($conn, $sql_totales_por_talla_botas)) {
    mysqli_stmt_bind_param($stmt_totales_por_talla_botas, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_talla_botas);
    $result_totales_por_talla_botas = mysqli_stmt_get_result($stmt_totales_por_talla_botas);

    // Inicialización del array con tallas de botas
    $totales_por_talla_botas = [
        '35' => 0,'36' => 0,'37' => 0,'38' => 0,'39' => 0,'40' => 0,'41' => 0,'42' => 0,'43' => 0,'44' => 0,'45' => 0,'46' => 0
    ];

    // Llenar el array con los totales por talla
    if ($result_totales_por_talla_botas && mysqli_num_rows($result_totales_por_talla_botas) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_talla_botas)) {
            $talla_botas = strtoupper($row['talla_botas']);
            if (array_key_exists($talla_botas, $totales_por_talla_botas)) {
                $totales_por_talla_botas[$talla_botas] = $row['total_botas'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_talla_botas);
} else {
    $totales_por_talla_botas = [
        '35' => 0,'36' => 0,'37' => 0,'38' => 0,'39' => 0,'40' => 0,'41' => 0,'42' => 0,'43' => 0,'44' => 0,'45' => 0,'46' => 0
    ];
}
// Consulta para obtener los usuarios cuyo 'enviado' es 1 y el género es masculino o femenino
$sql_usuarios_enviados_botas = "SELECT talla_botas, genero 
                                FROM usuarios_r 
                                WHERE enviado = 1 AND (genero = 'masculino' OR genero = 'femenino')";

if ($stmt_usuarios_enviados_botas = mysqli_prepare($conn, $sql_usuarios_enviados_botas)) {
    mysqli_stmt_execute($stmt_usuarios_enviados_botas);
    $result_usuarios_enviados_botas = mysqli_stmt_get_result($stmt_usuarios_enviados_botas);

    // Recorrer los resultados y disminuir el total de botas de la talla correspondiente
    if ($result_usuarios_enviados_botas && mysqli_num_rows($result_usuarios_enviados_botas) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios_enviados_botas)) {
            $talla_usuario = strtoupper($row['talla_botas']);
            
            // Si la talla existe en el array, decrementa la cantidad de botas
            if (array_key_exists($talla_usuario, $totales_por_talla_botas)) {
                $totales_por_talla_botas[$talla_usuario] = max(0, $totales_por_talla_botas[$talla_usuario] - 1); // Evita que el total sea negativo
            }
        }
    }
    mysqli_stmt_close($stmt_usuarios_enviados_botas);
} else {
    $totales_por_talla_botas = [
        '35' => 0,'36' => 0,'37' => 0,'38' => 0,'39' => 0,'40' => 0,'41' => 0,'42' => 0,'43' => 0,'44' => 0,'45' => 0,'46' => 0
    ];
}

// Consulta para obtener el total de Nomex por talla según el anio_id
$sql_totales_por_talla_nomex = "SELECT talla_nomex, 
                                    SUM(cantidad_nomex) AS total_nomex
                                FROM nomex
                                WHERE anio_id = ?
                                GROUP BY talla_nomex";

if ($stmt_totales_por_talla_nomex = mysqli_prepare($conn, $sql_totales_por_talla_nomex)) {
    mysqli_stmt_bind_param($stmt_totales_por_talla_nomex, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_talla_nomex);
    $result_totales_por_talla_nomex = mysqli_stmt_get_result($stmt_totales_por_talla_nomex);

    // Inicialización del array con tallas de Nomex
    $totales_por_talla_nomex = [
        '34' => 0, '36' => 0, '38' => 0, '40' => 0, '42' => 0, '44' => 0, '46' => 0, '48' => 0, '50' => 0, '52' => 0, '54' => 0
    ];

    // Llenar el array con los totales por talla
    if ($result_totales_por_talla_nomex && mysqli_num_rows($result_totales_por_talla_nomex) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_talla_nomex)) {
            $talla_nomex = strtoupper($row['talla_nomex']);
            if (array_key_exists($talla_nomex, $totales_por_talla_nomex)) {
                $totales_por_talla_nomex[$talla_nomex] = $row['total_nomex'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_talla_nomex);
} else {
    // Si la consulta falla, inicializamos el array con los valores predeterminados
    $totales_por_talla_nomex = [
        '34' => 0, '36' => 0, '38' => 0, '40' => 0, '42' => 0, '44' => 0, '46' => 0, '48' => 0, '50' => 0, '52' => 0, '54' => 0
    ];
}
// Consulta para obtener los usuarios cuyo 'enviado' es 1 (enviaron su talla) y género (masculino o femenino)
$sql_usuarios_enviados_nomex = "SELECT talla_nomex, genero 
                                FROM usuarios_r 
                                WHERE enviado = 1 AND (genero = 'masculino' OR genero = 'femenino')";

if ($stmt_usuarios_enviados_nomex = mysqli_prepare($conn, $sql_usuarios_enviados_nomex)) {
    mysqli_stmt_execute($stmt_usuarios_enviados_nomex);
    $result_usuarios_enviados_nomex = mysqli_stmt_get_result($stmt_usuarios_enviados_nomex);

    // Recorrer los resultados y disminuir el total de Nomex de la talla correspondiente
    if ($result_usuarios_enviados_nomex && mysqli_num_rows($result_usuarios_enviados_nomex) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios_enviados_nomex)) {
            $talla_usuario = strtoupper($row['talla_nomex']);
            
            // Si la talla existe en el array, decrementa la cantidad de Nomex
            if (array_key_exists($talla_usuario, $totales_por_talla_nomex)) {
                $totales_por_talla_nomex[$talla_usuario] = max(0, $totales_por_talla_nomex[$talla_usuario] - 1); // Evita que el total sea negativo
            }
        }
    }
    mysqli_stmt_close($stmt_usuarios_enviados_nomex);
} else {
    // Si la consulta falla, inicializamos el array con los valores predeterminados
    $totales_por_talla_nomex = [
        '34' => 0, '36' => 0, '38' => 0, '40' => 0, '42' => 0, '44' => 0, '46' => 0, '48' => 0, '50' => 0, '52' => 0, '54' => 0
    ];
}

// Consulta para obtener el total de camisas de mujeres por talla según el anio_id
$sql_totales_por_talla_camisas_mujer = "SELECT talla_camisas, 
                                        SUM(cantidad_camisas) AS total_camisas
                                    FROM camisas_mujer
                                    WHERE anio_id = ?
                                    GROUP BY talla_camisas";

if ($stmt_totales_por_talla_camisas_mujer = mysqli_prepare($conn, $sql_totales_por_talla_camisas_mujer)) {
    mysqli_stmt_bind_param($stmt_totales_por_talla_camisas_mujer, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_talla_camisas_mujer);
    $result_totales_por_talla_camisas_mujer = mysqli_stmt_get_result($stmt_totales_por_talla_camisas_mujer);

    $totales_por_talla_camisas_mujer = [
        'S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0, 'XXL' => 0
    ];

    // Llenar el array con los totales por talla
    if ($result_totales_por_talla_camisas_mujer && mysqli_num_rows($result_totales_por_talla_camisas_mujer) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_talla_camisas_mujer)) {
            $talla = strtoupper($row['talla_camisas']);
            if (array_key_exists($talla, $totales_por_talla_camisas_mujer)) {
                $totales_por_talla_camisas_mujer[$talla] = $row['total_camisas'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_talla_camisas_mujer);
} else {
    $totales_por_talla_camisas_mujer = [
        'S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0, 'XXL' => 0
    ];
}
// Consulta para obtener los usuarios cuyo 'enviado' es 1 y el género es femenino
$sql_usuarios_enviados_camisas_mujer = "SELECT talla_camisa 
                                        FROM usuarios_r 
                                        WHERE enviado = 1 AND genero = 'femenino'";

if ($stmt_usuarios_enviados_camisas_mujer = mysqli_prepare($conn, $sql_usuarios_enviados_camisas_mujer)) {
    mysqli_stmt_execute($stmt_usuarios_enviados_camisas_mujer);
    $result_usuarios_enviados_camisas_mujer = mysqli_stmt_get_result($stmt_usuarios_enviados_camisas_mujer);

    // Recorrer los resultados y disminuir el total de camisas de la talla correspondiente
    if ($result_usuarios_enviados_camisas_mujer && mysqli_num_rows($result_usuarios_enviados_camisas_mujer) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios_enviados_camisas_mujer)) {
            $talla_usuario = strtoupper($row['talla_camisa']);
            
            // Si la talla existe en el array, decrementa la cantidad de camisas
            if (array_key_exists($talla_usuario, $totales_por_talla_camisas_mujer)) {
                $totales_por_talla_camisas_mujer[$talla_usuario] = max(0, $totales_por_talla_camisas_mujer[$talla_usuario] - 1); // Evita que el total sea negativo
            }
        }
    }
    mysqli_stmt_close($stmt_usuarios_enviados_camisas_mujer);
} else {
    $totales_por_talla_camisas_mujer = [
        'S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0, 'XXL' => 0
    ];
}

// Consulta para obtener el total de jeans de mujeres por talla según el anio_id
$sql_totales_por_talla_jeans_mujer = "SELECT talla_jeans, 
                                        SUM(cantidad_jeans) AS total_jeans
                                    FROM jeans_mujer
                                    WHERE anio_id = ?
                                    GROUP BY talla_jeans";

if ($stmt_totales_por_talla_jeans_mujer = mysqli_prepare($conn, $sql_totales_por_talla_jeans_mujer)) {
    mysqli_stmt_bind_param($stmt_totales_por_talla_jeans_mujer, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_talla_jeans_mujer);
    $result_totales_por_talla_jeans_mujer = mysqli_stmt_get_result($stmt_totales_por_talla_jeans_mujer);

    $totales_por_talla_jeans_mujer = [
        '6' => 0, '8' => 0, '10' => 0, '12' => 0, '14' => 0,
        '16' => 0, '18' => 0, '20' => 0, '22' => 0
    ];

    // Llenar el array con los totales por talla
    if ($result_totales_por_talla_jeans_mujer && mysqli_num_rows($result_totales_por_talla_jeans_mujer) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_talla_jeans_mujer)) {
            $talla = strtoupper($row['talla_jeans']);
            if (array_key_exists($talla, $totales_por_talla_jeans_mujer)) {
                $totales_por_talla_jeans_mujer[$talla] = $row['total_jeans'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_talla_jeans_mujer);
} else {
    $totales_por_talla_jeans_mujer = [
        '6' => 0, '8' => 0, '10' => 0, '12' => 0, '14' => 0,
        '16' => 0, '18' => 0, '20' => 0, '22' => 0
    ];
}
// Consulta para obtener los usuarios cuyo 'enviado' es 1 y el género es femenino
$sql_usuarios_enviados_jeans_mujer = "SELECT talla_pantalon 
                                      FROM usuarios_r 
                                      WHERE enviado = 1 AND genero = 'femenino'";

if ($stmt_usuarios_enviados_jeans_mujer = mysqli_prepare($conn, $sql_usuarios_enviados_jeans_mujer)) {
    mysqli_stmt_execute($stmt_usuarios_enviados_jeans_mujer);
    $result_usuarios_enviados_jeans_mujer = mysqli_stmt_get_result($stmt_usuarios_enviados_jeans_mujer);

    // Recorrer los resultados y disminuir el total de jeans de la talla correspondiente
    if ($result_usuarios_enviados_jeans_mujer && mysqli_num_rows($result_usuarios_enviados_jeans_mujer) > 0) {
        while ($row = mysqli_fetch_assoc($result_usuarios_enviados_jeans_mujer)) {
            $talla_usuario = strtoupper($row['talla_pantalon']);

            // Si la talla existe en el array, decrementa la cantidad de jeans
            if (array_key_exists($talla_usuario, $totales_por_talla_jeans_mujer)) {
                $totales_por_talla_jeans_mujer[$talla_usuario] = max(0, $totales_por_talla_jeans_mujer[$talla_usuario] - 1); // Evita que el total sea negativo
            }
        }
    }
    mysqli_stmt_close($stmt_usuarios_enviados_jeans_mujer);
} else {
    $totales_por_talla_jeans_mujer = [
        '6' => 0, '8' => 0, '10' => 0, '12' => 0, '14' => 0,
        '16' => 0, '18' => 0, '20' => 0, '22' => 0
    ];
}

// Consulta para obtener el total de gafas por color según el anio_id
$sql_totales_por_color_gafas = "SELECT color_gafas, 
                            SUM(cantidad_gafas) AS total_gafas
                        FROM gafas
                        WHERE anio_id = ?
                        GROUP BY color_gafas";

if ($stmt_totales_por_color = mysqli_prepare($conn, $sql_totales_por_color_gafas)) {
    mysqli_stmt_bind_param($stmt_totales_por_color, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_color);
    $result_totales_por_color = mysqli_stmt_get_result($stmt_totales_por_color);
    $totales_por_color = [
        'blanco' => 0,
        'negro' => 0
    ];

    if ($result_totales_por_color && mysqli_num_rows($result_totales_por_color) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_color)) {
            $color = strtolower($row['color_gafas']);
            if (array_key_exists($color, $totales_por_color)) {
                $totales_por_color[$color] = $row['total_gafas'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_color);
} else {
    $totales_por_color = [
        'blanco' => 0,
        'negro' => 0
    ];
}
// Consulta para obtener el total de gafas especiales por color según el anio_id
$sql_totales_por_color_gafas_especiales = "SELECT color_gafas_especiales, 
                            SUM(cantidad_gafas_especiales) AS total_gafas_especiales
                        FROM gafas_especiales
                        WHERE anio_id = ?
                        GROUP BY color_gafas_especiales";

if ($stmt_totales_por_color_especiales = mysqli_prepare($conn, $sql_totales_por_color_gafas_especiales)) {
    mysqli_stmt_bind_param($stmt_totales_por_color_especiales, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_color_especiales);
    $result_totales_por_color_especiales = mysqli_stmt_get_result($stmt_totales_por_color_especiales);
    $totales_por_color_especiales = [
        'blanco' => 0,
        'negro' => 0
    ];

    if ($result_totales_por_color_especiales && mysqli_num_rows($result_totales_por_color_especiales) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_color_especiales)) {
            $color = strtolower($row['color_gafas_especiales']);
            if (array_key_exists($color, $totales_por_color_especiales)) {
                $totales_por_color_especiales[$color] = $row['total_gafas_especiales'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_color_especiales);
} else {
    $totales_por_color_especiales = [
        'blanco' => 0,
        'negro' => 0
    ];
}
// Consulta para obtener el total de cascos por año
$sql_totales_por_cascos = "SELECT anio_id, SUM(cantidad_cascos) AS total_cascos
                           FROM cascos
                           WHERE anio_id = ?
                           GROUP BY anio_id";

if ($stmt_totales_por_cascos = mysqli_prepare($conn, $sql_totales_por_cascos)) {
    mysqli_stmt_bind_param($stmt_totales_por_cascos, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_cascos);
    $result_totales_por_cascos = mysqli_stmt_get_result($stmt_totales_por_cascos);
    $total_cascos = 0; // Inicializar total en 0

    // Obtener el resultado
    if ($result_totales_por_cascos && mysqli_num_rows($result_totales_por_cascos) > 0) {
        $row = mysqli_fetch_assoc($result_totales_por_cascos);
        $total_cascos = $row['total_cascos'];
    }
    mysqli_stmt_close($stmt_totales_por_cascos);
} else {
    $total_cascos = 0; // Si falla la consulta, el total será 0
}
// Consulta para obtener el total de guantes por año
$sql_totales_por_guantes = "SELECT anio_id, SUM(cantidad_guantes) AS total_guantes
                           FROM guantes
                           WHERE anio_id = ?
                           GROUP BY anio_id";

if ($stmt_totales_por_guantes = mysqli_prepare($conn, $sql_totales_por_guantes)) {
    mysqli_stmt_bind_param($stmt_totales_por_guantes, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_guantes);
    $result_totales_por_guantes = mysqli_stmt_get_result($stmt_totales_por_guantes);
    $total_guantes = 0; // Inicializar total en 0

    // Obtener el resultado
    if ($result_totales_por_guantes && mysqli_num_rows($result_totales_por_guantes) > 0) {
        $row = mysqli_fetch_assoc($result_totales_por_guantes);
        $total_guantes = $row['total_guantes'];
    }
    mysqli_stmt_close($stmt_totales_por_guantes);
} else {
    $total_guantes = 0; // Si falla la consulta, el total será 0
}
// Consulta para obtener el total de tapabocas por año
$sql_totales_por_tapabocas = "SELECT anio_id, SUM(cantidad_tapabocas) AS total_tapabocas
                           FROM tapabocas
                           WHERE anio_id = ?
                           GROUP BY anio_id";

if ($stmt_totales_por_tapabocas = mysqli_prepare($conn, $sql_totales_por_tapabocas)) {
    mysqli_stmt_bind_param($stmt_totales_por_tapabocas, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_tapabocas);
    $result_totales_por_tapabocas = mysqli_stmt_get_result($stmt_totales_por_tapabocas);
    $total_tapabocas = 0; // Inicializar total en 0

    // Obtener el resultado
    if ($result_totales_por_tapabocas && mysqli_num_rows($result_totales_por_tapabocas) > 0) {
        $row = mysqli_fetch_assoc($result_totales_por_tapabocas);
        $total_tapabocas = $row['total_tapabocas'];
    }
    mysqli_stmt_close($stmt_totales_por_tapabocas);
} else {
    $total_tapabocas = 0; // Si falla la consulta, el total será 0
}
// Consulta para obtener el total de mascarillas por año
$sql_totales_por_mascarillas = "SELECT anio_id, SUM(cantidad_mascarillas) AS total_mascarillas
                                FROM mascarillas
                                WHERE anio_id = ?
                                GROUP BY anio_id";

if ($stmt_totales_por_mascarillas = mysqli_prepare($conn, $sql_totales_por_mascarillas)) {
    mysqli_stmt_bind_param($stmt_totales_por_mascarillas, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_mascarillas);
    $result_totales_por_mascarillas = mysqli_stmt_get_result($stmt_totales_por_mascarillas);
    $total_mascarillas = 0; // Inicializar total en 0

    // Obtener el resultado
    if ($result_totales_por_mascarillas && mysqli_num_rows($result_totales_por_mascarillas) > 0) {
        $row = mysqli_fetch_assoc($result_totales_por_mascarillas);
        $total_mascarillas = $row['total_mascarillas'];
    }
    mysqli_stmt_close($stmt_totales_por_mascarillas);
} else {
    $total_mascarillas = 0; // Si falla la consulta, el total será 0
}
// Consulta para obtener el total de tapa_oidos por nombre según el anio_id
$sql_totales_por_nombre_tapa_oidos = "SELECT nombre_tapa_oidos, 
                            SUM(cantidad_tapa_oidos) AS total_tapa_oidos
                        FROM tapa_oidos
                        WHERE anio_id = ?
                        GROUP BY nombre_tapa_oidos";

if ($stmt_totales_por_nombre_tapa = mysqli_prepare($conn, $sql_totales_por_nombre_tapa_oidos)) {
    mysqli_stmt_bind_param($stmt_totales_por_nombre_tapa, "i", $anio_id);
    mysqli_stmt_execute($stmt_totales_por_nombre_tapa);
    $result_totales_por_nombre_tapa = mysqli_stmt_get_result($stmt_totales_por_nombre_tapa);
    $totales_por_nombre_tapa = [
        'copa' => 0,
        'insercion' => 0
    ];

    if ($result_totales_por_nombre_tapa && mysqli_num_rows($result_totales_por_nombre_tapa) > 0) {
        while ($row = mysqli_fetch_assoc($result_totales_por_nombre_tapa)) {
            $color = strtolower($row['nombre_tapa_oidos']);
            if (array_key_exists($color, $totales_por_nombre_tapa)) {
                $totales_por_nombre_tapa[$color] = $row['total_tapa_oidos'];
            }
        }
    }
    mysqli_stmt_close($stmt_totales_por_nombre_tapa);
} else {
    $totales_por_nombre_tapa = [
        'copa' => 0,
        'insercion' => 0
    ];
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
    <title>Almacen</title>
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
            <a href="/admin/public/rtaPrimerForm.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">RTA DATOS BASICOS</a>
            <a href="rtaSegundoForm.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">RTA DATOS EPP</a>
            <a href="/admin/public/dotacion.php?anio_id=<?php echo $anio_id; ?>" class="text-green-900 hover:text-lime-600 font-bold text-sm md:text-lg">
                ATRAS
            </a>
        </nav>
        <div class="hidden lg:block">
            <a href="../../../logout.php" class="bg-green-600 hover:bg-lime-500 text-white font-bold py-3 px-4 md:px-6 rounded-lg shadow-md text-sm md:text-base">Cerrar sesión</a>
        </div>
    </div>
    <div id="mobileMenu" class="lg:hidden bg-white w-full px-5 py-3 space-y-4 text-center hidden">
        <a href="/admin/años.php" class="block text-green-900 hover:text-lime-600 font-bold text-lg">AÑOS</a>
        <a href="/admin/index.php" class="block text-green-900 hover:text-lime-600 font-bold text-lg">PROYECTOS</a>
        <a href="/admin/public/rtaPrimerForm.php?anio_id=<?php echo $anio_id; ?>" class="block text-green-900 hover:text-lime-600 font-bold text-lg">RTA DATOS BASICOS</a>
        <a href="../../../logout.php" class="block text-green-600 hover:text-lime-500 font-bold py-3 px-4 rounded-lg text-lg">Cerrar sesión</a>
    </div>
</header>
<!-- Contenedor principal de la vista -->
<div class="justify-center p-2">
    <h2 class="text-2xl font-semibold text-gray-800 ml-[110px] -translate-y-[30px]">Bienvenido al Almacén</h2>
    <div class="bg-white max-w-[450px] h-[640px] p-7 border-2 border-black rounded-lg shadow-lg transform translate-x-[35px] translate-y-[-25px]">
        <div class="flex space-x-10">
            <div class="w-[200px] p-2">

                <!-- Botón para mostrar opciones -->
                <button id="agregarBtn" class="w-[150px] bg-green-500 text-black py-1  rounded-lg hover:bg-green-700 transition duration-200 flex items-center justify-center border-2 border-black mt-[-20px] ml-[-20px]">
                    <strong>AGREGAR</strong>
                    <img src="/admin/includes/imgs/labajo.svg" alt="" class="w-4 h-4 ml-2">
                </button>
                <!-- Opciones que se mostrarán cuando se presione el botón -->
                <div id="opciones" class="hidden mt-2 space-y-1">
                    <button onclick="mostrarFormulario('camisas')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Camisas H</button>
                    <button onclick="mostrarFormulario('jeans')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Jeans H</button>
                    <button onclick="mostrarFormulario('camisasmujer')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Camisas M</button>
                    <button onclick="mostrarFormulario('jeansmujer')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Jeans M</button>
                    <button onclick="mostrarFormulario('botas')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Botas</button>
                    <button onclick="mostrarFormulario('nomex')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Nomex </button>
                    <button onclick="mostrarFormulario('gafas')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">gafas </button>
                    <button onclick="mostrarFormulario('gafasespeciales')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">gafas especiales</button>
                    <button onclick="mostrarFormulario('cascos')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Cascos </button>
                    <button onclick="mostrarFormulario('guantes')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Guantes </button>
                    <button onclick="mostrarFormulario('tapabocas')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Tapabocas </button>
                    <button onclick="mostrarFormulario('mascarillas')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Mascarillas </button>
                    <button onclick="mostrarFormulario('tapa_oidos')" class="w-[150px] bg-blue-500 text-white py-1 rounded-lg hover:bg-blue-700 ml-[-20px]">Tapa oidos </button>
                </div>
            </div>

            <!-- Contenedor de los formularios que se muestran según la opción seleccionada -->
            <div class="mt-2">
                <!-- Formularios-->
                <div id="camisasForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Camisas de Hombre</h1>
                        <div>
                            <label for="cantidad_camisas" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_camisas" name="cantidad_camisas" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="talla_camisas" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Talla</label>
                            <select id="talla_camisas" name="talla_camisas" class="w-[160px] text-sm py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                                <option value="" disabled selected>--Selecciona--</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_camisas">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="jeansForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Jeans de Hombre</h1>
                        <div>
                            <label for="cantidad_jeans" class="block text-sm font-medium text-gray-700  ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_jeans" name="cantidad_jeans" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500  ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="talla_jeans" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Talla</label>
                            <select id="talla_jeans" name="talla_jeans" class="w-[160px] text-sm py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500  ml-[-40px]" required>
                                <option value="" disabled selected>--Selecciona--</option>
                                <option value="28">28</option>
                                <option value="30">30</option>
                                <option value="32">32</option>
                                <option value="34">34</option>
                                <option value="36">36</option>
                                <option value="38">38</option>
                                <option value="40">40</option>
                                <option value="42">42</option>
                                <option value="44">44</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_jeans">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="camisasMujerForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Camisas de Mujer</h1>
                        <div>
                            <label for="cantidad_camisas" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_camisas" name="cantidad_camisas" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="talla_camisas" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Talla</label>
                            <select id="talla_camisas" name="talla_camisas" class="w-[160px] text-sm py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                                <option value="" disabled selected>--Selecciona--</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_camisas_mujer">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 mt-[-10px] ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="jeansMujerForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Jeans de Mujer</h1>
                        <div>
                            <label for="cantidad_jeans" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_jeans" name="cantidad_jeans" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="talla_jeans" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Talla</label>
                            <select id="talla_jeans" name="talla_jeans" class="w-[160px] text-sm py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                                <option value="" disabled selected>--Selecciona--</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                                <option value="10">10</option>
                                <option value="12">12</option>
                                <option value="14">14</option>
                                <option value="16">16</option>
                                <option value="18">18</option>
                                <option value="20">20</option>
                                <option value="22">22</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_jeans_mujer">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>         
                <div id="botasForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Botas</h1>
                        <div>
                            <label for="cantidad_botas" class="block text-sm font-medium text-gray-700  ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_botas" name="cantidad_botas" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="talla_botas" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Talla</label>
                            <select id="talla_botas" name="talla_botas" class="w-[160px] text-sm py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                                <option value="" disabled selected>--Selecciona--</option>
                                <option value="35">35</option>
                                <option value="36">36</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_botas">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="nomexForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Nomex</h1>
                        <div>
                            <label for="cantidad_nomex" class="block text-sm font-medium text-gray-700  ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_nomex" name="cantidad_nomex" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="talla_nomex" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Talla</label>
                            <select id="talla_nomex" name="talla_nomex" class="w-[160px] text-sm py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                                <option value="" disabled selected>--Selecciona--</option>
                                <option value="34">34</option>
                                <option value="36">36</option>
                                <option value="38">38</option>
                                <option value="40">40</option>
                                <option value="42">42</option>
                                <option value="44">44</option>
                                <option value="46">46</option>
                                <option value="48">48</option>
                                <option value="50">50</option>
                                <option value="52">52</option>
                                <option value="54">54</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_nomex">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="gafasForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Gafas</h1>
                        <div>
                            <label for="cantidad_gafas" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_gafas" name="cantidad_gafas" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>                               
                            <label for="color_gafas" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Color</label>
                            <select id="color_gafas" name="color_gafas" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]">
                                <option value="blanco">Blanco</option>
                                <option value="negro">Negro</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_gafas">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="gafasEspecialesForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Gafas Especiales</h1>  
                        <div>
                            <label for="cantidad_gafas_especiales" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_gafas_especiales" name="cantidad_gafas_especiales" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>                               
                            <label for="color_gafas_especiales" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Color</label>
                            <select id="color_gafas_especiales" name="color_gafas_especiales" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]">
                                <option value="blanco">Blanco</option>
                                <option value="negro">Negro</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_gafas_especiales">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="cascosForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Cascos</h1>
                        <div>
                            <label for="cantidad_cascos" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_cascos" name="cantidad_cascos" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_cascos">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="guantesForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Guantes</h1>
                        <div>
                            <label for="cantidad_guantes" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_guantes" name="cantidad_guantes" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_guantes">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="tapabocasForm" class="hidden">
                    <form method="POST" class="space-y-4">
                    <h1 class="block font-medium  text-gray-700 text-center -ml-10">Tapabocas</h1>
                        <div>
                            <label for="cantidad_tapabocas" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_tapabocas" name="cantidad_tapabocas" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_tapabocas">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="mascarillasForm" class="hidden">
                    <form method="POST" class="space-y-4">
                        <h1 class="block font-medium  text-gray-700 text-center -ml-10">Mascarillas</h1>
                        <div>
                            <label for="cantidad_mascarillas" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_mascarillas" name="cantidad_mascarillas" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_mascarillas">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
                <div id="tapaOidosForm" class="hidden">
                    <form method="POST" class="space-y-4">
                    <h1 class="block font-medium  text-gray-700 text-center -ml-10">Tapa oidos</h1>
                        <div>
                            <label for="cantidad_tapa_oidos" class="block text-sm font-medium text-gray-700 ml-[-40px]">Cantidad</label>
                            <input type="number" id="cantidad_tapa_oidos" name="cantidad_tapa_oidos" placeholder="Cantidad" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <div>                               
                            <label for="nombre_tapa_oidos" class="block text-sm font-medium text-gray-700 mt-2 ml-[-40px]">Tapa oidos</label>
                            <select id="nombre_tapa_oidos" name="nombre_tapa_oidos" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]">
                                <option value="copa">Copa</option>
                                <option value="insercion">Insercion</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_subida" class="block text-sm font-medium text-gray-700 mt-[-10px] ml-[-40px]">Fecha de Subida</label>
                            <input type="date" id="fecha_subida" name="fecha_subida" class="w-[160px] p-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 ml-[-40px]" required>
                        </div>
                        <input type="hidden" name="accion" value="insertar_tapa_oidos">
                        <button type="submit" class="w-[160px] bg-green-500 text-white py-2 text-sm rounded-lg hover:bg-green-700 transition duration-200 ml-[-40px]">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
    <!-- Camisas hombre-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-948px] translate-y-[-665px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Camisas de hombre</h3>
        <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-[#2FA74D] text-white">
                    <tr class="sticky top-0 bg-[#2FA74D]">
                        <th class="text-center border-b border-r">Cantidad</th>
                        <th class="text-center border-b border-r">Talla</th>
                        <th class="text-center border-b border-r">Fecha Subida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($conn) {
                        $sql = "SELECT cantidad_camisas, talla_camisas, fecha_subida FROM camisas_hombre WHERE anio_id = ?";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, "i", $anio_id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $counter = 0;  // Para contar las filas
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='border-b text-center'>{$row['cantidad_camisas']}</td>";
                                    echo "<td class='border-b text-center'>{$row['talla_camisas']}</td>";
                                    echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                    echo "</tr>";
                                    $counter++;
                                }
                            } else {
                                echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                            }
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Tallas disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    $tallas = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                    foreach ($tallas as $talla) {
                        echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla[$talla] . '" class="px-2 py-1 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Pantalones hombre-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-956px] translate-y-[-670px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Jeans de hombre</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#E1EEE2] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Talla</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($conn) {
                                $sql = "SELECT cantidad_jeans, talla_jeans, fecha_subida FROM jeans_hombre WHERE anio_id = ?";
                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td class='border-b text-center'>{$row['cantidad_jeans']}</td>";
                                            echo "<td class='border-b text-center'>{$row['talla_jeans']}</td>";
                                            echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                    }
                                    mysqli_stmt_close($stmt);
                                }
                            } else {
                                echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-2 text-center ">Tallas disponibles</h1>
                <div class="flex justify-center mt-4 flex-wrap">
            <?php
                $tallas_jeans_h = ['28', '30', '32', '34', '36', '38', '40', '42', '44'];
                $mitad = ceil(count($tallas_jeans_h) / 2); 
                // Primera fila (mitad de los elementos)
                for ($i = 0; $i < $mitad; $i++) {
                    $talla = $tallas_jeans_h[$i];
                    echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_jeans_h[$talla] . '" class="py-1 bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[28px] mb-[15px] mt-[-20px]">';
                }
                echo '</div><div class="flex justify-center mt-2 flex-wrap">'; // Inicia la segunda fila
                // Segunda fila (el resto de los elementos)
                for ($i = $mitad; $i < count($tallas_jeans_h); $i++) {
                    $talla = $tallas_jeans_h[$i];
                    echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_jeans_h[$talla] . '" class="py-1  bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[25px] mb-[15px] mt-[-25px]">';
                }
            ?>
        </div>
    </div>
    <!-- Camisas Mujer-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-503px] translate-y-[-1313px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Camisas de Mujer</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#E1EEE2] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Talla</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_camisas, talla_camisas, fecha_subida FROM camisas_mujer WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_camisas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['talla_camisas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Tallas disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    $tallas = ['S', 'M', 'L', 'XL', 'XXL'];
                    foreach ($tallas as $talla) {
                        echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_camisas_mujer[$talla] . '" class="px-2 py-1 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Pantalones Mujer-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-503px] translate-y-[-1310px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Jeans de Mujer</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#E1EEE2] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Talla</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_jeans, talla_jeans, fecha_subida FROM jeans_mujer WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_jeans']}</td>";
                                        echo "<td class='border-b text-center'>{$row['talla_jeans']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-2 text-center ">Tallas disponibles</h1>
            <div class="flex justify-center mt-4 flex-wrap">
            <?php
                $tallas_jeans_mujer = ['6', '8', '10', '12', '14', '16', '18', '20', '22'];
                $mitad = ceil(count($tallas_jeans_mujer) / 2); // Dividir en dos mitades

                // Primera fila (mitad de los elementos)
                for ($i = 0; $i < $mitad; $i++) {
                    $talla = $tallas_jeans_mujer[$i];
                    echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_jeans_mujer[$talla] . '" class="py-1 bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[28px] mb-[15px] mt-[-20px]">';
                }

                echo '</div><div class="flex justify-center mt-2 flex-wrap">'; // Inicia la segunda fila

                // Segunda fila (el resto de los elementos)
                for ($i = $mitad; $i < count($tallas_jeans_mujer); $i++) {
                    $talla = $tallas_jeans_mujer[$i];
                    echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_jeans_mujer[$talla] . '" class="py-1  bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[25px] mb-[15px] mt-[-25px]">';
                }
            ?>
        </div>
    </div>
    <!-- Botas-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-50px] translate-y-[-1953px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Botas</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#E1EEE2] text-white">
                        <tr class="sticky top-0 bg-[#2fa74d]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Talla</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_botas, talla_botas, fecha_subida FROM botas WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_botas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['talla_botas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-2 text-center ">Tallas disponibles</h1>
            <div class="flex justify-center mt-4 flex-wrap">
            <?php
                $tallas_botas = ['35', '36','37', '38','39', '40','41', '42','43', '44','45','46'];
                $mitad = ceil(count($tallas_botas) / 4);
                // Primera fila (mitad de los elementos)
                for ($i = 0; $i < $mitad; $i++) {
                    $talla = $tallas_botas[$i];
                    if (isset($totales_por_talla_botas[$talla])) {
                        echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_botas[$talla] . '" class="py-1 bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[28px] mb-[15px] mt-[-20px]">';
                    } else {
                        echo '<input type="button" value="' . $talla . ': 0" class="py-1 bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[28px] mb-[15px] mt-[-20px]">';
                    }
                }
                echo '</div><div class="flex justify-center mt-2 flex-wrap">'; // Inicia la segunda fila
                // Segunda fila (el resto de los elementos)
                for ($i = $mitad; $i < count($tallas_botas); $i++) {
                    $talla = $tallas_botas[$i];
                    echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_botas[$talla] . '" class="py-1  bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[25px] mb-[15px] mt-[-25px]">';
                }
            ?>
        </div>
    </div>
    <!-- Nomex-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-50px] translate-y-[-1950px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Nomex de hombre</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#E1EEE2] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Talla</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($conn) {
                                $sql = "SELECT cantidad_nomex, talla_nomex, fecha_subida FROM nomex WHERE anio_id = ?";
                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td class='border-b text-center'>{$row['cantidad_nomex']}</td>";
                                            echo "<td class='border-b text-center'>{$row['talla_nomex']}</td>";
                                            echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                    }
                                    mysqli_stmt_close($stmt);
                                }
                            } else {
                                echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-2 text-center ">Tallas disponibles</h1>
                <!-- Sección de botones -->
                <div class="flex justify-center mt-4 flex-wrap">
            <?php
            $tallas_nomex = ['28', '30', '32', '34', '36', '38', '40', '42', '44','46','48','50','52','54'];
            $mitad = ceil(count($tallas_nomex) / 2); // Dividir en dos mitades

            // Primera fila (mitad de los elementos)
            for ($i = 0; $i < $mitad; $i++) {
                $talla = $tallas_nomex[$i];
                if (isset($totales_por_talla_nomex[$talla])) {
                    echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_nomex[$talla] . '" class="py-1 bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[20px] mb-[15px] mt-[-18px]">';
                } else {
                    echo '<input type="button" value="' . $talla . ': 0" class="py-1 bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[28px] mb-[15px] mt-[-20px]">';
                }
                                }

            echo '</div><div class="flex justify-center mt-2 flex-wrap">'; // Inicia la segunda fila

            // Segunda fila (el resto de los elementos)
            for ($i = $mitad; $i < count($tallas_nomex); $i++) {
                $talla = $tallas_nomex[$i];
                echo '<input type="button" value="' . $talla . ': ' . $totales_por_talla_nomex[$talla] . '" class="py-1  bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[25px] mb-[15px] mt-[-25px]">';
            }
            ?>
        </div>
    </div>
    <!-- Gafas-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-955px] translate-y-[-1947px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Gafas</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Nombre</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_gafas, color_gafas, fecha_subida FROM gafas WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_gafas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['color_gafas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Gafas disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    $gafas = ['blanco', 'negro'];
                    foreach ($gafas as $gafa) {
                        // Verifica si el color está presente en los resultados calculados
                        $cantidad = isset($totales_por_color[$gafa]) ? $totales_por_color[$gafa] : 0;
                        echo '<input type="button" value="' . ucfirst($gafa) . ': ' . $cantidad . '" class="px-2 py-1 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Gafas especiales-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-503px] translate-y-[-2267px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Gafas Especiales</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Nombre</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_gafas_especiales, color_gafas_especiales, fecha_subida FROM gafas_especiales WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_gafas_especiales']}</td>";
                                        echo "<td class='border-b text-center'>{$row['color_gafas_especiales']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Gafas disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    $gafas = ['blanco', 'negro'];
                    foreach ($gafas as $gafa) {
                        // Verifica si el color está presente en los resultados calculados
                        $cantidad = isset($totales_por_color_especiales[$gafa]) ? $totales_por_color_especiales[$gafa] : 0;
                        echo '<input type="button" value="' . ucfirst($gafa) . ': ' . $cantidad . '" class="px-2 py-1 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Cascos-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-50px] translate-y-[-2588px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Cascos</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_cascos, fecha_subida FROM cascos WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_cascos']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class="text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Guantes Disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    echo '<input type="button" value="Total Guantes: ' . $total_cascos . '" class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                ?>
            </div>
        </div>
    </div>
    <!-- Guantes-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-1410px] translate-y-[-2908px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Guantes</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad Guantes</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_guantes, fecha_subida FROM guantes WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_guantes']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class="text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Guantes Disponibles</h1>
            <div class="flex justify-center mt-4">
            <?php
                echo '<input type="button" value="Total Guantes: ' . $total_guantes . '" class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
            ?>
        </div>
    </div>
    <!-- Tapabocas-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-1410px] translate-y-[-2905px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tapabocas</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad Tapabocas</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_tapabocas, fecha_subida FROM tapabocas WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_tapabocas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class="text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Tapabocas Disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    echo '<input type="button" value="Total Tapabocas: ' . $total_tapabocas . '" class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                ?>
            </div>
        </div>
    </div>
    <!-- Mascarillas -->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-955px] translate-y-[-3224px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Mascarillas</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad Mascarillas</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_mascarillas, fecha_subida FROM mascarillas WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_mascarillas']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class="text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Mascarillas Disponibles</h1>
            <div class="flex justify-center mt-4">
            <?php
                echo '<input type="button" value="Total Mascarillas: ' . $total_mascarillas . '" class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
            ?>
        </div>
    </div>
    <!-- Tapa oidos-->
    <div class="bg-white max-w-[450px] h-[320px] p-4 rounded-lg shadow-lg ml-auto transform translate-x-[-503px] translate-y-[-3544px]">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tapa oidos</h3>
            <div class="overflow-x-auto" style="max-height: 160px; overflow-x: auto;">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-[#2FA74D] text-white">
                        <tr class="sticky top-0 bg-[#2FA74D]">
                            <th class="text-center border-b border-r">Cantidad</th>
                            <th class="text-center border-b border-r">Nombre</th>
                            <th class="text-center border-b border-r">Fecha Subida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($conn) {
                            $sql = "SELECT cantidad_tapa_oidos, nombre_tapa_oidos, fecha_subida FROM tapa_oidos WHERE anio_id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "i", $anio_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 0;  // Para contar las filas
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='border-b text-center'>{$row['cantidad_tapa_oidos']}</td>";
                                        echo "<td class='border-b text-center'>{$row['nombre_tapa_oidos']}</td>";
                                        echo "<td class='border-b text-center'>{$row['fecha_subida']}</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='px-4 py-2 text-center'>No hay datos disponibles</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            }
                        } else {
                            echo "<tr><td colspan='3' class='px-4 py-2 text-center'>Error al conectar a la base de datos</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h1 class=" text-xl font-semibold text-gray-800 ml-[10px] mt-4 text-center">Tapa oidos disponibles</h1>
            <div class="flex justify-center mt-4">
                <?php
                    $tapa_oidos = ['copa', 'insercion'];
                    foreach ($tapa_oidos as $tapa_oido) {
                        $cantidad = isset($totales_por_nombre_tapa[$tapa_oido]) ? $totales_por_nombre_tapa[$tapa_oido] : 0;
                        echo '<input type="button" value="' . ucfirst($tapa_oido) . ': ' . $cantidad . '" class="px-2 py-1 border rounded-lg bg-white hover:bg-gray-100 focus:outline-none transition duration-200 ml-[10px]">';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    // Mostrar el mensaje de éxito si está en la sesión
    if (isset($_SESSION['mensaje'])) {
        echo "<script>alert('" . $_SESSION['mensaje'] . "');</script>";
        unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
    }
?>
<script>
    // Mostrar u ocultar el menú de opciones
    document.getElementById('agregarBtn').addEventListener('click', function() {
        const opciones = document.getElementById('opciones');
        opciones.classList.toggle('hidden');
    });

    function mostrarFormulario(form) {
        const camisasForm = document.getElementById('camisasForm');
        const jeansForm = document.getElementById('jeansForm');
        const camisasMujerForm = document.getElementById('camisasMujerForm');
        const jeansMujerForm = document.getElementById('jeansMujerForm');
        const botasForm = document.getElementById('botasForm');
        const nomexForm = document.getElementById('nomexForm');
        const gafasForm = document.getElementById('gafasForm');
        const gafasEspecialesForm = document.getElementById('gafasEspecialesForm');
        const cascosForm = document.getElementById('cascosForm');
        const guantesForm = document.getElementById('guantesForm');
        const tapabocasForm = document.getElementById('tapabocasForm');
        const mascarillasForm = document.getElementById('mascarillasForm');
        const tapaOidosForm = document.getElementById('tapaOidosForm');

        camisasForm.classList.add('hidden');
        jeansForm.classList.add('hidden');
        camisasMujerForm.classList.add('hidden');
        jeansMujerForm.classList.add('hidden');
        botasForm.classList.add('hidden');
        nomexForm.classList.add('hidden');
        gafasForm.classList.add('hidden');
        gafasEspecialesForm.classList.add('hidden');
        cascosForm.classList.add('hidden');
        guantesForm.classList.add('hidden');
        tapabocasForm.classList.add('hidden');
        mascarillasForm.classList.add('hidden');
        tapaOidosForm.classList.add('hidden');

        if (form === 'camisas') camisasForm.classList.remove('hidden');
        if (form === 'jeans') jeansForm.classList.remove('hidden');
        if (form === 'camisasmujer') camisasMujerForm.classList.remove('hidden');
        if (form === 'jeansmujer') jeansMujerForm.classList.remove('hidden');
        if (form === 'botas') botasForm.classList.remove('hidden');
        if (form === 'nomex') nomexForm.classList.remove('hidden');
        if (form === 'gafas') gafasForm.classList.remove('hidden');
        if (form === 'gafasespeciales') gafasEspecialesForm.classList.remove('hidden');
        if (form === 'cascos') cascosForm.classList.remove('hidden');
        if (form === 'guantes') guantesForm.classList.remove('hidden');
        if (form === 'tapabocas') tapabocasForm.classList.remove('hidden');
        if (form === 'mascarillas') mascarillasForm.classList.remove('hidden');
        if (form === 'tapa_oidos') tapaOidosForm.classList.remove('hidden');
    }
</script>
</body>
</html>