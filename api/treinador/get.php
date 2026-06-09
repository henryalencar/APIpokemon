
<?php

//localhost/API/api/pizza/get.php?id=1

//api/pizza/get.php - parte 1 
 
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../Config/Database.php';
include_once '../../Models/Pizza.php';
 
use Apipizza\Config\Database; // Importando a classe Database do namespace Apipizza\Config
use Apipizza\Models\Pizza; // Importando a classe Pizza do namespace Apipizza\Models
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
$pizza->id = isset($_GET['id']) ? $_GET['id'] : null;

try {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {  // Verificar se o método de requisição é GET NA URL...

        if ($pizza->id) {

            $pizza->get();

            if ($pizza->nome != null) {

                // Criar array de pizza
                
            $pizza_arr = array(
                "id" => $pizza->id,
                "nome" => $pizza->nome,
                "ingredientes" => $pizza->ingredientes,
                "valor" => $pizza->valor
            );

            http_response_code(200);  //SUCESSO

            echo json_encode($pizza_arr, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT é uma opção que formata o JSON de forma legível, com quebras de linha e indentação
            
            } else { 
                // SE O ID FOR INFORMADO MAS NÃO EXISTIR NO BANCO DE DADOS, RETORNA 404 NOT FOUND

                http_response_code(404); // NOT FOUND : ERRO
                echo json_encode(
                    array("Mensagem" => "Pizza não encontrada.")
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
        array("Mensagem" => "Erro ao buscar a pizza: " . $e->getMessage())
    );

} catch (Throwable $e) {

    http_response_code(500);
    echo json_encode(
        array("Mensagem" => "Erro inesperado: " . $e->getMessage())
    );
}