<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <div class="container">
            <div class="row justify-content-center login-container" style="margin-top: 100px;">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Login</h2>

                            <!-- Exibir mensagem de erro, se houver -->
                            <?php
                                if (isset($_SESSION['erro_login']) && $_SESSION['erro_login'] === true) {
                                    echo '<div class="alert alert-danger" role="alert">Credenciais inválidas. Tente novamente.</div>';
                                    unset($_SESSION['erro_login']); // Limpa a variável de sessão após exibir a mensagem
                                }
                            ?>

                            <!-- Formulário de Login -->
                            <form action="admin.php" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="senha" class="form-label">Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                                <div class="d-grid">
                                    <button id="btnEntrar" type="submit" class="btn btn-primary">Entrar</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inclusão dos scripts -->
        <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
