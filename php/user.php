<?php
require_once 'conn.php';  // Incluindo a classe de conexão

class User
{
    private $conn;
    private $table_name = 'usuarios';

    public $id_usuario;
    public $nome;
    public $email;
    public $senha;
    public $tipo_usuario;
    public $is_admin = false;

    // Construtor recebe a conexão do banco de dados
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar um novo usuário
    public function create()
    {
        // $query = "INSERT INTO " . $this->table_name . "
        //           SET nome = :nome, email = :email, senha = :senha, is_admin = :is_admin";
$query = "INSERT INTO " . $this->table_name . "(nome, email, senha, is_admin) values (?, ?, ?, ?)";


// Preparando a consulta
        $stmt = $this->conn->prepare($query);

        // Bind dos dados
        $stmt->bindParam(1, $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->email, PDO::PARAM_STR);
        $stmt->bindParam(3, $this->senha, PDO::PARAM_STR);
        $stmt->bindParam(4, $this->is_admin, PDO::PARAM_BOOL);

        // Executando
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar se o e-mail já está registrado
    public function emailExists()
    {
        $query = "SELECT id_usuario, nome, email, senha, is_admin
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
            $this->is_admin = $row['is_admin'];
            return true;
        }

        return false;
    }
}
