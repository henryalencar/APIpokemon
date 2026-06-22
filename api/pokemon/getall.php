<?php
// POKEMON LISTA TODOS OS POKEMONS CADASTRADOS NO BANCO DE DADOS

// http://localhost/APIpokemon/api/pokemon/getall.php


// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir arquivos de banco de dados e modelo
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';

use Apipokemon\Config\Database; // Importando a classe Database do namespace Apipokemon\Config
use Apipokemon\Models\Pokemon; // Importando a classe Pokemon do namespace Apipokemon

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Pokemon
$pokemon = new Pokemon($db);

try {

    // Chamar o método getall() para buscar os pokemons
    $stmt = $pokemon->getall();
    $num = $stmt->rowCount();

    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {

        // Array de pokemons
        $pokemons_arr = array();

        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

 $pokemon_item = array(
  "id" => $pokemon->id,
  "nome" => $pokemon->nome,
  "tipo" => $pokemon->tipo,
  "nivel" => $pokemon->nivel,
  "hp" => $pokemon->hp,
  "velocidade" => $pokemon->velocidade,
  "ataque"=> $pokemon->ataque,
  "defesa"=> $pokemon->defesa,

    //"treinador" => $treinador
);
            array_push($pokemons_arr, $pokemon_item);
        }

        // Código 200 OK
        http_response_code(200);

        // Retornar JSON
        echo json_encode($pokemons_arr);

    } else {

        // Código 404 Not Found
        http_response_code(404);

        echo json_encode(
            array("Mensagem" => "Nenhum pokemon encontrado.")
        );
    }

} catch (Exception $e) {

    echo json_encode(
        array("erro de banco de dados" => $e->getMessage())
    );

} catch (Throwable $e) {

    echo json_encode(
        array("erro" => $e->getMessage())
    );
}