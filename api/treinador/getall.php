<?php

// http://localhost/API/api/pizza/getall.php

//PIZZA

// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../Config/Database.php';
include_once '../../Models/Pizza.php';
 
use Apipizza\Models\Pizza; // Importando a classe Pizza do namespace Apipizza\Models
use Apipizza\Config\Database; // Importando a classe Database do namespace Apipizza\Config

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);

 
try {
    //colocar para demonstrar erro com coluna errada mas lá no método read em pizza
    // Chamar o método getall() para buscar as pizzas
    $stmt = $pizza->getall();
    $num = $stmt->rowCount();
 
    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {
        // Array de pizzas
        $pizzas_arr = array();
 
        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome
            extract($row);
 
            $pizza_item = array(
                "id" => $idPizza,
                "nome" => $nome,
                "ingredientes" => $ingredientes,
                "valor" => $valor
            );
 
            array_push($pizzas_arr, $pizza_item);
        }
 
        // Definir o código de resposta como 200 OK
        http_response_code(200);
 
        // Mostrar os dados das pizzas em formato JSON
        echo json_encode($pizzas_arr);
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
 
