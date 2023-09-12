


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Navbar</title>
<link rel="stylesheet" href="stylee.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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

.floating-button {
  position: fixed;
  bottom: 20px; /* Distância da parte inferior */
  left: 20px; /* Distância da parte esquerda */
  width: 50px;
  height: 50px;
  background-color: #0074d9; /* Cor de fundo do botão */
  border-radius: 50%; /* Torna o botão circular */
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para efeito de elevação */
}

/* Estilos para o símbolo "+" dentro do botão */
.floating-button .plus {
  font-size: 24px;
  color: #fff; /* Cor do símbolo */
}


#form-container {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  justify-content: center;
  align-items: center;
}
.form-popup {
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
  position: relative;
}

/* Estilos para os itens do formulário */
label {
  display: block; /* Coloca cada rótulo e campo em uma linha separada */
  margin-bottom: 10px; /* Adiciona espaço entre os itens */
}

input[type="text"],
input[type="date"],
button {
  display: block; /* Coloca os campos e o botão um abaixo do outro */
  width: 100%; /* Define a largura para preencher a largura do formulário */
  margin-bottom: 10px; /* Adiciona espaço entre os campos e o botão */
}

/* Estilos para o botão de fechar */
.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #ff3333;
  color: #fff;
  border: none;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  font-size: 16px;
  cursor: pointer;
}

/* ... (seus estilos anteriores) ... */



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
        <a href="../CadastroUser/index.php"><?php session_start();
 echo $_SESSION['log'];?></a>
        
          <ul id="dropdown-content">
         <li> <a href="../site/perfil.php">Perfil</a></li>
         <li><a href="logout.php">Sair</a></li>
          </ul>
        
      </li>
    </ul>
  </nav>
</header>
<main>

<?php


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

$user_nome = $_SESSION['log'];

// Consulta SQL para obter o CPF do nome na tabela 'coisa'
$sql_cpf = "SELECT CPF FROM coisa WHERE userName = ?";
$stmt_cpf = $conn->prepare($sql_cpf);
$stmt_cpf->bind_param("s", $user_nome);
$stmt_cpf->execute();
$result_cpf = $stmt_cpf->get_result();

if ($result_cpf->num_rows > 0) {
    $row_cpf = $result_cpf->fetch_assoc();
    $user_cpf = $row_cpf['CPF'];

    // Consulta SQL para recuperar os IDs dos eventos associados ao CPF do usuário
    $sql = "SELECT id FROM evento WHERE id_usuario = '$user_cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Início da seção de eventos
        echo '<div class="eventos-container">';
        
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            
            // Consulta SQL para recuperar os detalhes do evento com base no ID
            $sql_evento = "SELECT * FROM evento WHERE id = $id";
            $result_evento = $conn->query($sql_evento);
            
            if ($result_evento->num_rows > 0) {
                $evento = $result_evento->fetch_assoc();
                
                // Crie o contêiner para o evento
                echo '<div class="evento-container">';
                echo '<div class="titulo">' . htmlspecialchars($evento["titulo"]) . '</div>';
                echo '<div class="data">' . htmlspecialchars($evento["data"]) . '</div>';
                // A linha abaixo foi removida para corrigir o erro
                // echo '<div class="contador">' . $evento["contador"] . '</div>';
                echo '<div class="botoes">';
                echo '<button onclick="edicao(' . $id . ')"><i class="fas fa-edit"> </i></button>';
                echo '<button onclick="confirmarExclusao(' . $id . ')"><i class="fas fa-trash-alt"></i></button>';
                echo '</div>';
                echo '</div>';
            }
        }
        
        // Fim da seção de eventos
        echo '</div>';
    } else {
        echo "Nenhum evento encontrado para este usuário.";
    }
} else {
    echo "Nenhum CPF encontrado para este nome de usuário.";
}


$conn->close();

?>

</main>

<div  class="floating-button">
  <a href="../calendario/calendario.php" class="plus">+</a>
</div>





<script src="mobile-navbar.js"></script>

<script>
function confirmarExclusao(eventoId) {
    if (confirm("Tem certeza de que deseja excluir este evento?")) {
        // Se o usuário confirmar, redirecione para uma página PHP que irá processar a exclusão
        window.location.href = "excluir_evento.php?id=" + eventoId;
    }
}
</script>
<script>
function edicao(eventoId) {
    if (confirm("Tem certeza de que deseja excluir este evento?")) {
        // Se o usuário confirmar, redirecione para uma página PHP que irá processar a exclusão
        window.location.href = "editar_evento.php?id=" + eventoId;
    }
}
</script>
</body>
</html>
