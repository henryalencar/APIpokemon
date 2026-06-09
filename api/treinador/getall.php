<?php
//LISTA TODOS OS TREINADORES CADASTRADOS NO BANCO DE DADOS

//http://localhost/APIpokemon/api/treinador/getall.php

//TREINADOR

// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../Config/Database.php';
include_once '../../Models/Treinador.php';
 
use Apipokemon\Config\Database; // Importando a classe Database do namespace Apipokemon\Config
use Apipokemon\Models\Treinador; // Importando a classe Treinador do namespace Apipokemon\Models

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Treinador
$treinador = new Treinador($db);

 
try {
    //colocar para demonstrar erro com coluna errada mas lá no método read em treinador
    // Chamar o método getall() para buscar os treinadores
    $stmt = $treinador->getall();
    $num = $stmt->rowCount();
 
    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {
        // Array de treinadores
        $treinadores_arr = array();
 
        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome
            extract($row);
 
            $treinador_item = array(
                "id" => $idTreinador,
                "nome" => $nome,
                "cidade" => $cidade,
                "idade" => $idade
            );
 
            array_push($treinadores_arr, $treinador_item);
        }
 
        // Definir o código de resposta como 200 OK
        http_response_code(200);
 
        // Mostrar os dados dos treinadores em formato JSON
        echo json_encode($treinadores_arr);
    } else {
        // Se nenhuma pizza for encontrada, definir o código de resposta como 404 Not Found
        http_response_code(404);
 
        // Informar ao usuário que nenhuma pizza foi encontrada
        echo json_encode(
            array("Mensagem" => "Nenhuma pizza encontrada.")
        );
    }
} catch (Exception $e) {
    echo json_encode(array("erro de banco de dados" => $e->getMessage()));
}

 catch (Throwable $e) {
    echo json_encode(array("erro" => $e->getMessage()));
}
 
