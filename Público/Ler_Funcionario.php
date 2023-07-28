<?php

// Recuperar ID do funcionário
$id = $_GET['id'];

// Consultar funcionário no banco de dados
$sql = "SELECT * FROM employees WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Verificar se o funcionário existe
if (mysqli_num_rows($result) == 0) {
    echo "Funcionário não encontrado.";
    exit;
}

// Exibir dados do funcionário
$row = mysqli_fetch_assoc($result);
echo "Nome: " . $row["name"] . "<br>";
echo "Data de nascimento: " . $row["birthdate"] . "<br>";
echo "CPF: " . $row["cpf"] . "<br>";
echo "E-mail: " . $row["email"] . "<br>";
echo "Estado civil: " . $row["marital_status"] . "<br>";

// Fechar conexão com o banco de dados
mysqli_close($conn);
