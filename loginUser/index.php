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
  $CPF = $_POST["CPF"];

  session_start();
  $_SESSION['log'] = $username; session_id();


  // Use declarações preparadas para evitar injeção de SQL
  $stmt = $conn->prepare("SELECT * FROM coisa WHERE userName = ? AND senha = ? AND CPF = ?");
  $stmt->bind_param("sss", $username, $password, $CPF);
  $stmt->execute();

  // Obtenha o resultado da consulta
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    // Autenticação bem-sucedida
    echo "<br>Login bem-sucedido!</br>";
    header("Location: ../Site log/index.php");
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
          <input type="text" placeholder="CPF" name="CPF" required id="cpf-input" maxlength="14">
    <input type="text"  placeholder="User" name="username" required/>
    <input type="password" placeholder="Senha" name="password" required/>
    
    <button type="submit" name ="aaa">login</button>
    <p class="message">Esqueceu a senha? <a href="../REdsen/index.php">Redefinir senha</a></p>
    <p class="message">Empresa? <a href="../LoginEMP/index.php">Fazer login EMPRESA</a></p>
  
    
</form>
        </div>
      </div>
    </div>
</body>
<script>
 // Função para formatar o CPF
function formatarCPF(cpf) {
  cpf = cpf.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

  if (cpf.length > 11) {
    cpf = cpf.slice(0, 11); // Limita o CPF para 11 dígitos
  }

  cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'); // Insere os pontos e o traço

  return cpf;
}

// Função para atualizar o valor do campo de entrada com o CPF formatado
function atualizarCPFInput() {
  var input = document.getElementById('cpf-input');
  var cpf = input.value;
  var cpfFormatado = formatarCPF(cpf);
  input.value = cpfFormatado;
}

// Evento de escuta para chamar a função atualizarCPFInput ao digitar no campo de entrada
document.getElementById('cpf-input').addEventListener('input', atualizarCPFInput);

</script>
</html>