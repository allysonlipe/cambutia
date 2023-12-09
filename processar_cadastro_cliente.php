<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cambutia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura os dados do formulário
$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$telefone = $_POST["telefone"];

// Insere os dados no banco de dados
$sql = "INSERT INTO cliente (nome, cpf, telefone) VALUES ('$nome', '$cpf', '$telefone')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro de cliente realizado com sucesso!";
    header('refresh:3;url=index.html'); // Redireciona após 3 segundos
    exit; // Certifique-se de sair após o redirecionamento para evitar qualquer processamento adicional
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fecha a conexão
$conn->close();
?>