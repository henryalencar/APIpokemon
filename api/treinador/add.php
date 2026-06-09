<?php 

//http://localhost/API/api/pizza/add.php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
 
include_once '../../Config/Database.php';
include_once '../../Models/Pizza.php';
 
use Apipizza\Config\Database; // Importando a classe Database do namespace Apipizza\Config
use Apipizza\Models\Pizza; // Importando a classe Pizza do namespace Apipizza\Models

// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        if (
            !empty($data->nome) &&
            !empty($data->ingredientes) &&
            !empty($data->valor)
            //!empty() é uma função do PHP que verifica se uma variável está vazia. Ela retorna true se a variável estiver vazia (ou seja, se for null, false, '', 0, '0', ou um array vazio), e false caso contrário.

        ) {
            // Atribuir os valores ao objeto Pizza
            $pizza->nome = $data->nome;
            $pizza->ingredientes = $data->ingredientes;
            $pizza->valor = $data->valor;
 
            // Criar a pizza
            if ($pizza->add()) {
                http_response_code(201);
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Pizza Criada com Sucesso')
                );
            } else {
                http_response_code(400);
                // Resposta de erro
                echo json_encode(
                    array('Erro' => 'Nao foi possivel criar a Pizza')
                );
            }
        } else {
            http_response_code(400);
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel criar a Pizza.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("Erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("Erro" => "Método não suportado!"));
}
 