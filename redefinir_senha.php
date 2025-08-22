<?php
session_start(); // Inicia a sessão

include_once('config.php');

// if (isset($_SESSION['email'])) {
//     echo "<div class='alert alert-success'>Email na sessão: " . $_SESSION['email'] . "</div>";
// } else {
//     echo "<div class='alert alert-danger'>Email não encontrado na sessão.</div>";
// }

// Verifica se o código foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    $mensagem = ''; // Variável para armazenar mensagens de erro

    // Verifica se as senhas são iguais
    if ($nova_senha === $confirmar_senha) {
        // Recupera o email da sessão, se disponível
        $email = $_SESSION['email'] ?? '';

        // Verifica se o email está definido na sessão
        if (!empty($email)) {
            // Prepara a consulta SQL para atualizar a senha sem hash
            $sql = "UPDATE cadastro SET senha='$nova_senha' WHERE email='$email'";

            // Executa a consulta SQL
            if (mysqli_query($conexao, $sql)) {
                echo "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
                // Limpa apenas o código correto da sessão
                unset($_SESSION['codigo_correto']);
                // Redireciona para a página de login
                header('Location: login.php');
                exit;
            } else {
                $mensagem = "Erro ao atualizar a senha: " . mysqli_error($conexao);
            }            
        } else {
            $mensagem = "Email não encontrado na sessão.";
        }
    } else {
        $mensagem = "As senhas não coincidem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Centro de Paula de Souza</title>
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">
    <div class="container" style="max-width: 600px;">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-10">
                <form action="" method="POST" style="background-color: #ffffff; padding: 40px; border-radius: 9px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                    <h3 class="text-center mb-4">Redefinir Senha</h3>

                    <!-- Mensagem de Erro -->
                    <?php if (!empty($mensagem)): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $mensagem; ?></div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Insira a nova senha" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_senha">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme a nova senha" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" style="font-size: 18px;">Redefinir Senha</button>
                    <br><br>
                    <p class="text-center"><a href="login.php" style="color: blue; text-decoration: none;">Voltar para o Login</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
