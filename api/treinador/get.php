<?php

//LISTA APENAS UM TREINADOR CADASTRADO NO BANCO DE DADOS, ESPECIFICADO PELO ID NA URL...

//localhost/APIpokemon/api/treinador/get.php?id=1


//api/treinador/get.php - parte 1 
 
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../Config/Database.php';
include_once '../../Models/Treinador.php';
 
use Apipokemon\Config\Database; // Importando a classe Database do namespace Apipokemon\Config
use Apipokemon\Models\treinador; // Importando a classe Pizza do namespace Apipokemon\Models
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Treinador
$treinador = new Treinador($db);
 
$treinador->id = isset($_GET['id']) ? $_GET['id'] : null;

try {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {  // Verificar se o método de requisição é GET NA URL...

        if ($treinador->id) {

            $treinador->get();

            if ($treinador->nome != null) {

                // Criar array de treinador
                
            $treinador_arr = array(
                "id" => $treinador->id,
                "nome" => $treinador->nome,
                "cidade" => $treinador->cidade,
                "idade" => $treinador->idade
            );

            http_response_code(200);  //SUCESSO

            echo json_encode($treinador_arr, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT é uma opção que formata o JSON de forma legível, com quebras de linha e indentação
            
            } else { 
                // SE O ID FOR INFORMADO MAS NÃO EXISTIR NO BANCO DE DADOS, RETORNA 404 NOT FOUND

                http_response_code(404); // NOT FOUND : ERRO
                echo json_encode(
                    array("Mensagem" => "Treinador não encontrado.")
                );
            }

        } else {

            http_response_code(400); // BAD REQUEST : ERRO
            echo json_encode(
                array("Mensagem" => "ID não informado.")
            );
        }

    } else {

        http_response_code(405); // METHOD NOT ALLOWED : ERRO
        echo json_encode(
            array("Mensagem" => "Método não permitido.")
        );
    }

    

} catch (PDOException $e) {  // PDOException é uma classe de exceção específica para erros relacionados ao banco de dados

    http_response_code(500); // INTERNAL SERVER ERROR : ERRO
    echo json_encode(
        array("Mensagem" => "Erro ao buscar o treinador: " . $e->getMessage())
    );

} catch (Throwable $e) {

    http_response_code(500);
    echo json_encode(
        array("Mensagem" => "Erro inesperado: " . $e->getMessage())
    );
}