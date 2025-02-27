<?php
// salvar_comentario.php - Handles the form submission to create a new comment
// This file processes the POST data from your comment form
session_start();

require_once 'conn.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);

    // Additional validation
    if (empty($titulo) || empty($comentario) || strlen($comentario) > 500) {
        // Redirect back with error message
        header("Location: ../index.php?erro=dados_invalidos");
        exit;
    }

    try {
        // Connect to database
        $db = new Database();
        $conn = $db->getConnection();

        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO comentarios (titulo_livro, comentario) VALUES (:titulo, :comentario)");

        // Bind parameters
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':comentario', $comentario);

        // Execute query
        $stmt->execute();

        // Redirect with success message
        header("Location: /doceleitura/index/index.html");
        exit;
    } catch (PDOException $e) {
        // Log error and redirect with error message
        error_log("Erro ao salvar comentário: " . $e->getMessage());
        header("Location: ../index.php?erro=falha_ao_salvar");
        exit;
    }
} else {
    // If not a POST request, redirect to the homepage
    header("Location: ../index.php");
    exit;
}
