<?php
include 'conex.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió ID']);
    exit;
}

$id_libro = intval($_GET['id']);
if (!$id_libro) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$stmt = $conexion->prepare("UPDATE books SET favorites = favorites + 1 WHERE ID = ?");
$stmt->bind_param("i", $id_libro);
$stmt->execute();
$stmt->close();

$stmt2 = $conexion->prepare("SELECT favorites FROM books WHERE ID = ?");
$stmt2->bind_param("i", $id_libro);
$stmt2->execute();
$result = $stmt2->get_result();
$data = $result->fetch_assoc();
$stmt2->close();

echo json_encode(['nuevoFavoritos' => $data['favorites']]);
?>
