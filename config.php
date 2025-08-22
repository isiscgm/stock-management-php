<?php
$servername = "Localhost";
$username = "root";
$password = "";
$dbname = "pantry";
// Criando a conexão
$conexao = new mysqli($servername, $username, $password, $dbname);
// Verificando a conexão
if ($conexao->connect_error) {
   die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}
?>