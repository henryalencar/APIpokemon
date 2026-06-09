<?php

//http://localhost/APIpokemon/treinador.php

require_once __DIR__ . "/Config/Database.php";
require_once __DIR__ . "/Models/Treinador.php";

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
 
echo "<h2>Criando um objeto Treinador...</h2>";
 
// Criamos uma instância da classe Treinador, passando a conexão com o banco
$treinador = new \Apipokemon\Models\Treinador($conexao);
 
// Atribuímos valores às suas propriedades públicas
$treinador->nome = 'Ash Ketchum';
$treinador->idade = 10;
$treinador->cidade = 'Pallet Town';
 
// Vamos inspecionar o objeto!
echo "<pre>"; // A tag <pre> ajuda a formatar a saída do print_r
print_r($treinador);
echo "</pre>";
 
 
 