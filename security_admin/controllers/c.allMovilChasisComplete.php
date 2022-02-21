<?php
require_once '../models/connection.php';
$stmt = Connection::connect()->prepare("SELECT chasis FROM moviles WHERE condition_movil = 'ensamblada' AND status != 3 AND chasis LIKE :keyword");
$stmt->bindValue("keyword", "%" . $_GET["term"] . "%");
$stmt->execute();
$result = array();
while ($product = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($result, $product->chasis);
}
echo json_encode($result);
