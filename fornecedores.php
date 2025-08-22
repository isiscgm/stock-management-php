<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pantry";

$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$supplier_sql = "SELECT DISTINCT fornecedor FROM produtos";
$supplier_result = $conn->query($supplier_sql);

$selected_supplier = isset($_GET['fornecedor']) ? $_GET['fornecedor'] : '';
$where_clause = $selected_supplier ? "WHERE fornecedor = '" . $conn->real_escape_string($selected_supplier) . "'" : '';
$sql = "SELECT produto, fornecedor FROM produtos $where_clause";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - Pantry Escolar</title>
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style.css">
    <script src="http://localhost/TCCNOVO/script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mlO17D9ThRzHcE3zwBndzD1B5K8hxz8YUJQ3MyN52zsn8S7HQo7rdtrjlNfY4M7O" crossorigin="anonymous"></script>
    <style>
    #fornecedor {
        width: 150px; 
        font-size: 14px; 
    }
    </style>
</head>
<body>
    <span class="hamburger" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </span>

    <nav class="w3-sidebar w3-collapse w3-top w3-large" style="z-index:3;width:300px;font-weight:bold;background-color:#eeeeee;color:#fff;" id="mySidebar">
        <br>
        <div class="w3-container">
            <h3 class="w3-padding-64" style="font-size:37px;"><img class="logo" style="width: 170px;" src="img/new.png"></h3>
        </div>
        <div class="w3-bar-block" style="font-size:23px;">
            <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Geral</a>
            <a href="estoque.php" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Estoque</a>
            <a href="relatorios.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Relatórios</a>
            <a href="fornecedores.php" onclick="w3_close()" class="w3-bar-item w3-red w3-button w3-hover-red">Fornecedores</a>
            <a href="servicos.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Serviços</a>
            <a href="baixa.php" class="w3-bar-item w3-gray w3-button w3-hover-red">Registro de Saída</a>
        </div>
        <div class="w3-container" style="text-align: left; margin-top: 220px;">
</div>
<a href="logout.php" style="position: fixed; bottom: 20px; left: 20px; font-size: 18px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: black; padding: 10px 15px;">
    <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Sair
</a>
    </nav>
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:340px;margin-right:40px;">
        <!-- Header -->
        <div class="w3-container" style="margin-top:80px" id="showcase">
            <h1 class="w3-jumbo"><b>Fornecedores</b></h1>
            <hr style="width:50px;border:5px solid black" class="w3-round">
        </div>

        <div class="container mt-4">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="fornecedor" class="form-label">Pesquisar:</label>
                    <select id="fornecedor" name="fornecedor" class="form-select" aria-label="Filtrar por Fornecedor">
                        <option value="" selected>Todos</option>
                        <?php
                        if ($supplier_result->num_rows > 0) {
                            while ($supplier_row = $supplier_result->fetch_assoc()) {
                                $supplier = htmlspecialchars($supplier_row['fornecedor']);
                                $selected = $supplier === $selected_supplier ? 'selected' : '';
                                echo "<option value=\"$supplier\" $selected>$supplier</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>

        <div class="container mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Fornecedor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['produto']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fornecedor']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>Nenhum fornecedor encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
