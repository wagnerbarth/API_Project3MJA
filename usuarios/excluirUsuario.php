<?php

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// inclui bando de dados e objeto usuário
include_once '../config/database.php';
include_once '../objects/usuario.php';
 
// conexão com banco de dados
$database = new Database();
$db = $database->getConnection();
 
// prepara o objeto usuario
$usuario = new Usuario($db);

//echo $request_method=$_SERVER["REQUEST_METHOD"];

// recebe dados via POST
$data = json_decode(file_get_contents("php://input"));

// define usuário a ser excluido
$usuario->email = $data->email;
 
// exclui o usuário
if($usuario->delete()){
 
    // código de resposta - 200 ok
    http_response_code(200);
 
    // mensagem para o usuário
    echo json_encode(array("message" => "Usuário removido."));
}
 
// se não for possível excluir usuário
else{
 
    // código de resposta - 503 service unavailable
    http_response_code(503);
 
    // mensagem para o usuário
    //echo json_encode(array("message" => "Não foi possível remover usuário."));
    echo json_encode(array("message" => "Não foi possível remover usuário. $usuario->email"));
}

