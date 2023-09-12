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

    $email = $_POST["email"];
    $user = $_POST["username"];
    $senha = $_POST["password"];
    $confirmarSenha = $_POST["confirmarSenha"];
    $CPF = $_POST["CPF"];
    $telefone = $_POST["telefone"];
    $cnpj = $_POST["CNPJ"];

    // Verificar se o email e o usuário já estão cadastrados
    $sql = "SELECT * FROM coisa WHERE email = '$email' OR CPF = '$CPF'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "O email ou o usuário já estão registrados.";
    } elseif ($senha !== $confirmarSenha) {
        echo "A senha e a confirmação de senha não correspondem.";
    } elseif (strlen($senha) < 8 || !preg_match("/[0-9]/", $senha) || !preg_match("/[^A-Za-z0-9]/", $senha)) {
        echo "A senha deve ter pelo menos 8 caracteres, um número e um caractere especial.";
    } elseif ($senha === $user || $senha === $email) {
        echo "A senha não pode ser igual ao usuário ou ao email.";
    } elseif (strlen($telefone) < 14) {
        echo "O telefone deve ter pelo menos 14 caracteres.";
    } else {
        // Verificar se o CNPJ existe e obter o nome da empresa
        $sql = "SELECT * FROM empresa WHERE cnpj = '$cnpj'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "O CNPJ informado não existe. Por favor, verifique o CNPJ e tente novamente.";
        } else {
            $row = $result->fetch_assoc();
            $nomeEmpresa = $row["Nome"];

            // Inserir os dados no banco de dados
            $sql = "INSERT INTO coisa (CPF, userName, senha, email, telefone, cnpj) VALUES ('$CPF', '$user', '$senha', '$email', '$telefone', '$cnpj')";

            if ($conn->query($sql) === TRUE) {
                echo "Dados inseridos na empresa $nomeEmpresa com sucesso!";
               
    header("Location: ../loginUser/index.php");
    exit();
            } else {
                echo "Erro ao inserir dados: " . $conn->error;
            }
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
    <link rel="stylesheet" href="cadastro.css" />
</head>
<body>
    <div class="login-page">
        <div class="form">
            <h1> CADASTRO</h1>
            <h1> Usuario </h1>
          <form class="login-form" method="POST">
          <input type="text" placeholder="CPF" name="CPF" required id="cpf-input" maxlength="14">
    <input type="text"  placeholder="User" name="username" required/>
    <input type="text" placeholder="Telefone" name="telefone" required/>
    <input type="email"  placeholder="email" name="email" required/>
    <input type="password" placeholder="Senha" name="password" required/>
    <input type="password" placeholder="Confirmar Senha" name="confirmarSenha" required/>
    <input type="text"  placeholder="CNPJ" name="CNPJ" required/>
    
    <button type="submit" name ="aaa">Cadastrar</button>
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

