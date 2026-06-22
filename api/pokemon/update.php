<?php
//localhost:/API/api/pizza/update.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");

include_once '../../config/database.php';
include_once '../../Models/pokemon.php';

use Apipokemon\Config\Database;
use Apipokemon\Models\Pokemon;

$database = new Database();
$db = $database->getConnection();
$pokemon = new Pokemon($db);

if ($_SERVER['REQUEST_METHOD'] == 'PUT') { // Verificar se o método de requisição é PUT
    try {
        $data = json_decode(file_get_contents("php://input"));

        if ( // Verificar se os dados não estão vazios
            !empty($data->id) &&
            !empty($data->nome) &&
            !empty($data->tipo) &&
            !empty($data->nivel) &&
            !empty($data->hp) &&
            !empty($data->velocidade) &&
            !empty($data->ataque) &&
            !empty($data->defesa) 
        ) { // Se os dados estiverem completos, atribuir os valores ao objeto Pokemon
            $pokemon->id = $data->id;
            $pokemon->nome = $data->nome;
            $pokemon->tipo = $data->tipo;
            $pokemon->nivel = $data->nivel;
            $pokemon->hp = $data->hp;
            $pokemon->velocidade = $data->velocidade;
            $pokemon->ataque = $data->ataque;
            $pokemon->defesa = $data->defesa;

            if ($pokemon->update()) {
                http_response_code(200);
                echo json_encode(
                    array('Mensagem' => 'Pokemon Atualizado com Sucesso')
                );
            } else {
                http_response_code(400);
                echo json_encode(
                    array('Erro' => 'Nao foi possivel atualizar o Pokemon')
                );
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel atualizar o Pokemon.')
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