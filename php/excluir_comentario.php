<?php
require_once 'conn.php'; 

if (!empty($_GET['id'])) { 
    $id_comentario = intval($_GET['id']); 

    try {

        $database = new Database();
        $conn = $database->getConnection();


        $stmt = $conn->prepare("SELECT * FROM comentarios WHERE id = :id");
        $stmt->bindParam(':id', $id_comentario, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { // Se o comentário existir
            // Excluir o comentário
            $stmtDelete = $conn->prepare("DELETE FROM comentarios WHERE id = :id");
            $stmtDelete->bindParam(':id', $id_comentario, PDO::PARAM_INT);
            $deleted = $stmtDelete->execute();

            if ($deleted) {
                echo "Comentário excluído com sucesso!";
            } else {
                echo "Erro ao excluir comentário!";
            }


            header("Location: exibir_comentario.php?mensagem=excluido_com_sucesso");
            exit;
        } else {
            echo "Comentário não encontrado!";
            header("Location: exibir_comentario.php?erro=comentario_nao_encontrado");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erro ao excluir comentário: " . $e->getMessage());
        header("Location: exibir_comentario.php?erro=falha_ao_excluir");
        exit;
    }
} else {
    header("Location: exibir_comentario.php");
    exit;
}