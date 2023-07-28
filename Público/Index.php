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

// Verifica se foi feita uma requisição de exclusão
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir funcionário do banco de dados
    $sql = "DELETE FROM employees WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "Funcionário excluído com sucesso.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Consultar funcionários no banco de dados
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD de Funcionários</title>
</head>
<body>

<h1>Funcionários</h1>

<a href="add.php">Adicionar funcionário</a>

<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Estado Civil</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['birthdate']; ?></td>
                <td><?php echo $row['cpf']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['marital_status']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="index.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>

<?php
// Fechar conexão com o banco de dados
mysqli_close($conn);
?>