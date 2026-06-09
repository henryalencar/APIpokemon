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

    public $treinadores;

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
                p.treinadores
            FROM
                ' . $this->tabela . ' p
            WHERE
                p.idPokemon = ?    
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
        $this->tipo = $row['tipo'];
        $this->nivel = $row['nivel'];
        $this->hp = $row['hp'];
        $this->treinadores = $row['treinadores'];
 
    }

    public function add(){  //ADICIONA UMA NOVA POKEMON NO BANCO DE DADOS VIA POST, RECEBENDO OS DADOS DA POKEMON VIA PROPRIEDADES DO OBJETO
        $query = "INSERT INTO " . $this->tabela . " (nome, tipo, nivel, hp, treinadores) VALUES (:nome, :tipo, :nivel, :hp, :treinadores)";

        $stmt = $this->db->prepare($query);

        // Limpa os dados para evitar SQL Injection e XSS (Cross-Site Scripting)
        $this->nome=htmlspecialchars(strip_tags($this->nome)); 
        $this->tipo=htmlspecialchars(strip_tags($this->tipo));
        $this->nivel=htmlspecialchars(strip_tags($this->nivel));
        $this->hp=htmlspecialchars(strip_tags($this->hp));
        $this->treinadores=htmlspecialchars(strip_tags($this->treinadores));

        // Bind dos valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":nivel", $this->nivel);
        $stmt->bindParam(":hp", $this->hp);
        $stmt->bindParam(":treinadores", $this->treinadores);

        if($stmt->execute()){
            return true;
        }
 
        return false;

    }
    
}