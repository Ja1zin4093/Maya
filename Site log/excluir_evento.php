<?php
session_start();

$servername = "localhost";
$dbname = "pit";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifique se o usuário está logado
if (!isset($_SESSION['log'])) {
    // Redirecione o usuário para a página de login
    header("Location: login.php");
    exit();
}

$user_nome = $_SESSION['log']; // Recupere o nome de usuário da sessão
$eventoId = $_GET['id']; // Obtém o ID do evento da URL

// Consulta SQL para excluir o evento
$sql = "DELETE FROM evento WHERE id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$eventoId);
$stmt->execute();



    // A exclusão foi bem-sucedida, redirecione para a página de eventos novamente
    header("Location: index.php");


$conn->close();
?>

