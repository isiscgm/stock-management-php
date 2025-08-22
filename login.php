<?php
session_start();

$mensagem_rm = "";
$mensagem_senha = "";

if (isset($_POST['submit'])) {
    include_once('config.php');

    $rm = trim($_POST['RM']);
    $senha = trim($_POST['senha']);

    if (empty($rm)) {
        $mensagem_rm = "Preencha o RM.";
    }
    if (empty($senha)) {
        $mensagem_senha = "Preencha a senha.";
    }

    if (empty($mensagem_rm) && empty($mensagem_senha)) {
        $result = mysqli_query($conexao, "SELECT * FROM cadastro WHERE rm = '$rm' AND senha = '$senha'");
        
        if (mysqli_num_rows($result) === 0) {
            $mensagem_rm = "RM ou senha incorretos.";
        } else {
            $usuario = mysqli_fetch_assoc($result);
            $_SESSION['rm'] = $usuario['RM'];
            $_SESSION['email'] = $usuario['email'];
            header("Location: home.php");
            exit;
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
