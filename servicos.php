<?php
// Conexão com o banco de dados
$servername = "Localhost";
$username = "root";
$password = "";
$dbname = "pantry";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT RM, email FROM cadastro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pantry Escolar</title>
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style.css">
    <script src="http://localhost/TCCNOVO/script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mlO17D9ThRzHcE3zwBndzD1B5K8hxz8YUJQ3MyN52zsn8S7HQo7rdtrjlNfY4M7O" crossorigin="anonymous"></script>
</head>
<body>

     <!-- Botão de menu sanduíche (hambúrguer) -->
     <span class="hamburger" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </span>

    <!-- navbar-menu -->
    <nav class="w3-sidebar w3-collapse w3-top w3-large" style="z-index:3;width:300px;font-weight:bold;background-color:#eeeeee;color:#fff;" id="mySidebar">
        <br>
        <div class="w3-container">
            <h3 class="w3-padding-64" style="font-size:37px;"><img class="logo" style="width: 170px;" src="img/new.png"></h3>
        </div>
        <div class="w3-bar-block" style="font-size:23px;">
            <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-red w3-button w3-hover-red">Geral</a>
            <a href="estoque.php" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Estoque</a>
            <a href="relatorios.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Relatórios</a>
            <a href="fornecedores.php" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Fornecedores</a>
            <a href="servicos.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Serviços</a>
            <a href="baixa.php" class="w3-bar-item w3-gray w3-button w3-hover-red">Registro de Saída</a>
        </div>
        <div class="w3-container" style="text-align: left; margin-top: 220px;">
</div>
<a href="logout.php" style="position: fixed; bottom: 20px; left: 20px; font-size: 18px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: black; padding: 10px 15px;">
    <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Sair
</a>


    </nav>
    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:340px;margin-right:40px;">
        <!-- Header -->
        <div class="w3-container" style="margin-top:80px" id="showcase">
            <h1 class="w3-jumbo"><b>Usuários Cadastrados</b></h1>
            <hr style="width:50px;border:5px solid black" class="w3-round">
        </div>

    <?php
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">';
        echo '<thead class="table-light"><tr><th>RM</th><th>Email</th></tr></thead><tbody>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr><td>' . htmlspecialchars($row["RM"]) . '</td><td>' . htmlspecialchars($row["email"]) . '</td></tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo "<div class='alert alert-warning'>Nenhum usuário encontrado.</div>";
    }
    ?>
</div>


</body>
</html>
