<?php

namespace Apipokemon\Models; //definindo o namespace para organizar o código e evitar conflitos de nomes
use PDO; // Importando a classe PDO para manipulação de banco de dados
use Exception; // Importando a classe Exception para tratamento de erros

class Treinador {

    public $id;

    public $nome;

    public $cidade;

    public $idade;

    private $db;

    private $tabela = "treinadores";

    // Lista todos os treinadores
    public function getAll(){   // ROTA GETALL PARA TRAZER TODOS OS TREINADORES EM OREM ALFABÉTICA
        $query = "SELECT * FROM " . $this->tabela . " ORDER BY nome ASC";  // para selecionar todos os treinadores ordenados por nome usei o 'ORDER BY nome ASC'

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Lista apenas treinadores
    public function getAlcoolicas(){
        $query = "SELECT * FROM " . $this->tabela . " WHERE categoria = 'treinador'";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Lista apenas treinadores não alcoólicos
    public function getNaoAlcoolicas(){
        $query = "SELECT * FROM " . $this->tabela . " WHERE categoria = 'treinador'";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //METODO CONSTRUTOR PARA RECEBER A CONEXAO COM O BANCO DE DADOS

    public function __construct($db){
        $this->db = $db;
    }


    public function get(){  // VAI NO BANCO DE DADOS E TRAZ APENAS A BEBIDA COM O ID ESPECIFICADO
    // Cria a consulta
        $query = 'SELECT
        p.idTreinador,
        p.nome,
        p.idade,
        p.cidade
        FROM
        ' . $this->tabela . ' p
        WHERE
        p.idTreinador = ?
        LIMIT 1';
 
        // Prepara a query
        $stmt = $this->db->prepare($query);
 
        // Vincula o ID
        $stmt->bindParam(1, $this->id);
       
        // Executa a query
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // Define as propriedades
        $this->nome = $row['nome'];
        $this->idade = $row['idade'];
        $this->cidade = $row['cidade'];
        
        
        

    }
    
}


