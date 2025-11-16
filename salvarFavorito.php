<?php
ob_start();

include 'conexao.php'; 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type"); 

ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); 
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido. Use POST."));
    exit();
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title) && !empty($data->imageUrl)) {
    
    $title = $conn->real_escape_string($data->title);
    $imageUrl = $conn->real_escape_string($data->imageUrl);

    $check_sql = "SELECT id FROM favoritos WHERE titulo = '$title'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {

        http_response_code(200); 
        echo json_encode(array("message" => "Filme já favoritado."));
    } else {
        
        $sql = "INSERT INTO favoritos (titulo, imagem_Url) VALUES ('$title', '$imageUrl')";
        
        if ($conn->query($sql) === TRUE) {
            http_response_code(201); 
            echo json_encode(array("message" => "Filme favoritado com sucesso!"));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao salvar: " . $conn->error));
        }
    }

} else {
    http_response_code(400);
    echo json_encode(array("message" => "Dados incompletos. Título e Imagem URL são obrigatórios."));
}

$conn->close();