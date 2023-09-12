<?php
// Configurações do banco de dados
$servername = "localhost";  // Nome do servidor
$dbname = "pit"; // Nome do banco de dado
$username ="root"; // Nome de usuário do banco de dados
$password = "";   // Senha do banco de dados

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $email = $_POST["email"];
    $username = $_POST["username"];
    $newPassword = $_POST["password"];

    // Verifica se o usuário existe no banco de dados
    $sql = "SELECT * FROM coisa WHERE email = '$email' AND userName = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Atualiza a senha do usuário
        $sql = "UPDATE coisa SET senha = '$newPassword' WHERE userName = '$username'";
        if ($conn->query($sql) === TRUE) {
            echo "<br>Senha redefinida com sucesso!</br>";
        } else {
          echo "<br>Erro ao redefinir a senha: </br>" . $conn->error;
        }
    } else {
      echo "<br>Usuário não encontrado.</br>";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="cadastro.css" />
</head>
<body>
    <div class="login-page">
        <div class="form">
            <h1> Redefinir senha</h1>
          
          <form class="login-form" method="POST">
          <input type="email"  placeholder="email" name="email" required/>
    <input type="text"  placeholder="User" name="username" required/>
    <input type="password" placeholder="Senha" name="password" required/>
    
    <button type="submit" name ="aaa">Redefinir</button>
    
    
</form>
        </div>
      </div>
    </div>
</body>