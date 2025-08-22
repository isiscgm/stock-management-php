<?php
session_start(); // Inicia a sessão

// Inicializa as mensagens de erro
$mensagem_rm = "";
$mensagem_senha = "";

// Verifica se o botão de envio do formulário foi clicado
if (isset($_POST['submit'])) {
    include_once('config.php'); // Inclui a configuração para conectar ao banco

    // Captura as entradas do formulário
    $rm = trim($_POST['RM']);   // Obtém o RM digitado
    $senha = trim($_POST['senha']); // Obtém a senha digitada

    // Verifica se algum campo está vazio
    if (empty($rm)) {
        $mensagem_rm = "Preencha o RM.";
    }
    if (empty($senha)) {
        $mensagem_senha = "Preencha a senha.";
    }

    // Se todos os campos estiverem preenchidos, tenta fazer o login
    if (empty($mensagem_rm) && empty($mensagem_senha)) {
        // Consulta ao banco de dados para verificar RM e senha
        $result = mysqli_query($conexao, "SELECT * FROM cadastro WHERE rm = '$rm' AND senha = '$senha'");
        
        if (mysqli_num_rows($result) === 0) {
            $mensagem_rm = "RM ou senha incorretos."; // Mensagem de erro se não encontrar correspondência
        } else {
            // Login bem-sucedido, armazena o RM e o email na sessão
            $usuario = mysqli_fetch_assoc($result);
            $_SESSION['rm'] = $usuario['RM']; // Armazena o RM na sessão
            $_SESSION['email'] = $usuario['email']; // Armazena o email na sessão, se necessário

            // Redireciona para a página inicial (estoque.php ou home.php)
            header("Location: home.php"); // Altere para a página desejada
            exit; // Certifique-se de que o script pare após o redirecionamento
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Paula de Souza</title>
    <link rel="stylesheet" href="style.css"> 
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="body">
    <div class="container" style="max-width: 800px;">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-7">
                <form action="" method="POST" style="background-color: #ffffff; padding: 40px; border-radius: 9px;">
                    <img src="img/new.png" class="img">
                    <div class="form-group">
                        <div class="col-auto">
                            <label class="visually-hidden" for="RM">RM</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-circle-user"></i></div>
                                <input type="text" class="form-control" id="RM" name="RM" placeholder="RM" style="font-size: 20px;">
                            </div>
                            <!-- Exibição de Mensagem de Erro para RM -->
                            <?php if (!empty($mensagem_rm)): ?>
                                <div class="text-danger"><?php echo $mensagem_rm; ?></div>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="col-auto">
                            <label class="visually-hidden" for="senha">Senha</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" style="font-size: 20px;">
                                <div class="input-group-append">
                                    <button class="btn btn-lg" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="eyeIcon" style="font-size: 24px;"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Exibição de Mensagem de Erro para Senha -->
                            <?php if (!empty($mensagem_senha)): ?>
                                <div class="text-danger"><?php echo $mensagem_senha; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="p-1">
                            <a href="recuperar_senha.php" class="text-decoration-none">Esqueceu sua senha?</a>
                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary btn-lg" style="font-size: 18px;">Entrar</button>
                        <a href="account.php" class="btn btn-secondary btn-lg" style="font-size: 18px;">Criar Conta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const senhaInput = document.getElementById('senha');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordButton.addEventListener('click', () => {
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                senhaInput.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        });
    </script>
</body>
</html>
