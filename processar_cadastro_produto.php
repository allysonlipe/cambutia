<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cambutia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Captura os dados do formulário
$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco = $_POST["preco"];

// Insere os dados no banco de dados
$sql = "INSERT INTO produto (nome, descricao, preco) VALUES ('$nome', '$descricao', '$preco')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro de produto realizado com sucesso!";
    header('refresh:3;url=index.html'); // Redireciona após 3 segundos
    exit; // Certifique-se de sair após o redirecionamento para evitar qualquer processamento adicional
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fecha a conexão
$conn->close();
?>
