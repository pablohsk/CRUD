Continue o código abaixo:

<?php

class Employee {
  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function create($name, $birthdate, $cpf, $email, $marital_status) {
    // Validar campos
    if (empty($name) || empty($birthdate) || empty($cpf) || empty($email) || empty($marital_status)) {
      return "Todos os campos são obrigatórios.";
    }

    // Validar CPF
    if (!validaCPF($cpf)) {
      return "CPF inválido.";
    }

    // Validar e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return "E-mail inválido.";
    }

    // Inserir no banco de dados
    $sql = "INSERT INTO employees (name, birthdate, cpf, email, marital_status) VALUES ('$name', '$birthdate', '$cpf', '$email', '$marital_status')";
    if (mysqli_query($this->conn, $sql)) {
      return "Funcionário adicionado com sucesso.";
    } else {
      return "Error: " . $sql . "<br>" . mysqli_error($this->conn);
    }
  }

  public function readAll() {
    // Consultar funcionários no banco de dados
    $sql = "SELECT * FROM employees";
    $result = mysqli_query($this->conn, $sql);

    $employees = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $employees[] = $row;
    }

    return $employees;
  }

  public function read($id) {
    // Consultar funcionário no banco de dados
    $sql = "SELECT * FROM employees WHERE id = $id";
    $result = mysqli_query($this->conn, $sql);

    $employee = mysqli_fetch_assoc($result);

    return $employee;
  }

  public function update($id, $name, $birthdate, $cpf, $email, $marital_status) {
    // Validar campos
    if (empty($name) || empty($birthdate) || empty($cpf) || empty($email) || empty($marital_status)) {
      return "Todos os campos são obrigatórios.";
    }

    // Validar CPF
    if (!validaCPF($cpf)) {
      return "CPF inválido.";
    }

    // Validar e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return "E-mail inválido.";
    }

    // Atualizar no banco de dados
    $sql = "UPDATE employees SET name = '$name', birthdate = '$birthdate', cpf = '$cpf', email = '$email', marital_status = '$marital_status' WHERE id = $id";
    if (mysqli_query($this->conn, $sql)) {
      return "Funcionário atualizado com sucesso.";
    } else {
      return "Error: " . $sql . "<br>" . mysqli_error($this->conn);
    }
  }

  public function delete($id) {
    // Excluir funcionário do banco de dados
    $sql = "DELETE FROM employees WHERE id = $id";
    if (mysqli_query($this->conn, $sql)) {
      return "Funcionário excluído com sucesso.";
    } else {
      return "Error: " . $sql . "<br>" . mysqli_error($this ->conn);
}
}

private function validaCPF($cpf) {
// Verificar se o CPF possui 11 dígitos
if (strlen($cpf) != 11) {
return false;
}

// Verificar se todos os dígitos são iguais
if (preg_match('/(\d)\1{10}/', $cpf)) {
  return false;
}

// Calcular os dígitos verificadores
for ($i = 9; $i < 11; $i++) {
  $sum = 0;
  for ($j = 0; $j < $i; $j++) {
    $sum += $cpf[$j] * (($i + 1) - $j);
  }
  $rest = $sum % 11;
  if (($rest < 2 && $cpf[$i] != 0) || ($rest >= 2 && $cpf[$i] != (11 - $rest))) {
    return false;
  }
}

return true;

