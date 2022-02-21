<?php
require_once '../models/connection.php';

$cliente = $_GET["product"];
$stmt = Connection::connect()->prepare("SELECT m.id,m.chasis,m.motor,m.colour,m.fabricacion, mo.name_lucki 'model', b.descripction 'brand', c.descripction 'category'
FROM moviles m INNER JOIN models mo ON m.id_model = mo.id
               INNER JOIN brands b ON mo.id_brand = b.id
               INNER JOIN categories c ON mo.id_categories = c.id
WHERE m.chasis = '$cliente' LIMIT 1");

$stmt->execute();

if ($stmt) {
    $contenido = $stmt->fetch(PDO::FETCH_OBJ);
    $contenido->status = 200;
    echo json_encode($contenido);
} else {
    $error = array("status" => 400);
    echo json_encode((object) $error);
}
