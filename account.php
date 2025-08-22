<?php
session_start(); 


$mensagem_rm = "";
$mensagem_senha = "";
$mensagem_email = "";
$mensagem_email_existente = "";
$mensagem_rm_existente = "";
$chave = substr(uniqid(rand()), 0, 5);

if (isset($_POST['submit'])) {
    include_once('config.php');

    $rm = trim($_POST['RM']);
    $senha = trim($_POST['senha']);
    $email = trim($_POST['email']);


    if (empty($rm)) {
        $mensagem_rm = "Preencha o RM.";
    }
    if (empty($senha)) {
        $mensagem_senha = "Preencha a senha.";
    }
    if (empty($email)) {
        $mensagem_email = "Preencha o e-mail.";
    }

    if (empty($mensagem_rm) && empty($mensagem_senha) && empty($mensagem_email)) {
        $stmt = $conexao->prepare("SELECT * FROM cadastro WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result_email = $stmt->get_result();

        if ($result_email->num_rows > 0) {
            $mensagem_email_existente = "Esse email já está cadastrado.";
        }

        $stmt = $conexao->prepare("SELECT * FROM cadastro WHERE rm = ?");
        $stmt->bind_param("s", $rm);
        $stmt->execute();
        $result_rm = $stmt->get_result();

        if ($result_rm->num_rows > 0) {
            $mensagem_rm_existente = "Esse RM já está cadastrado.";
        }


        if (empty($mensagem_email_existente) && empty($mensagem_rm_existente)) {
            $stmt = $conexao->prepare("INSERT INTO cadastro (rm, senha, email, codigoacessoconta) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $rm, $senha, $email, $chave);
            if ($stmt->execute()) {
                $_SESSION['email'] = $email;
                header("Location: login.php");
                exit; 
            } else {
                $mensagem_senha = "Erro ao cadastrar: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style_login.css">
    <script>
        function clearError(field) {
            document.getElementById(field).nextElementSibling.innerHTML = "";
        }
    </script>
</head>
<body class="body">

<div class="container" style="max-width: 800px;">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-7">
            <form name="cadastroForm" action="" method="POST" style="background-color: #ffffff; padding: 40px; border-radius: 9px;">
                <img src="img/new.png" class="img">
                
                <?php if (!empty($mensagem_email_existente)): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $mensagem_email_existente; ?></div>
                <?php endif; ?>

                <?php if (!empty($mensagem_rm_existente)): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $mensagem_rm_existente; ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <div class="col-md-10">
                        <label class="visually-hidden" for="autoSizingInputGroup"></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="fa-solid fa-at"></i></div>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" style="font-size: 20px;" onfocus="clearError('email')">
                        </div>
                        <?php if (!empty($mensagem_email)): ?>
                            <div class="text-danger"><?php echo $mensagem_email; ?></div>
                        <?php endif; ?>
                    </div>
                    <br>
                    
                    <div class="col-md-10">
                        <label class="visually-hidden" for="autoSizingInputGroup"></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                            <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" style="font-size: 20px;" onfocus="clearError('senha')">
                        </div>
                        <!-- Exibição de Mensagem de Erro para Senha -->
                        <?php if (!empty($mensagem_senha)): ?>
                            <div class="text-danger"><?php echo $mensagem_senha; ?></div>
                        <?php endif; ?>
                    </div>
                    <br>
                    
                    <div class="col-md-4">
                        <label class="visually-hidden" for="autoSizingInputGroup"></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                            <input type="text" class="form-control" name="RM" id="RM" placeholder="RM" style="font-size: 20px;" onfocus="clearError('RM')">
                        </div>
                        <?php if (!empty($mensagem_rm)): ?>
                            <div class="text-danger"><?php echo $mensagem_rm; ?></div>
                        <?php endif; ?>
                    </div>
                    <br>
                    
                    <button type="submit" name="submit" id="submit" class="btn btn-primary btn-lg" style="font-size: 18px;">Criar Conta</button>
                    <a href="login.php" class="btn btn-danger btn-lg" style="font-size: 18px;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
