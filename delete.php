<?php
// delete.php

// Configurações para conexão com o banco de dados
$servername = "localhost"; // Nome do servidor de banco de dados
$username = "root";        // Nome de usuário do banco de dados
$password = "";            // Senha do banco de dados (vazia por padrão)
$dbname = "pantry";        // Nome do banco de dados

// Cria uma nova conexão com o banco de dados usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se houver um erro de conexão, exibe uma mensagem e para a execução do script
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a solicitação é do tipo GET e se o parâmetro 'id' está presente na URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Obtém o valor do parâmetro 'id' da URL
    
    // 1. Excluir os registros dependentes na tabela historico_baixas
    $sql_deletar_historico = "DELETE FROM historico_baixas WHERE produto_id = ?";
    $stmt_deletar_historico = $conn->prepare($sql_deletar_historico);
    $stmt_deletar_historico->bind_param("i", $id);
    
    // Executa a exclusão dos registros na tabela historico_baixas
    if ($stmt_deletar_historico->execute()) {
        // 2. Agora, excluir o produto da tabela produtos
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $conn->prepare($sql); // Prepara a instrução SQL para evitar injeção de SQL
        $stmt->bind_param("i", $id);   // Vincula o parâmetro 'id' à instrução SQL (tipo 'i' para inteiro)
        
        // Executa a instrução SQL
        if ($stmt->execute()) {
            // Se a exclusão for bem-sucedida, redireciona para a página inicial
            header("Location: home.php");
            exit; // Para a execução do script após o redirecionamento
        } else {
            // Se ocorrer um erro ao excluir o produto, exibe a mensagem de erro
            echo "Erro ao excluir produto: " . $conn->error;
        }
    } else {
        // Se ocorrer um erro ao excluir os registros na tabela historico_baixas
        echo "Erro ao excluir registros na tabela historico_baixas: " . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
