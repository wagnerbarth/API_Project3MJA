<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// adiciona banco de dados e cria objeto usuário
include_once '../config/database.php';
include_once '../objects/usuario.php';
 
// conecta ao banco de dados
$database = new Database();
$db = $database->getConnection();
 
// prepara o objeto usuário
$usuario = new Usuario($db);
 
// recebe dados via POST
$data = json_decode(file_get_contents("php://input"));
 
// define o valor da nova senha
$usuario->senha = $data->senha;

// define email para selecionar usuário
$usuario->email = $data->email;

// atualiza a senha
if($usuario->update()){
 
    // código de resposta - 200 ok
    http_response_code(200);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "Senha atualizada com sucesso."));
}
 
// se não for possível atualizar a senha
else{
 
    // código de resposta - 503 service unavailable
    http_response_code(503);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "Não foi possível atualizar a senha."));
}

