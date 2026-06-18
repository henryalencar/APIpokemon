<?php

//http://localhost/APIPOKEMON/api/pokemon/portreinador.php?idTreinador=2

header("Access-Control-Allow-Origin: *");

include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';

use Apipokemon\Config\Database;
use Apipokemon\Models\Pokemon;

$database = new Database();
$db = $database->getConnection();

$pokemon = new Pokemon($db);

$pokemon->idtreinador = $_GET['idTreinador'];

$treinador = $pokemon->getTreinador();

if(!$treinador){
    echo json_encode([
        "mensagem" => "Treinador não encontrado!"
    ]);
    exit;
}

if(!isset($_GET['idTreinador'])){
    echo json_encode([
        "mensagem" => "Informe o idTreinador!"
    ]);
    exit;
}

$pokemon->idtreinador = $_GET['idTreinador'];

$stmt = $pokemon->getPokemonsTreinador();

if($stmt->rowCount() > 0){

    $pokemons = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $pokemons[] = $row;
    }

    echo json_encode([
        "treinador" => $treinador['treinador'],
        "pokemons" => $pokemons
    ]);

}else{

    echo json_encode([
        "treinador" => $treinador['treinador'],
        "mensagem" => "Este treinador não treina nenhum pokemon por ora!"
    ]);
}