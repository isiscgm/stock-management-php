<?php
$servername = "Localhost";
$username = "root";
$password = "";
$dbname = "pantry";

$conexao = new mysqli($servername, $username, $password, $dbname);
if ($conexao->connect_error) {
   die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}
?>