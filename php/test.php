<?php
require_once 'conn.php'; // Certifique-se de que o caminho está correto

// Criar uma instância da classe Database
$database = new Database();
$conn = $database->getConnection(); // Conectar ao banco de dados

if ($conn) {
    echo "Conexão bem-sucedida!";
} else {
    echo "Erro ao conectar ao banco de dados.";
}
?>

