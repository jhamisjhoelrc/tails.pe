<?php
require_once '../models/connection.php';
$stmt = Connection::connect()->prepare("SELECT names FROM customers WHERE status != 3 AND names LIKE :keyword");
$stmt->bindValue("keyword", "%" . $_GET["term"] . "%");
$stmt->execute();
$result = array();
while ($product = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($result, $product->names);
}
echo json_encode($result);
