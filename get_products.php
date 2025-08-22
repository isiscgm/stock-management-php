<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pantry";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$status = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT produto, quantidade, unidade FROM produtos";
if ($status !== '') {
    $sql .= " WHERE status = '" . $conn->real_escape_string($status) . "'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>Produto</th><th>Quantidade</th><th>Unidade</th></tr></thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['produto']) . "</td>";
        echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
        echo "<td>" . htmlspecialchars($row['unidade']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Nenhum produto encontrado.</p>";
}

$conn->close();
?>
