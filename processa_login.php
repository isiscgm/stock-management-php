<?php
session_start();

include 'config.php';

if (isset($_POST['RM']) && isset($_POST['senha'])) {
    // Pegar os dados do formulário
    $rm = $_POST['RM'];
    $senha = $_POST['senha'];

    $rm = mysqli_real_escape_string($conexao, $rm);
    $senha = mysqli_real_escape_string($conexao, $senha);

    $sql = "SELECT * FROM cadastro WHERE RM='$rm' AND senha='$senha'";
    $result = $conexao->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['RM'] = $rm; 
        header("Location: home.php");
        exit;
    } else {
        echo "<script>alert('RM ou senha incorretos');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Por favor, preencha o RM e senha.');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$conn->close();
?>
