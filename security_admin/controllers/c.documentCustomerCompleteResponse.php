<?php
require_once '../models/connection.php';

$cliente = $_GET["product"];
$stmt = Connection::connect()->prepare("SELECT c.id,c.names,c.id_document,c.document_number,c.email,c.phone,c.address,c.customer_type,d.description 'document_type' FROM customers c INNER JOIN documents_type d ON c.id_document = d.id WHERE document_number = '$cliente' LIMIT 1");

$stmt->execute();

if ($stmt) {
    $contenido = $stmt->fetch(PDO::FETCH_OBJ);
    $contenido->status = 200;
    echo json_encode($contenido);
} else {
    $error = array("status" => 400);
    echo json_encode((object) $error);
}
