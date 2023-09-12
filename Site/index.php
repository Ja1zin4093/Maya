<?php
session_start(); // Iniciar a sessão (se ainda não estiver iniciada)

// Verificar se o usuário está logado (você deve implementar isso)
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    // Conectar-se ao banco de dados (você deve usar suas próprias credenciais de conexão)
    $mysqli = new mysqli("localhost", "root", "", "pit");

    // Verificar a conexão
    if ($mysqli->connect_error) {
        die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
    }

    // Consulta SQL para obter o nome de usuário com base no CPF
    $cpf = $_SESSION['user_cpf'];
    $query = "SELECT userName FROM coisa WHERE CPF = '$cpf'";

    // Executar a consulta
    $result = $mysqli->query($query);

    // Verificar se a consulta foi bem-sucedida
    if ($result && $row = $result->fetch_assoc()) {
        $username = $row['userName'];
    } else {
        // Se algo deu errado, você pode tratar aqui
        $username = "Usuário Desconhecido";
    }

    // Fechar a conexão com o banco de dados
    $mysqli->close();
} else {
    // Se o usuário não estiver logado, defina o nome de usuário como vazio ou qualquer outro valor padrão
    $username = "";
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Navbar</title>
<link rel="stylesheet" href="style.css" />

<style>
/* ... (seus estilos anteriores) ... */

/* Estilo para o dropdown */
#dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  list-style: none;
  background: #23232e;
  
}

#dropdown-content a {
  display: block;
  padding: 10px 20px; /* Adicione espaçamento vertical e horizontal */
  text-decoration: none;
}

#dropdown-content a + a {
  margin-top: 10px; /* Adicione espaçamento entre os itens */
}

.dropdown:hover #dropdown-content {
  display: block;
}

</style>
</head>
<body>
<header>
  <nav>
    <a class="logo" href="/">Maya</a>
    <div class="mobile-menu">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>
    <ul class="nav-list">
      <li><a href="#">Início</a></li>
      <li><a href="#">Sobre</a></li>
      <li><a href="#">Projetos</a></li>
      <li><a href="#">Contato</a></li>
      <li class="dropdown">
      <a href="../CadastroUser/index.php"><?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true ? $username : 'Fazer login'; ?></a>

        
          
        
      </li>
    </ul>
  </nav>
</header>
<main>
  <!-- Conteúdo principal -->
</main>




<script src="mobile-navbar.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const formContainer = document.getElementById("form-container");
  const openFormButton = document.querySelector(".floating-button");
  const closeFormButton = document.getElementById("close-form");

  openFormButton.addEventListener("click", function () {
    formContainer.style.display = "flex";
  });

  closeFormButton.addEventListener("click", function () {
    formContainer.style.display = "none";
  });
});
  
</script>
</body>
</html>
