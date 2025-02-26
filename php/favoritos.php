<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Usuário não logado.";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Conexão com o banco de dados
$conn = new mysqli("seu_servidor", "seu_usuario", "sua_senha", "seu_banco_de_dados");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta os livros favoritos do usuário
$stmt = $conn->prepare("SELECT livros.* FROM livros JOIN favoritos ON livros.id_livro = favoritos.livro_id WHERE favoritos.usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Exibe os livros favoritos
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Título: " . $row['titulo'] . "<br>";
        echo "Autor: " . $row['autor'] . "<br>";
        // Exibir outros dados do livro
    }
} else {
    echo "Nenhum livro favoritado.";
}

$stmt->close();
$conn->close();
?>
