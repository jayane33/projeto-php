<?php
// Iniciar a sessão
session_start();

// Incluir a classe de conexão com o banco e a classe de usuário
require_once 'user.php';
require_once 'conn.php';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter o e-mail e a senha informados no formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Criar a conexão com o banco
    $db = new Database();
    $conn = $db->getConnection();

    // Criar a instância da classe User
    $user = new User($conn);

    // Atribuir o e-mail recebido ao objeto
    $user->email = $email;

    // Verificar se o usuário existe
    if ($user->emailExists()) {
        // Verificar se a senha informada é válida
        if ($senha == $user->senha) {
            // Se a senha estiver correta, iniciar a sessão
            $_SESSION['user_id'] = $user->id_usuario;  // Armazenar o ID do usuário na sessão
            $_SESSION['user_nome'] = $user->nome;      // Armazenar o nome do usuário
            $_SESSION['user_senha'] = $user->senha;    // Armazenar o senha do usuário
            $_SESSION['user_email'] = $user->email;    // Armazenar o e-mail do usuário
            $_SESSION['is_admin'] = false;   // Armazenar se o usuário é admin

            // Redirecionar para a página principal ou área do usuário
            header("Location: ../index.html");
            exit;
        } else {
            // Se a senha estiver incorreta
            header("Location: /doceleitura/index/login.html");
        }
    } else {
        // Se o e-mail não existir no banco de dados
        echo "Usuário não encontrado.";
    }
}
