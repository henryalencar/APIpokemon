<?php //TESTE
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

echo json_encode(["mensagem" => "Ola Mundo"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); //o ENCODE pega o array e transforma em JSON

