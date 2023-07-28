<?php

// Arquivo de configuração do banco de dados
$servername = "db";
$username = "root";
$password = "root";
$dbname = "employees";

// Conexão com o banco de dados
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Validar campos
if (empty($_POST['name']) || empty($_POST['birthdate']) || empty($_POST['cpf']) || empty($_POST['email']) || empty($_POST['marital_status'])) {
    echo "Todos os campos são obrigatórios.";
    exit;
}

$name = $_POST['name'];
$birthdate = $_POST['birthdate'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$marital_status = $_POST['marital_status'];

// Validar CPF
if (!validaCPF($cpf)) {
    echo "CPF inválido.";
    exit;
}

// Validar e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail inválido.";
    exit;
}

// Inserir no banco de dados
$sql = "INSERT INTO employees (name, birthdate, cpf, email, marital_status) VALUES ('$name', '$birthdate', '$cpf', '$email', '$marital_status')";

if (mysqli_query($conn, $sql)) {
    echo "Funcionário adicionado com sucesso.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Fechar conexão com o banco de dados
mysqli_close($conn);

// Função para validar CPF
function validaCPF($cpf) {
    // Extrair somente os números do CPF
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verificar se o CPF tem 11 caracteres
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verificar se há sequências de números iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Verificar se é um CPF válido
    for ($i = 9, $j = 0, $sum = 0; $i > 0; $i--, $j++) {
        $sum += $cpf[$i] * $j;
    }
    $sum %= 11;
    if ($cpf[10] != ($sum < 2 ? 0 : 11 - $sum)) {
        return false;
    }

    return true;
}
?>

