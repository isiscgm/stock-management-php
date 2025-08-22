<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pantry";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter dados do formulário
$produto = $_POST['produto'];
$quantidade = $_POST['quantidade'];
$unidade = $_POST['unidade'];
$data = $_POST['data'];
$fornecedor = $_POST['fornecedor'];
$status = $_POST['status'];

// Inserir dados no banco de dados
$sql = "INSERT INTO produtos (produto, quantidade, unidade, dia, fornecedor, status) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sissss", $produto, $quantidade, $unidade, $data, $fornecedor, $status);

if ($stmt->execute()) {
    header("Location: home.php?success=1");
} else {
    header("Location: home.php?success=0");
}

$stmt->close();
$conn->close();
?>
