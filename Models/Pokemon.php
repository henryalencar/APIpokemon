<?php

namespace Apipokemon\Models; //definindo o namespace para organizar o código e evitar conflitos de nomes
use PDO; // Importando a classe PDO para manipulação de banco de dados
use Exception; // Importando a classe Exception para tratamento de erros

class Pokemon{
    public $id;

    public $nome;

    public $tipo;

    public $nivel;

    public $hp;

    public $idtreinador;

    public $velocidade;

    public $ataque;

    public $defesa;

    private $db;

    private $tabela = "pokemons";
    
    //METODO CONSTRUTOR PARA RECEBER A CONEXAO COM O BANCO DE DADOS

    public function __construct($db){
        $this->db = $db;
    }
    
    public function getall(){   //VAI NO BANCO DE DADOS E TRAZ TODAS AS POKEMONS CADASTRADAS
        $query = "SELECT * FROM " . $this->tabela;

        $stmt = $this->db->prepare($query); //preparando a query para ser executada, evitando SQL Injection

        $stmt->execute();  //stmt é o objeto que contém o resultado da consulta, e execute() executa a consulta preparada

        return $stmt;
    }

    public function get(){  // VAI NO BANCO DE DADOS E TRAZ APENAS A POKEMON COM O ID ESPECIFICADO
    // Cria a consulta
        $query = 'SELECT 
    p.idPokemon,
    p.nome,
    p.tipo,
    p.nivel,
    p.hp,
    p.velocidade
    p.ataque 
    p.defesa
    t.nome AS treinador
    FROM pokemons p
    LEFT JOIN treinadores t
    ON p.idTreinador = t.idTreinador
    WHERE p.idPokemon = :id';
 
        // Prepara a query
        $stmt = $this->db->prepare($query);
 
        // Vincula o ID 
        $stmt->bindParam(':id', $this->id);
       
        // Executa a query
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // Define as propriedades
        $this->nome = $row['nome'];
        $this->tipo = $row['tipo'];
        $this->nivel = $row['nivel'];
        $this->hp = $row['hp'];
        $this->velocidade = $row['velocidade'];
        $this->ataque = $row['ataque'];
        $this->defesa = $row['defesa'];
        $this->idtreinador = $row['idTreinador']; 
 
    }

    public function add(){  //ADICIONA UMA NOVA POKEMON NO BANCO DE DADOS VIA POST, RECEBENDO OS DADOS DA POKEMON VIA PROPRIEDADES DO OBJETO
        $query = "INSERT INTO " . $this->tabela . "(nome, tipo, nivel, hp, velocidade, ataque, defesa,  idTreinador) VALUES (:nome, :tipo, :nivel, :hp, :velocidade, :ataque, :defesa, :idTreinador)";

        $stmt = $this->db->prepare($query);

        // Limpa os dados para evitar SQL Injection e XSS (Cross-Site Scripting)
        $this->nome=htmlspecialchars(strip_tags($this->nome)); 
        $this->tipo=htmlspecialchars(strip_tags($this->tipo));
        $this->nivel=htmlspecialchars(strip_tags($this->nivel));
        $this->hp=htmlspecialchars(strip_tags($this->hp));
        $this->velocidade=htmlspecialchars(strip_tags($this->velocidade));
        $this->ataque=htmlspecialchars(strip_tags($this->ataque));
        $this->defesa=htmlspecialchars(strip_tags($this->defesa));
        $this->idtreinador=htmlspecialchars(strip_tags($this->idtreinador));

        // Bind dos valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":nivel", $this->nivel);
        $stmt->bindParam(":hp", $this->hp);
        $stmt->bindParam("velocidade", $this->velocidade);
        $stmt->bindParam("ataque", $this->ataque);
        $stmt->bindParam("defesa", $this->defesa);
        $stmt->bindParam(":idTreinador", $this->idtreinador);

        if($stmt->execute()){
            return true;
        }
 
        return false;

    }
    public function update(){  //ATUALIZA OS DADOS DE UMA POKEMON EXISTENTE NO BANCO DE DADOS VIA PUT, RECEBENDO OS DADOS DA POKEMON VIA PROPRIEDADES DO OBJETO
        $query = "UPDATE " . $this->tabela . " SET nome = :nome, tipo = :tipo, nivel = :nivel, hp = :hp = :velocidade, = :ataque, = :defesa,  WHERE idPokemon = :id";
 
        $stmt = $this->db->prepare($query);
 
        // Limpa os dados para evitar SQL Injection e XSS
        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->tipo=htmlspecialchars(strip_tags($this->tipo));
        $this->nivel=htmlspecialchars(strip_tags($this->nivel));
        $this->hp=htmlspecialchars(strip_tags($this->hp));
        $this->velocidade=htmlspecialchars(strip_tags($this->velocidade));
        $this->ataque=htmlspecialchars(strip_tags($this->ataque));
        $this->defesa=htmlspecialchars(strip_tags($this->defesa));

        $this->id=htmlspecialchars(strip_tags($this->id));
 
        // Bind dos valores/ bindParam é um método do PDO que vincula um valor a um parâmetro
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":nivel", $this->nivel);
        $stmt->bindParam(":hp", $this->hp);
        $stmt->bindParam("velocidade", $this->velocidade);
        $stmt->bindParam("ataque", $this->ataque);
        $stmt->bindParam("defesa", $this->defesa);
        $stmt->bindParam(":id", $this->id);
 
        if($stmt->execute()){
            return true;
        }
 
        return false;
    }

    public function delete(){  //EXCLUI UMA POKEMON EXISTENTE NO BANCO DE DADOS VIA DELETE, RECEBENDO O ID DA POKEMON VIA PROPRIEDADES DO OBJETO
        $query = "DELETE FROM " . $this->tabela . " WHERE idPokemon = :id";
 
        $stmt = $this->db->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
 
        // Bind do ID
        $stmt->bindParam(":id", $this->id);
 
        if($stmt->execute()){
            return true;
        }
 
        return false;
    }

    public function getTreinador(){  //VAI NO BANCO DE DADOS E TRAZ O TREINADOR ASSOCIADO A POKEMON COM O ID ESPECIFICADO
    $query = 'SELECT
    t.idTreinador,
    t.nome AS treinador
    FROM treinadores t
    WHERE t.idTreinador = :id';
 
        $stmt = $this->db->prepare($query);
 
        $this->idtreinador=htmlspecialchars(strip_tags($this->idtreinador));
 
        $stmt->bindParam(':id', $this->idtreinador);
 
        $stmt->execute();
 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

        public function getPokemonsTreinador(){

    $query = "SELECT
        idPokemon,
        nome
        FROM pokemons
        WHERE idTreinador = :id";

    $stmt = $this->db->prepare($query);

    $stmt->bindParam(':id', $this->idtreinador);

    $stmt->execute();

    return $stmt;

    }

  public function getMaisVelozes(){
                               
    $query = "SELECT
    idPokemon,
    nome,
    velocidade
    FROM pokemons
    ORDER BY velocidade DESC
    LIMIT 5";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;

}

  public function getAtaque(){
                               
    $query = "SELECT
    idPokemon,
    nome,
    ataque
    FROM pokemons
    ORDER BY ataque DESC
    LIMIT 5";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
}

public function getDefesa(){
                               
    $query = "SELECT
    idPokemon,
    nome,
    defesa
    FROM pokemons
    ORDER BY defesa DESC
    LIMIT 5";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;

}

}