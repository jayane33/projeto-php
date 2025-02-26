<?php
session_start();

require_once 'conn.php'; // Arquivo de conexão com o banco
require_once 'user.php'; // Classe do usuário


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    echo "$nome";
    echo "$email";

    // Criar a conexão com o banco
    $db = new Database();
    $conn = $db->getConnection();

    // Criar a instância da classe User
    $user = new User($conn);
    $user->nome = $nome;
    $user->email = $email;
    $user->senha = $senha;
    $user->is_admin = false; // Define se é admin ou não
    print_r($user);
    // Verificar se o e-mail já existe
    if ($user->emailExists()) {
        echo "Este e-mail já está cadastrado!";
        exit;
    } else {
        // Tentar cadastrar o usuário
        if ($user->create()) {
            echo "Cadastro realizado com sucesso!";
            header("Location: ../index.html"); // Redirecionar para a página de login
            exit;
        } else {
            echo "Erro ao cadastrar o usuário!";
        }
    }
}
