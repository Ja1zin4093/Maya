
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $dbname = "pit";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $cpf = $_POST["CPF"]; // CPF para identificação da conta a ser atualizada

    // Campos a serem atualizados
    $newUserName = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $confirmNewPassword = $_POST["confirm_new_password"];
    $newTelefone = $_POST["telefone"];

    // Verificar se a senha e a confirmação de senha correspondem
    if ($newPassword !== $confirmNewPassword) {
        echo "A senha e a confirmação de senha não correspondem.";
    } else {
        // Construir a consulta SQL para atualização
        $sql = "UPDATE coisa SET userName = '$newUserName', senha = '$newPassword', telefone = '$newTelefone' WHERE CPF = '$cpf'";

        if ($conn->query($sql) === TRUE) {
            echo "Dados atualizados com sucesso!";
            header("Location: ../loginUser/index.php");
            exit();
        } else {
            echo "Erro ao atualizar dados: " . $conn->error;
        }
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
    <title>CadUSER</title>
    <!-- Inclua a biblioteca input-mask.js -->
<script src="caminho-para-o-input-mask.js"></script>

    <link rel="stylesheet" href="perfil.css" />
</head>
<body>
    <div class="login-page">
        <div class="form">
            <h1> Atualizar</h1>
            <h1> Usuario </h1>
            <form class="login-form" method="POST">

 <input type="text" placeholder="CPF (Para Identificação)" name="CPF" required id="cpf-input" maxlength="14">
    <input type="text" placeholder="Novo Nome de Usuário" name="new_username" required>
    <input type="password" placeholder="Nova Senha" name="new_password" required>
    <input type="password" placeholder="Confirmar Nova Senha" name="confirm_new_password" required>
    <input type="text" placeholder="Novo Telefone" name="telefone" required>
    <button type="submit" name="atualizar">Atualizar Dados</button>
    <p class="message">Já cadastrado? <a href="../loginUser/index.php">Ir para login</a></p>
    <p class="message">Empresa? <a href="../cadastroEMP/index.php">Cadastre empresa</a></p>
    
</form>


        </div>
      </div>
    </div>
</body>

<script>
  var cnpjInput = document.querySelector('input[name="CNPJ"]');
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

  // Função para adicionar a máscara ao telefone
  function maskTelefone(input) {
    // Remove caracteres não numéricos
    var value = input.value.replace(/\D/g, '');

    // Verifica se já possui 11 caracteres
    if (value.length > 11) {
      value = value.slice(0, 11);
    }

    // Formata o telefone no formato "(00) 00000-0000"
    value = value.replace(/^(\d{2})(\d{4,5})(\d{4})$/, '($1) $2-$3');

    // Atualiza o valor do campo
    input.value = value;
  }

  // Adiciona um evento de input ao campo CPF
  var cpfInput = document.querySelector('input[name="CPF"]');
  cpfInput.addEventListener('input', function() {
    maskCPF(cpfInput);
  });

  // Adiciona um evento de input ao campo telefone
  var telefoneInput = document.querySelector('input[name="telefone"]');
  telefoneInput.addEventListener('input', function() {
    maskTelefone(telefoneInput);
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
