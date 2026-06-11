<?php
//localhost:/API/api/pizza/update.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");

include_once '../../config/database.php';
include_once '../../Models/pizza.php';

use Apipokemon\Config\Database;
use Apipokemon\Models\Treinador;

$database = new Database();
$db = $database->getConnection();
$treinador = new Treinador($db);

if ($_SERVER['REQUEST_METHOD'] == 'PUT') { // Verificar se o método de requisição é PUT
    try {
        $data = json_decode(file_get_contents("php://input"));

        if ( // Verificar se os dados não estão vazios
            !empty($data->id) &&
            !empty($data->nome) &&
            !empty($data->idade) &&
            !empty($data->cidade)
        ) { // Se os dados estiverem completos, atribuir os valores ao objeto Treinador
            $treinador->id = $data->id;
            $treinador->nome = $data->nome;
            $treinador->idade = $data->idade;
            $treinador->cidade = $data->cidade;

            if ($treinador->update()) {
                http_response_code(200);
                echo json_encode(
                    array('Mensagem' => 'Treinador Atualizado com Sucesso')
                );
            } else {
                http_response_code(400);
                echo json_encode(
                    array('Erro' => 'Nao foi possivel atualizar o Treinador')
                );
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel atualizar o Treinador.')
            );
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(
            array('Erro' => 'Ocorreu um erro: ' . $e->getMessage())
        );
    }
} else {
    http_response_code(405);
    echo json_encode(
        array('Erro' => 'Metodo nao permitido. Use PUT.')
    );
}