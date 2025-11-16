<?php

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "streaming"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(500);
    echo json_encode(array("message" => "Erro de conexão com o banco de dados"));
    exit();
}