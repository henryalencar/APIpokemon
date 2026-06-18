<?php 

//http://localhost/APIpokemon/api/pokemon/add.php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
 
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php'; 
 
use Apipokemon\Config\Database; // Importando a classe Database do namespace Apipokemon\Config
use Apipokemon\Models\Pokemon; // Importando a classe Pizza do namespace Apipokemon

// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pokemon
$pokemon = new Pokemon($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        if (
            !empty($data->nome) &&
            !empty($data->tipo) &&
            !empty($data->nivel) &&
            !empty($data->hp) &&
            !empty($data->idtreinador)
        ) {
            // Atribuir os valores ao objeto POKEMON
            $pokemon->nome = $data->nome;
            $pokemon->tipo = $data->tipo;
            $pokemon->nivel = $data->nivel;
            $pokemon->hp = $data->hp;
            $pokemon->idtreinador = $data->idtreinador;
 
            // Criar o pokemon
            if ($pokemon->add()) {
                http_response_code(201);
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Pokemon Criado com Sucesso')
                );
            } else {
                http_response_code(400);
                // Resposta de erro
                echo json_encode(
                    array('Erro' => 'Nao foi possivel criar o Pokemon')
                );
            }
        } else {
            http_response_code(400);
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel criar o Pokemon.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("Erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("Erro" => "Método não suportado!"));
}
 