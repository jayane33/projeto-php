<?php
class Comentario {
    private $conn;
    private $table_name = 'comentarios';

    public $id;
    public $titulo_livro;
    public $comentario;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getComentarios($titulo_livro) { 
        try {
            $query = "SELECT id, titulo_livro, comentario, data_criacao FROM " . $this->table_name . " WHERE titulo_livro = ? ORDER BY data_criacao DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $titulo_livro, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar comentários: " . $e->getMessage();
            return false;
        }
    }
}
?>