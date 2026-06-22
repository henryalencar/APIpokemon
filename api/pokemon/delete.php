<?php
//localhost:/API/APIpokemon/pokemon/delete.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");

include_once '../../config/database.php';
include_once '../../Models/pokemon.php';

use Apipokemon\Config\Database;
use Apipokemon\Models\Pokemon;

$database = new Database();
$db = $database->getConnection();

$pokemon = new Pokemon($db);

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { // Verificar se o método de requisição é DELETE
    try {
        $data = json_decode(file_get_contents("php://input")); // Vai Ler os dados da requisição e decodificar o JSON para um objeto PHP

            if ( // Verificar se os dados não estão vazios
            !empty($data->id) 
        
        ) { // Se os dados estiverem completos, atribuir os valores ao objeto Bebida
            $pokemon->id = $data->id;
   
         if ($pokemon->delete()) {
         http_response_code(200);
         echo json_encode([
        'Mensagem' => 'Pokemon Deletado com Sucesso'
        ]);


            } else {
                http_response_code(400);
                echo json_encode(
                    array('Erro' => 'Nao foi possivel deletar o Pokemon')
                );
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel deletar o Pokemon.')
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
        array('Erro' => 'Metodo nao permitido. Use DELETE.')
    );
}