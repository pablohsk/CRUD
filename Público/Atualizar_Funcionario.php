<?php

// Recuperar ID do funcionário
$id = $_GET['id'];

// Verificar se foi submetido o formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Atualizar registro no banco de dados
    $sql = "UPDATE employees SET name = '$name', birthdate = '$birthdate', cpf = '$cpf', email = '$email', marital_status = '$marital_status' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Funcionário atualizado com sucesso.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Consultar funcionário no banco de dados
$sql = "SELECT * FROM employees WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Verificar se o funcionário existe
if (mysqli_num_rows($result) == 0) {
    echo "Funcionário não encontrado.";
    exit;
}

// Exibir formulário de atualização com os dados do funcionário
$row = mysqli_fetch_assoc($result);
?>
<form method="POST">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br>
<label for="cpf">CPF:</label>
<input type="text" id="cpf" name="cpf" value="<?php echo $row['cpf']; ?>"><br>

<label for="email">E-mail:</label>
<input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br>

<label for="marital_status">Estado civil:</label>
<select id="marital_status" name="marital_status">
    <option value="single" <?php echo ($row['marital_status'] == 'single') ? 'selected' : ''; ?>>Solteiro(a)</option>
    <option value="married" <?php echo ($row['marital_status'] == 'married') ? 'selected' : ''; ?>>Casado(a)</option>
    <option value="divorced" <?php echo ($row['marital_status'] == 'divorced') ? 'selected' : ''; ?>>Divorciado(a)</option>