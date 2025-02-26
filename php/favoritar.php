<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Usuário não logado.";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$livro_id = $_POST['livro_id']; // Recebe o ID do livro via POST

require_once 'conn.php'; // Caminho para o arquivo com a classe Database
$db = new Database();
$conn = $db->getConnection();

try {
    // Verifica se o livro já está favoritado
    $stmt = $conn->prepare("SELECT * FROM favoritos WHERE usuario_id = :usuario_id AND livro_id = :livro_id");
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':livro_id', $livro_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Livro já favoritado.";
    } else {
        // Adiciona o livro aos favoritos
        $insertStmt = $conn->prepare("INSERT INTO favoritos (usuario_id, livro_id) VALUES (:usuario_id, :livro_id)");
        $insertStmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':livro_id', $livro_id, PDO::PARAM_INT);

        if ($insertStmt->execute()) {
            echo "Livro favoritado com sucesso!";
        } else {
            echo "Erro ao favoritar o livro.";
        }
    }
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
