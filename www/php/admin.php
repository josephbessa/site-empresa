<?php
session_start();
ob_start(); // Habilita o buffer de saída


// Conexão com o banco de dados
$dsn = 'mysql:host=localhost;port=3306;dbname=servicos;charset=utf8';
$username = 'root';
$password = 'Bones27$';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

// Função pr para imprimir variáveis de forma mais legível
function pr($data) {
    echo '<pre>' . print_r($data, true) . '</pre>';
}

// Função para adicionar um novo serviço
function adicionarServico($pdo, $nome, $descricao, $preco) {
    try {
        $stmt = $pdo->prepare('INSERT INTO servicos (nome_servico, descricao, preco) VALUES (?, ?, ?)');
        $stmt->execute([$nome, $descricao, $preco]);
        return true;
    } catch (PDOException $e) {
        // Tratar erro de inserção, se necessário
        return false;
    }
}

// Verificar se o formulário de adição de serviço foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_servico'])) {
    $nome = $_POST['nome_servico'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Adicionar o serviço
    if (adicionarServico($pdo, $nome, $descricao, $preco)) {
        pr("Serviço adicionado com sucesso!");
    } else {
        pr("Erro ao adicionar serviço.");
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_servico'])) {
    // Obter os dados do formulário
    $id = $_POST['edit_id_servico'];
    $novoNome = $_POST['edit_nome_servico'];
    $novaDescricao = $_POST['edit_descricao'];
    $novoPreco = $_POST['edit_preco'];

    // Executar a consulta de atualização no banco de dados
    $stmt = $pdo->prepare('UPDATE servicos SET nome_servico=?, descricao=?, preco=? WHERE id=?');
    $result = $stmt->execute([$novoNome, $novaDescricao, $novoPreco, $id]);

    if ($result) {
        pr("Serviço editado com sucesso!");
    } else {
        pr("Erro ao editar serviço.");
    }

    // Redirecionar ou exibir mensagem de sucesso
    header('Location: admin.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_servico'])) {
    // Obter o ID do serviço a ser excluído
    $id = $_POST['excluir_id_servico'];

    // Executar a consulta de exclusão no banco de dados
    $stmt = $pdo->prepare('DELETE FROM servicos WHERE id=?');
    $stmt->execute([$id]);

    // Redirecionar ou exibir mensagem de sucesso
    header('Location: admin.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Lista de Serviços</h2>
        <!-- Tabela para exibir serviços -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nome do Serviço</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    // Buscar serviços no banco de dados e exibir na tabela
                    $stmt = $pdo->query('SELECT id, nome_servico, descricao, preco FROM servicos');
                    while ($servico = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr id="row_' . $servico['id'] . '">';
                        echo '<td>' . $servico['nome_servico'] . '</td>';
                        echo '<td>' . $servico['descricao'] . '</td>';
                        echo '<td>R$ ' . number_format($servico['preco'], 2, ',', '.') . '</td>';
                        echo '<td>';
                        echo '<button type="button" class="btn btn-danger btn-excluir" data-id="' . $servico['id'] . '">Excluir</button>';
                        echo '<button type="button" class="btn btn-warning btn-editar" data-id="' . $servico['id'] . '">Editar</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>


        </table>
        <!-- Botão para abrir o modal de adicionar serviço -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adicionarServicoModal">
            Adicionar Serviço
        </button>
    </div>

    <div class="modal fade" id="adicionarServicoModal" tabindex="-1" aria-labelledby="adicionarServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adicionarServicoModalLabel">Adicionar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para adicionar serviço -->
                    <form action="admin.php" method="POST">
                        <div class="mb-3">
                            <label for="nome_servico" class="form-label">Nome do Serviço:</label>
                            <input type="text" class="form-control" name="nome_servico" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição:</label>
                            <textarea class="form-control" name="descricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço:</label>
                            <input type="text" class="form-control" name="preco" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="adicionar_servico">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal de edição de serviço -->
    <div class="modal fade" id="editarServicoModal" tabindex="-1" aria-labelledby="editarServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarServicoModalLabel">Editar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para editar serviço -->
                    <form action="admin.php" method="POST">
                        <div class="mb-3">
                            <label for="edit_id_servico" class="form-label">ID do Serviço:</label>
                            <input type="text" class="form-control" id="edit_id_servico" name="edit_id_servico" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nome_servico" class="form-label">Novo Nome do Serviço:</label>
                            <input type="text" class="form-control" id="edit_nome_servico" name="edit_nome_servico" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_descricao" class="form-label">Nova Descrição:</label>
                            <textarea class="form-control" id="edit_descricao" name="edit_descricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_preco" class="form-label">Novo Preço:</label>
                            <input type="text" class="form-control" id="edit_preco" name="edit_preco" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="editar_servico">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de exclusão de serviço -->
    <div class="modal fade" id="excluirServicoModal" tabindex="-1" aria-labelledby="excluirServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="excluirServicoModalLabel">Excluir Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para excluir serviço -->
                    <form id="formExcluirServico" action="admin.php" method="POST">
                        <div class="mb-3">
                            <label for="excluir_id_servico" class="form-label">ID do Serviço a Excluir:</label>
                            <input type="text" class="form-control" id="excluir_id_servico" name="excluir_id_servico" readonly>
                        </div>
                        <p>Tem certeza de que deseja excluir este serviço?</p>
                        <button type="submit" class="btn btn-danger" name="excluir_servico">Confirmar Exclusão</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Inclusão dos scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <script src="../js/edicao.js"></script>            
    

</body>
</html>

