<?php
//http://localhost/APIPOKEMON/api/pokemon/velozes.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';

use Apipokemon\Config\Database;
use Apipokemon\Models\Pokemon;

$database = new Database();
$db = $database->getConnection();

$pokemon = new Pokemon($db);

$stmt = $pokemon->getMaisVelozes();

$pokemons = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $pokemons[] = [
        "idPokemon" => $idPokemon,
        "nome" => $nome,
        "velocidade" => $velocidade
    ];
}

echo json_encode($pokemons);