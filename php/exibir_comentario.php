<?php
require_once 'conn.php';
require_once 'comentario.php';

$database = new Database();
$db = $database->getConnection();

$comentario = new Comentario($db);
$titulo_livro = isset($_GET['titulo_livro']) ? $_GET['titulo_livro'] : "";
$comentarios = $comentario->getComentarios($titulo_livro);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários dos Livros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .navbar {
            background-color: #ff4081 !important;
        }
        .navbar a {
            color: white;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            background-color: #ff4081;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 4px;
        }
        .editable {
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }
        .editable:focus {
            border-color: #ff4081;
            outline: none;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .btn-edit, .btn-update, .btn-delete {
            color: white;
            font-weight: bold;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-edit { background-color: #ff80ab; }
        .btn-edit:hover { background-color: #ff4081; }
        .btn-update { background-color: #4CAF50; display: none; }
        .btn-update:hover { background-color: #388E3C; }
        .btn-delete { background-color: #f44336; }
        .btn-delete:hover { background-color: #d32f2f; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-dark">
            <a class="navbar-brand" href="#">Gerenciador de Comentários</a>
            <a href="../index.html" class="btn btn-back">Voltar</a>
        </nav>
        <br>
        <h1>Comentários sobre Livros</h1>
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="titulo_livro" class="form-control" placeholder="Filtrar por título do livro" value="<?php echo htmlspecialchars($titulo_livro); ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-filter">Filtrar</button>
                </div>
            </div>
        </form>
        <div class="mt-4">
            <?php if (empty($comentarios)): ?>
                <p class="alert alert-warning">Nenhum comentário ainda.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título do Livro</th>
                            <th>Comentário</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comentarios as $comentario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($comentario['id']); ?></td>
                                <td><?php echo htmlspecialchars($comentario['titulo_livro']); ?></td>
                                <td>
                                    <input type="text" class="editable" value="<?php echo htmlspecialchars($comentario['comentario']); ?>" data-id="<?php echo $comentario['id']; ?>" disabled>
                                </td>
                                <td><?php echo $comentario['data_criacao']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn-edit" onclick="editarComentario(this)">Editar</button>
                                        <button class="btn-update" onclick="atualizarComentario(this)">Atualizar</button>
                                        <a href="excluir_comentario.php?id=<?php echo $comentario['id']; ?>" class="btn-delete">Excluir</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function editarComentario(botao) {
            let linha = botao.closest('tr');
            let input = linha.querySelector('.editable');
            let btnUpdate = linha.querySelector('.btn-update');
            
            input.disabled = false;
            input.focus();
            btnUpdate.style.display = 'inline-block';
        }

        function atualizarComentario(botao) {
            let linha = botao.closest('tr');
            let input = linha.querySelector('.editable');
            let id = input.getAttribute('data-id');
            let novoComentario = input.value;
            
            fetch('atualizar_comentario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&comentario=${encodeURIComponent(novoComentario)}`
            }).then(response => response.text())
              .then(data => {
                  alert('Comentário atualizado!');
                  input.disabled = true;
                  botao.style.display = 'none';
              }).catch(error => alert('Erro ao atualizar comentário'));
        }
    </script>
</body>
</html>

