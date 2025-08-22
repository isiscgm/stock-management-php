<?php
include "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

$email = $_POST['email'] ?? ''; 
$mensagem_email = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $sql = "SELECT email, codigoacessoconta FROM cadastro WHERE email='$email'";
    $query = mysqli_query($conexao, $sql) or die($conexao->error);
    $reg = $query->fetch_object();

    if (!$reg) {
        $mensagem_email = "Email não encontrado."; 
    } else {
        $email = $reg->email;
        $codigo = $reg->codigoacessoconta;
        
        $_SESSION['codigo_correto'] = $codigo; 

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true; 
            $mail->Username = 'pantryescolar@gmail.com';
            $mail->Password = 'pmqo pjni cneu zjjs';
            $mail->SMTPSecure = 'tls'; 
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;


            $mail->setFrom('pantryescolar@gmail.com', 'Pantry');
            $mail->addAddress($email);
            $mail->Subject = 'Redefinir sua senha Pantry';
            $mail->Body = 'Seu código de acesso é: ' . $codigo . '. Por favor, use este código para redefinir sua senha.';
            
            $mail->send();
            header('Location: validar_codigo.php');
            exit; 
        } catch (Exception $e) {
            echo "A mensagem não pôde ser enviada. Erro: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Centro de Paula de Souza</title>
    <script src="https://kit.fontawesome.com/1584cc6a34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">
    <div class="container" style="max-width: 600px;">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-10">
                <form action="" method="POST" style="background-color: #ffffff; padding: 40px; border-radius: 9px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                    <img src="img/new.png" class="img mb-4" alt="Logo" style="width: 150px;">
                    <h3 class="text-center mb-4">Recuperar Senha</h3>

                    <!-- Exibição de Mensagem de Erro para E-mail -->
                    <?php if (!empty($mensagem_email)): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $mensagem_email; ?></div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label class="visually-hidden" for="email">E-mail</label>
                        <div class="input-group mb-3">
                            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" style="font-size: 20px;" required onfocus="clearError('email')">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100" style="font-size: 18px;">Enviar Instruções</button>
                    <br><br>
                    <p class="text-center"><a href="login.php" style="color: blue; text-decoration: none;">Voltar para o Login</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function clearError(field) {
            document.getElementById(field).nextElementSibling.innerHTML = "";
        }
    </script>
</body>
</html>
