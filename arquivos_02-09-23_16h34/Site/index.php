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
        <a href="../CadastroUser/index.php">Fazer login</a>
        
          <ul id="dropdown-content">
         <li> <a href="#">Perfil</a></li>
         <li><a href="#">Sair</a></li>
          </ul>
        
      </li>
    </ul>
  </nav>
</header>
<main>
  <div id="but">
    <img src="39567-removebg-preview.png" alt="">
  </div>
</main>
<script src="mobile-navbar.js"></script>
</body>
</html>
