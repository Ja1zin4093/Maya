<?php
// Configurações do banco de dados
$servername = "localhost";
$dbname = "pit";
$username = "root";
$password = "";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se os campos de nome de usuário e senha foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $CNPJ = $_POST["CNPJ"];

  // Use declarações preparadas para evitar injeção de SQL
  $stmt = $conn->prepare("SELECT * FROM empresa WHERE Nome = ? AND senha = ? AND cnpj = ?");
  $stmt->bind_param("sss", $username, $password, $CNPJ);
  $stmt->execute();

  // Obtenha o resultado da consulta
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    // Autenticação bem-sucedida
    echo "<br>Login bem-sucedido!</br>";
    header("Location: https://youtu.be/dQw4w9WgXcQ");
    exit();
  } else {
    // Autenticação falhou
    echo "<br>Nome de usuário, senha ou CPF incorretos.</br>";
  }

  $stmt->close();
}

$conn->close();
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
            <h1> login</h1>
          
          <form class="login-form" method="POST">
          <input type="text"  placeholder="CNPJ" name="CNPJ" required/>
    <input type="text"  placeholder="User" name="username" required/>
    <input type="password" placeholder="Senha" name="password" required/>
    
    <button type="submit" name ="aaa">login</button>
    <p class="message">Esqueceu a senha? <a href="../REdsen/index.php">Redefinir senha</a></p>
    
</form>
        </div>
      </div>
    </div>
</body>
<script>
var usernameInput = document.querySelector('input[name="username"]');
var cnpjInput = document.querySelector('input[name="CNPJ"]');
var passwordInput = document.querySelector('input[name="password"]');

// Add event listeners for input changes
usernameInput.addEventListener('input', function() {
        if (usernameInput.value.length > 200) {
            usernameInput.value = usernameInput.value.slice(0, 200);
        }
    });

    passwordInput.addEventListener('input', function() {
        if (passwordInput.value.length > 30) {
            passwordInput.value = passwordInput.value.slice(0, 30);
        }
    });

    
    cnpjInput.addEventListener('input', function() {
        // Remove any non-digit characters from the input value
        var cleanedValue = cnpjInput.value.replace(/\D/g, '');

        // Limit the character length to a maximum of 14
        if (cleanedValue.length > 14) {
            cleanedValue = cleanedValue.slice(0, 14);
        }

        // Apply the CNPJ mask
        var maskedValue = cleanedValue.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');

        // Update the input value with the masked value
        cnpjInput.value = maskedValue;
    });


</script>
</html>