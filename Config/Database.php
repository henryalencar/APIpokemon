<?php

namespace Apipokemon\Config; //definindo o namespace para organizar o código e evitar conflitos de nomes
use PDO; // Importando a classe PDO para facilitar a conexão com o banco de dados
use PDOException; // Importando a classe PDOException para tratar erros de conexão
use Throwable; // Importando a classe Throwable para capturar erros genéricoss


class Database{ // Classe para gerenciar a conexão com o banco de dados

// IP DO SERVER
private $host="localhost";

//PORTA
private $port="3306";

//BANCO DE DADOS
private $db_name='Apipokemon';

//LOGIN
private $user_name='root';

//A CONEXAO
private $password='';

private $conection;

/*private function dividir($dividindo, $divisor)
{
    return $dividindo / $divisor;
}
*/


   // Método para obter a conexão com o banco de dados
    public function getConnection() {

        $this->conection = null;
 
        try {

            //$resultado = $this->dividir(10, 0); // Exemplo de divisão por zero para testar o tratamento de erros
            
            // DSN (Data Source Name) - String de conexão

            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';

            // Instancia o objeto PDO

            $this->conection = new PDO($dsn, $this->user_name, $this->password);

            // Define o modo de erro do PDO para exceção

            // Isso faz com que o PDO lance exceções em caso de erros, facilitando o tratamento

            $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {

            // Em caso de erro na conexão, exibe a mensagem de erro

            echo 'Erro de Conexão: ' . $e->getMessage();

        } catch (Throwable $e) {

            // Captura qualquer outra exceção que possa ocorrer, ele vai pegar os erros 

            echo 'Erro Generico: ' . $e->getMessage();

        }
 
        return $this->conection;

    }

}
 


