<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo_inserido = $_POST['codigo'] ?? '';
    $codigo_correto = $_SESSION['codigo_correto'] ?? '';

    if ($codigo_inserido === $codigo_correto) {
        header('Location: redefinir_senha.php');
        exit;
    } else {
        $mensagem_codigo = "Código inválido. Tente novamente.";
    }
}

if (!isset($_SESSION['codigo_correto'])) {
    header('Location: recuperar_senha.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Código - Centro de Paula de Souza</title>
    <link rel="stylesheet" href="http://localhost/TCCNOVO/css/style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">
    <div class="container" style="max-width: 600px;">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-10">
                <form action="" method="POST" style="background-color: #ffffff; padding: 40px; border-radius: 9px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                    <h3 class="text-center mb-4">Validar Código</h3>

                    <!-- Mensagem de Erro para Código -->
                    <?php if (!empty($mensagem_codigo)): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $mensagem_codigo; ?></div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="visually-hidden" for="codigo">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Insira o código de acesso" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" style="font-size: 18px;">Validar Código</button>
                    <br><br>
                    <p class="text-center"><a href="recuperar_senha.php" style="color: blue; text-decoration: none;">Voltar</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
