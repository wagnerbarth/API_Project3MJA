<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// obtém conexão
include_once '../config/database.php';
 
// instancia objeto usuário
include_once '../objects/usuario.php';
 
$database = new Database();
$db = $database->getConnection();
 
$usuario = new Usuario($db);

// recebe dados via POST - Body
$data = json_decode(file_get_contents("php://input"));

// certifica que os dados estão preenchidos
if(
    !empty($data->nome) &&
    !empty($data->email) &&
    !empty($data->senha) &&
    !empty($data->nivel)
){
 
    // define as propriedades
    $usuario->nome = $data->nome;
    $usuario->email = $data->email;
    $usuario->senha = $data->senha;
    $usuario->nivel = $data->nivel;
    
 
    // cria o usuário
    if($usuario->criarUsuario()){
 
        // define código de resposta - 201 created
        http_response_code(201);
 
        // mensagem para o usuário
        echo json_encode(array("message" => "Usuário criado com sucesso."));
    }else{ // caso não cadastre o usuário exibe mensagem
 
        // define código de resposta - 503 service unavailable
        http_response_code(503);
 
        // mensagem de usuário não cadastrado
        echo json_encode(array("message" => "Usuário não pode ser criado."));
    }
}else{ // mensagem de daos incompletos
 
    // define codigo de resposta - 400 bad request
    http_response_code(400);
 
    // mensagem para usuário
    //echo json_encode(array("message" => "Usuário não criado. Dados incompletos."));
    echo json_encode(array("message" => $data->nome));
    
}