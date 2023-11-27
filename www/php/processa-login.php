<?php
session_start();
ob_start(); // Habilita o buffer de saída

// Conexão com o banco de dados
$dsn = 'mysql:host=localhost;port=3306;dbname=servicos;charset=utf8';
$username = 'root';
$password = 'senha-do-banco';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

function verificarCredenciais($pdo, $email, $senha) {
    try {
        $stmt = $pdo->prepare('SELECT email, senha FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $senhaBanco = $usuario['senha'];

            if ($senha === $senhaBanco) {
                return $usuario;
            }
        }
    } catch (PDOException $e) {
        // Tratar erro de consulta SQL, se necessário
    }

    return null;
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = verificarCredenciais($pdo, $email, $senha);

    if ($usuario) {
        // Credenciais válidas, redirecionar para admin.php
        header('Location: admin.php');
        exit();
    } else {
        // Credenciais inválidas, redirecionar de volta para a página de login com mensagem de erro
        $_SESSION['erro_login'] = true;
        header('Location: login.php');
        exit();
    }
} else {
    // Se alguém acessou este script sem enviar um formulário, redirecionar de volta para a página de login
    header('Location: login.php');
    exit();
}

ob_end_flush(); // Descarta o conteúdo do buffer de saída e encerra o buffer
?>
