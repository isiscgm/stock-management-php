<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pantry";

session_start(); 

if (!isset($_SESSION['rm']) || !isset($_SESSION['email'])) {
    die("Acesso negado. Você precisa estar logado.");
}

$rm_responsavel = $_SESSION['rm'];
$email_responsavel = $_SESSION['email'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, produto, quantidade FROM produtos WHERE quantidade > 0"; 
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $motivo = $_POST['motivo'];

    $sql_check = "SELECT quantidade FROM produtos WHERE id = $produto_id";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $quantidade_disponivel = $row['quantidade'];

        if ($quantidade <= $quantidade_disponivel) {
            $sql_insert = "INSERT INTO historico_baixas (produto_id, quantidade, motivo, rm_responsavel, email_responsavel, data_baixa)
                           VALUES ($produto_id, $quantidade, '$motivo', '$rm_responsavel', '$email_responsavel', NOW())";
            if ($conn->query($sql_insert) === TRUE) {

$sql_update = "UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id = $produto_id";
if ($conn->query($sql_update) === TRUE) {

    $sql_check_quantity = "SELECT quantidade FROM produtos WHERE id = $produto_id";
    $result_check = $conn->query($sql_check_quantity);
    $row_check = $result_check->fetch_assoc();

    if ($row_check['quantidade'] == 0) {
        $sql_delete = "DELETE FROM produtos WHERE id = $produto_id";
        if ($conn->query($sql_delete) === TRUE) {
            echo "<script>alert('Produto removido do estoque, pois sua quantidade chegou a 0.');</script>";
        } else {
            echo "<script>alert('Erro ao remover produto do estoque.');</script>";
        }
    }

    echo "<script>alert('Baixa registrada com sucesso!');</script>";
    echo "<script>window.location.href = 'baixa.php';</script>"; 
    exit(); 
} else {
    echo "<script>alert('Erro ao atualizar a quantidade do produto.');</script>";
}

            } else {
                echo "<script>alert('Erro ao registrar a baixa.');</script>";
            }
        } else {
            echo "<script>alert('Quantidade solicitada é maior do que a disponível em estoque!');</script>";
        }
    } else {
        echo "<script>alert('Produto não encontrado.');</script>";
    }
}



?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Baixa</title>
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style.css">
    <script src="http://localhost/TCCNOVO/script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mlO17D9ThRzHcE3zwBndzD1B5K8hxz8YUJQ3MyN52zsn8S7HQo7rdtrjlNfY4M7O" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para exibir o motivo em um modal
        function mostrarMotivo(motivo) {
            document.getElementById("motivoModalBody").innerText = motivo;
            var motivoModal = new bootstrap.Modal(document.getElementById('motivoModal'));
            motivoModal.show();
        }
    </script>
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
            <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-dark-grey w3-button w3-hover-red">Geral</a>
            <a href="estoque.php" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Estoque</a>
            <a href="relatorios.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Relatórios</a>
            <a href="fornecedores.php" onclick="w3_close()" class="w3-bar-item w3-gray w3-button w3-hover-red">Fornecedores</a>
            <a href="servicos.php" onclick="w3_close()" class="w3-bar-item w3-dark-gray w3-button w3-hover-red">Serviços</a>
            <a href="baixa.php" class="w3-bar-item w3-red w3-button w3-hover-red">Registro de Saída</a>
        </div>
        <div class="w3-container" style="text-align: left; margin-top: 220px;">
        </div>
        <a href="logout.php" style="position: fixed; bottom: 20px; left: 20px; font-size: 18px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: black; padding: 10px 15px;">
            <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Sair
        </a>
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Página de Baixa -->
    <div class="w3-main" style="margin-left:340px;margin-right:40px;">
        <!-- Header -->
        <div class="w3-container" style="margin-top:80px" id="showcase">
            <h1 class="w3-jumbo"><b>Registro de Baixa</b></h1>
            <hr style="width:50px;border:5px solid black" class="w3-round">
        </div>

        <!-- Formulário de Baixa -->
        <div class="container mt-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="produto" class="form-label">Produto</label>
                    <select class="form-select" id="produto" name="produto_id" required>
                        <option value="" disabled selected>Selecione o produto</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['produto']) . " - " . $row['quantidade'] . " disponíveis</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Nenhum produto disponível</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo</label>
                    <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Registrar Baixa</button>
            </form>
        </div>
        <div class="container mt-5">
            <h2>Histórico de Baixas</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">RM Responsável</th>
                        <th scope="col">Email Responsável</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Motivo</th> <!-- Coluna de motivo -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_histórico = "SELECT h.rm_responsavel, h.email_responsavel, h.data_baixa, p.produto, h.quantidade, h.motivo
                                      FROM historico_baixas h
                                      JOIN produtos p ON h.produto_id = p.id
                                      ORDER BY h.data_baixa DESC";
                    $result_histórico = $conn->query($sql_histórico);

                    if ($result_histórico->num_rows > 0) {
                        while ($row = $result_histórico->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['rm_responsavel']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email_responsavel']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['data_baixa']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['produto']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                            echo "<td><button class='btn btn-secondary' onclick='mostrarMotivo(\"" . addslashes(htmlspecialchars($row['motivo'])) . "\")'>+</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhuma baixa registrada</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal de Motivo -->
    <div class="modal fade" id="motivoModal" tabindex="-1" aria-labelledby="motivoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="motivoModalLabel">Motivo da Baixa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="motivoModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
