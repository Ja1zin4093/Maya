<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $dbname = "pit";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    if (isset($_POST["titulo"]) && !empty($_POST["titulo"])) {
        $titulo = $_POST["titulo"];
    } else {
        echo "O campo 'titulo' não pode ser vazio.";
    }

    $data = $_POST["data"];

    $nome_usuario = $_SESSION['log'];

    // Consulte o banco de dados para obter o CPF associado ao nome do usuário
    $sql = "SELECT CPF FROM coisa WHERE userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $cpf_usuario = $row['CPF'];

        // Verifique se já existe um evento com o mesmo CPF de usuário e data
        $sql = "SELECT id_usuario FROM evento WHERE id_usuario = ? AND data = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $cpf_usuario, $data);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Já existe um evento com essa data para o usuário, portanto, atualize-o
            $stmt = $conn->prepare("UPDATE evento SET titulo = ? WHERE id_usuario = ? AND data = ?");
            $stmt->bind_param("sss", $titulo, $cpf_usuario, $data);

            if ($stmt->execute()) {
                echo "Evento atualizado com sucesso!";
                header("Location: ../Site log/index.php");
            } else {
                echo "Erro ao atualizar evento: " . $stmt->error;
            }
       
    } else {
        echo "Usuário não encontrado.";
    }
}

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="calendario.css">
    <title>Calendário</title>
    <link rel="stylesheet" href="edit.css" />
</head>
<body>
    <div class="calendar">
        <div class="header">
            <button id="prevMonth">←</button>
            <h2 id="monthYear"></h2>
            <button id="nextMonth">→</button>
        </div>
        <div class="weekdays">
            <div class="weekday">Dom</div>
            <div class="weekday">Seg</div>
            <div class="weekday">Ter</div>
            <div class="weekday">Qua</div>
            <div class="weekday">Qui</div>
            <div class="weekday">Sex</div>
            <div class="weekday">Sáb</div>
        </div>
        <div class="days"></div>
    </div>
    <div class="event-form">
    <form  method="POST">
        <h3>Definir Titulo</h3>
        
       <input type="text" class="text" name="titulo">
        <select class="gamb" id="selectService">
            <option value="">Selecione um serviço</option>
            <option value="Corte de Cabelo">Corte de Cabelo</option>
            <option value="Depilação">Depilação</option>
            <!-- Adicione mais serviços conforme necessário -->
        </select>
        <select class="gamb" id="selectTimeSlot">
            <option value="">Selecione um horário disponível</option>
            <!-- Opções de horários disponíveis serão preenchidas via JavaScript -->
        </select>
        <input type="date" id="selectDate" name="data">
        <button id="scheduleTime">Agendar</button>
    </div>
    </form>
    <script src="calendario.js"></script>
</body>
</html>
