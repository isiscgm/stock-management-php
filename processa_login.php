<?php
session_start();

// Inclua o arquivo de configuração para conectar ao banco de dados
include 'config.php';

// Verificar se os campos de login foram enviados via POST
if (isset($_POST['RM']) && isset($_POST['senha'])) {
    // Pegar os dados do formulário
    $rm = $_POST['RM'];
    $senha = $_POST['senha'];

    // Proteção contra SQL Injection (recomendado)
    $rm = mysqli_real_escape_string($conexao, $rm);
    $senha = mysqli_real_escape_string($conexao, $senha);

    // Consulta SQL para verificar o usuário
    $sql = "SELECT * FROM cadastro WHERE RM='$rm' AND senha='$senha'";
    $result = $conexao->query($sql);

    if ($result->num_rows == 1) {
        // Usuário autenticado com sucesso
        $_SESSION['RM'] = $rm; // Armazena o RM na sessão para identificar o usuário logado
        header("Location: home.php"); // Redireciona para a página inicial após login
        exit;
    } else {
        // Usuário ou senha incorretos
        echo "<script>alert('RM ou senha incorretos');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }
} else {
    // Caso os campos não tenham sido enviados via POST
    echo "<script>alert('Por favor, preencha o RM e senha.');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

// Fechar conexão com o banco de dados
$conn->close();
?>
