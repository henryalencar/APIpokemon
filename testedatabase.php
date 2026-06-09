<?php
 
require_once __DIR__ . "/Config/Database.php";
 
echo "<h1>Testando Conexão com o Banco de Dados</h1>";
 
//instantia a classe de conexao
$database = new \Apipokemon\Config\Database(); //teste de conexão com o banco de dados, utilizando a classe Database do namespace Apipokemon\Config
$conn = $database->getConnection();
 
if ($conn) {
    echo "<p style='color: green;'>Conexão bem-sucedida!</p>";
} else {
    echo "<p style='color: red;'>Falha na conexão. Verifique as credenciais no arquivo config/Database.php e se o banco de dados 'pizzaria_db' existe.</p>";
}
?>
