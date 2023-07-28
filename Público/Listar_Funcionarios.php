<?php

// Consultar funcionários no banco de dados
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);

// Verificar se existem funcionários cadastrados
if (mysqli_num_rows($result) == 0) {
    echo "Não existem funcionários cadastrados.";
    exit;
}

// Exibir tabela com os funcionários
echo "<table>";
echo "<tr><th>Nome</th><th>Data de nascimento</th><th>CPF</th><th>E-mail</th><th>Estado civil</th><th>Ações</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["birthdate"] . "</td>";
    echo "<td>" . $row["cpf"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td>" . $row["marital_status"] . "</td>";
    echo "<td>";
    echo "<a href='edit.php?id=" . $row["id"] . "'>Editar</a>";
    echo " | ";
    echo "<a href='delete.php?id=" . $row["id"] . "'>Excluir</a>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

// Fechar conexão com o banco de dados
mysqli_close($conn);

?>