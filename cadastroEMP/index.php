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
    $CNPJ = $_POST["CNPJ"];
    $telefone = $_POST["telefone"];
    $cep = $_POST["CEP"];

    // Verificar se o email e o usuário já estão cadastrados
    $sql = "SELECT * FROM empresa WHERE email = '$email' OR CNPJ = '$CNPJ'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "O email ou o usuário já estão registrados.";
    } elseif ($senha !== $confirmarSenha) {
        echo "A senha e a confirmação de senha não correspondem.";
    } else {
        // Validar senha com pelo menos 8 caracteres, um número e um caractere especial
        if (strlen($senha) < 8 || !preg_match("/[0-9]/", $senha) || !preg_match("/[^A-Za-z0-9]/", $senha)) {
            echo "A senha deve ter pelo menos 8 caracteres, um número e um caractere especial.";
        } elseif ($senha === $user || $senha === $email) {
            echo "A senha não pode ser igual ao usuário ou ao email.";
        } elseif (strlen($telefone) < 14) {
            echo "O telefone deve ter pelo menos 14 caracteres.";
        } elseif (strlen($cep) < 9) {
            echo "O CEP deve ter pelo menos 9 caracteres.";
        } else {
            // Inserir os dados no banco de dados
            $sql = "INSERT INTO empresa (cnpj, email, Nome, senha, telefone, CEP) VALUES ('$CNPJ', '$email', '$user', '$senha', '$telefone', '$cep')";

            if ($conn->query($sql) === TRUE) {
                echo "Dados inseridos com sucesso!";
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
    <title>CadEmp</title>
    <link rel="stylesheet" href="cadastro.css" />
</head>
<body>
    <div class="login-page">
        <div class="form">
            <h1> CADASTRO</h1>
            <h1> Empresa</h1>
          <form class="login-form" method="POST">
    <input type="text"  placeholder="CNPJ" name="CNPJ" required/>
    <input type="text"  placeholder="User" name="username" required/>
    <input type="text"  placeholder="Telefone" name="telefone" required/>
    <input type="text"  placeholder="CEP" name="CEP" required/>
    <input type="email"  placeholder="email" name="email" required/>
    <input type="password" placeholder="Senha" name="password" required/>
    <input type="password" placeholder="Confirmar Senha" name="confirmarSenha" required/>
    
    <button type="submit" name ="aaa">Cadastrar</button>
    <p class="message">Já cadastrado? <a href="../login/index.php">Ir para login</a></p>
</form>
        </div>
      </div>
    </div>
</body>
<script> 
  // Get the input elements
  var usernameInput = document.querySelector('input[name="username"]');
    var emailInput = document.querySelector('input[name="email"]');
    var passwordInput = document.querySelector('input[name="password"]');
    var cnpjInput = document.querySelector('input[name="CNPJ"]');
    var telefoneInput = document.querySelector('input[name="telefone"]');
    var cepInput = document.querySelector('input[name="CEP"]');

    // Add event listeners for input changes
    usernameInput.addEventListener('input', function() {
        if (usernameInput.value.length > 200) {
            usernameInput.value = usernameInput.value.slice(0, 200);
        }
    });

    emailInput.addEventListener('input', function() {
        if (emailInput.value.length > 200) {
            emailInput.value = emailInput.value.slice(0, 200);
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

    telefoneInput.addEventListener('input', function() {
        // Remove any non-digit characters from the input value
        var cleanedValue = telefoneInput.value.replace(/\D/g, '');

        // Limit the character length to a maximum of 11
        if (cleanedValue.length > 11) {
            cleanedValue = cleanedValue.slice(0, 11);
        }

        // Apply the phone number mask
        var maskedValue = cleanedValue.replace(/^(\d{2})(\d{4,5})(\d{4})$/, '($1) $2-$3');

        // Update the input value with the masked value
        telefoneInput.value = maskedValue;
    });

    cepInput.addEventListener('input', function() {
        // Remove any non-digit characters from the input value
        var cleanedValue = cepInput.value.replace(/\D/g, '');

        // Limit the character length to a maximum of 8
        if (cleanedValue.length > 8) {
            cleanedValue = cleanedValue.slice(0, 8);
        }

        // Apply the CEP mask
        var maskedValue = cleanedValue.replace(/^(\d{5})(\d{3})$/, '$1-$2');

        // Update the input value with the masked value
        cepInput.value = maskedValue;
    });
</script>



</html>

