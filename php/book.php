<?php
require_once 'conn.php';  // Incluindo a classe de conexão

class Book
{
    private $conn;
    private $table_name = 'livros';

    public $id_livro;
    public $titulo;
    public $autor;
    public $genero_id;

    // Construtor recebe a conexão do banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar um novo livro
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "SET titulo = :titulo, autor = :autor, genero_id = :genero_id";

        // Preparando a consulta
        $stmt = $this->conn->prepare($query);

        // Bind dos dados
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':autor', $this->autor);
        $stmt->bindParam(':genero_id', $this->genero_id);

        // Executando
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obter todos os livros
    public function getAll()
    {
        $query = "SELECT id_livro, titulo, autor, genero_id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
