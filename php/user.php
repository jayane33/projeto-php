<?php
require_once 'conn.php'; 

class User
{
    private $conn;
    private $table_name = 'usuarios';

    public $id_usuario;
    public $nome;
    public $email;
    public $senha;

    // Construtor recebe a conexão do banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {

    $query = "INSERT INTO " . $this->table_name . "(nome, email, senha) values (?, ?, ?)";


        $stmt = $this->conn->prepare($query);

        // Bind dos dados
        $stmt->bindParam(1, $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->email, PDO::PARAM_STR);
        $stmt->bindParam(3, $this->senha, PDO::PARAM_STR);

        // Executando
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar se o e-mail já está registrado
    public function emailExists()
    {
        $query = "SELECT id_usuario, nome, email, senha
                  FROM " . $this->table_name . "
                  WHERE email = :email";

        // Preparando a consulta
        $stmt = $this->conn->prepare($query);

        // Bind dos dados
        $stmt->bindParam(':email', $this->email);

        // Executando
        $stmt->execute();

        // Se o e-mail existe, retorna true
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_usuario = $row['id_usuario'];
            $this->nome = $row['nome'];
            $this->email = $row['email'];
            $this->senha = $row['senha'];
            return true;
        }

        return false;
    }
}
