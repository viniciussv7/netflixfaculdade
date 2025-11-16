<?php
ob_start();
include 'conexao.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
ob_end_clean();

$sql = "SELECT titulo, imagem_Url FROM favoritos ORDER BY id DESC"; 
$result = $conn->query($sql);

$favoritos = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($favoritos, $row);
    }
    http_response_code(200);
    echo json_encode($favoritos); 
} else {
    http_response_code(200);
    echo json_encode(array()); 
}

$conn->close();
