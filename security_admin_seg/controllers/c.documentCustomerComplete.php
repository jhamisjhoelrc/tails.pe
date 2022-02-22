<?php
require_once '../models/connection.php';
$stmt = Connection::connect()->prepare("SELECT document_number FROM customers WHERE status != 3 AND document_number LIKE :keyword");
$stmt->bindValue("keyword", "%" . $_GET["term"] . "%");
$stmt->execute();
$result = array();
while ($product = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($result, $product->document_number);
}
echo json_encode($result);