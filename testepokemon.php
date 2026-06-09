<?php
//http://localhost/APIpokemon/pokemon.php

require_once __DIR__ . "/Config/Database.php";
require_once __DIR__ . "/Models/Pokemon.php";

use Apipokemon\Models\Pokemon; //imprortnsdo o modelo pokemon
use Apipokemon\Config\Database; // Importando a classe Database do namespace Apipokemon\Config

$bancoDados= new Database();
$conexao = $bancoDados->getConnection();

echo "<h1>Testando Conexão e Modelo</h1>";
 
if (!$conexao) {
    echo "<p style='color: red;'>Falha na conexão.</p>";
    die(); // Encerra o script se não houver conexão
}
 
echo "<p style='color: green;'>Conexão bem-sucedida!</p>";
 
echo "<h2>Criando um objeto Pokemon...</h2>";
 
// Criamos uma instância da classe Pokemon, passando a conexão com o banco
$pokemon = new \Apipokemon\Models\Pokemon($conexao);
 
// Atribuímos valores às suas propriedades públicas
$pokemon->nome = 'Pikachu';
$pokemon->tipo = 'Elétrico';
$pokemon->nivel = 25;
$pokemon->hp = 100;
$pokemon->treinadores = 'Ash Ketchum';
 
// Vamos inspecionar o objeto!
echo "<pre>"; // A tag <pre> ajuda a formatar a saída do print_r
print_r($pokemon);
echo "</pre>";