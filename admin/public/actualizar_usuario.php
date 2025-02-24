<?php
require_once '../../config/db.php'; 

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['cedula'])) {
    $cedula = $data['cedula'];
    $genero = $data['genero'];
    $talla_camisa = $data['talla_camisa'];
    $talla_pantalon = $data['talla_pantalon'];
    $talla_botas = $data['talla_botas'];
    $talla_nomex = $data['talla_nomex'];
    $query = "UPDATE usuarios_r SET 
                genero = ?, 
                talla_camisa = ?, 
                talla_pantalon = ?, 
                talla_botas = ?, 
                talla_nomex = ? 
              WHERE cedula = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ssssss', $genero, $talla_camisa, $talla_pantalon, $talla_botas, $talla_nomex, $cedula);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
}
?>
