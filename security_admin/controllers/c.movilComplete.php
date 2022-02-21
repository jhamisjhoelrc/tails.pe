<?php
require_once '../models/connection.php';
$stmt = Connection::connect()->prepare("SELECT motor FROM moviles WHERE condition_movil = 'ensamblada' AND status = 1 AND motor LIKE :keyword");
$stmt->bindValue("keyword", "%" . $_GET["term"] . "%");
$stmt->execute();
$result = array();
while ($product = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($result, $product->motor);
}
echo json_encode($result);
