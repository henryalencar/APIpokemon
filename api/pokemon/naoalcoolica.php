<?php
// http://localhost/API/api/bebida/alcoolica.php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../Config/Database.php'; // Incluir o arquivo de configuração do banco de dados
include_once '../../Models/Bebida.php';  // Incluir o arquivo do modelo Bebida

use Apipizza\Config\Database; // Importando a classe Database do namespace Apipizza\Config
use Apipizza\Models\Bebida;

$database = new Database();
$db = $database->getConnection(); // Obter a conexão com o banco de dados

$bebida = new Bebida($db);

$query = "SELECT * FROM bebidas WHERE categoria = 'nao_alcoolica'"; // Consulta o banco SQL para selecionar apenas as bebidas não alcoólicas
$stmt = $db->prepare($query);
$stmt->execute();

$bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC); // Buscar os resultados como um array associativo

echo json_encode($bebidas);