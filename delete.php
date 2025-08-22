<?php

$servername = "localhost"; 
$username = "root";      
$password = "";          
$dbname = "pantry";        

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql_deletar_historico = "DELETE FROM historico_baixas WHERE produto_id = ?";
    $stmt_deletar_historico = $conn->prepare($sql_deletar_historico);
    $stmt_deletar_historico->bind_param("i", $id);
    
    if ($stmt_deletar_historico->execute()) {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: home.php");
            exit;
        } else {
            echo "Erro ao excluir produto: " . $conn->error;
        }
    } else {
        echo "Erro ao excluir registros na tabela historico_baixas: " . $conn->error;
    }
}
$conn->close();
?>
