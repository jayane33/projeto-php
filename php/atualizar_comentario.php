<?php
require_once 'conn.php';

if (!empty($_POST['id']) && !empty($_POST['comentario'])) {
    $id = $_POST['id'];
    $comentario = trim($_POST['comentario']);

    $database = new Database();
    $db = $database->getConnection();

    $sqlSelect = "SELECT * FROM comentarios WHERE id = :id";
    $stmt = $db->prepare($sqlSelect);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $sqlUpdate = "UPDATE comentarios SET comentario = :comentario WHERE id = :id";
        $stmtUpdate = $db->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':comentario', $comentario);
        $stmtUpdate->bindParam(':id', $id);

        if ($stmtUpdate->execute()) {
            echo "Sucesso";
        } else {
            echo "Erro ao atualizar o comentário";
        }
    } else {
        echo "Comentário não encontrado";
    }
} else {
    echo "Dados inválidos";
}
?>
