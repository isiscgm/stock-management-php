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
    
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if (!$product) {
        echo "Produto não encontrado!";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $data = $_POST['data'];
    $fornecedor = $_POST['fornecedor'];
    $status = $_POST['status'];
    $quantidade_unidade = $_POST['quantidade'] . " " . $_POST['unidade'];

    $sql = "UPDATE produtos SET produto = ?, quantidade = ?, dia = ?, fornecedor = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $produto, $quantidade_unidade, $data, $fornecedor, $status, $id);
    
    if ($stmt->execute()) {
        header("Location: home.php");
        exit;
    } else {
        echo "Erro ao atualizar produto: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style.css">
    <script src="http://localhost/TCCNOVO/script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mlO17D9ThRzHcE3zwBndzD1B5K8hxz8YUJQ3MyN52zsn8S7HQo7rdtrjlNfY4M7O" crossorigin="anonymous"></script>
</head>
<body>
    <span class="hamburger" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </span>

    <!-- navbar-menu -->
    <nav class="w3-sidebar w3-collapse w3-top w3-large" style="z-index:3;width:300px;font-weight:bold;background-color:#eeeeee;color:#fff;" id="mySidebar">
        <br>
        <div class="w3-container">
            <h3 class="w3-padding-64" style="font-size:37px;"><img class="logo" style="width: 170px;" src="img/etecaqa.png"></h3>
        </div>
        <div class="w3-bar-block" style="font-size:23px;">
            <a href="#" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Geral</a>
            <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Estoque</a>
            <a href="#services" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Relatórios</a>
            <a href="#designers" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Fornecedores</a>
            <a href="#packages" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Serviços</a>
            <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Login</a>
            <a href="account.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Cadastre-se</a>
        </div>
        <div class="w3-container" style="text-align: left; margin-top: 220px;">
            <h3><img class="logo" src="img/cps.png" style="width: 90px; margin-top: 10px;"></h3>
        </div>
    </nav>
    <div class="container">
    <div class="form-container">
    <h1 class="my-4">Editar Produto</h1>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <div class="mb-3">
                <label for="produto" class="form-label">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto" value="<?php echo htmlspecialchars($product['produto']); ?>" required>
            </div>
            <div class="mb-3">
    <label for="quantidade" class="form-label">Quantidade</label>
    <div class="input-group">
        <?php
        $quantidade_unidade = explode(' ', $product['quantidade']);
        $quantidade = isset($quantidade_unidade[0]) ? $quantidade_unidade[0] : '';
        $unidade = isset($quantidade_unidade[1]) ? $quantidade_unidade[1] : '';
        ?>
        <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($quantidade); ?>" required>
        <select class="form-control" id="unidade" name="unidade" required>
            <option value="Kg" <?php echo $unidade == 'Kg' ? 'selected' : ''; ?>>Kg</option>
            <option value="Pacote" <?php echo $unidade == 'Pacote' ? 'selected' : ''; ?>>Pacote (s)</option>
            <option value="g" <?php echo $unidade == 'g' ? 'selected' : ''; ?>>g</option>
            <option value="Litro(s)" <?php echo $unidade == 'Litro' ? 'selected' : ''; ?>>Litro(s)</option>
        </select>
    </div>
</div>

            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" class="form-control" id="data" name="data" value="<?php echo htmlspecialchars($product['dia']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="fornecedor" class="form-label">Fornecedor</label>
                <input type="text" class="form-control" id="fornecedor" name="fornecedor" value="<?php echo htmlspecialchars($product['fornecedor']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="OK" <?php echo $product['status'] == 'OK' ? 'selected' : ''; ?>>OK</option>
                    <option value="PENDENTE" <?php echo $product['status'] == 'PENDENTE' ? 'selected' : ''; ?>>Pendente</option>
                    <option value="EM FALTA" <?php echo $product['status'] == 'EM FALTA' ? 'selected' : ''; ?>>Em Falta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <button a href="estoque.php" class="btn btn-danger">Cancelar</button>
        </form>
    </div>
</div>

</body>
</html>
