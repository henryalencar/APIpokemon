<?php

// http://localhost/API/api/bebida/alcoolica.php


header("Access-Control-Allow-Origin: *"); // Permitir acesso de qualquer origem
header("Content-Type: application/json; charset=UTF-8"); // Definir o tipo de conteúdo como JSON

include_once '../../Config/Database.php'; // Incluir o arquivo de configuração do banco de dados
include_once '../../Models/Bebida.php'; // Incluir o arquivo do modelo Bebida

use apipokemon\Config\Database; // Importando a classe Database do namespace Apipokemon\Config
use apipokemon\Models\pokemon; // Importando a classe Bebida do namespace Apipokemon\Models

$database = new Database(); // Instanciar o objeto Database
$db = $database->getConnection(); // Obter a conexão com o banco de dados

$bebida = new pokemon($db); // Instanciar o objeto Bebida

$query = "SELECT * FROM bebidas WHERE categoria = 'alcoolica'"; // Consulta o banco SQL para selecionar apenas as bebidas alcoólicas
$stmt = $db->prepare($query);
$stmt->execute();

$bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC);  ///fetchAll() é um método do PDOStatement que retorna todas as linhas do conjunto de resultados como um array. O parâmetro PDO::FETCH_ASSOC indica que cada linha deve ser retornada como um array associativo, onde as chaves são os nomes das colunas do banco de dados.

echo json_encode($bebidas);