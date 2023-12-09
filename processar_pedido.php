<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cambutia";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtenha o ID do cliente com base no nome fornecido
$nomeCliente = $_POST['nomeCliente'];
$sql = "SELECT id FROM cliente WHERE nome = '$nomeCliente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idCliente = $row['id'];
} else {
    die("Cliente não encontrado.");
}

// Obtenha outros dados do formulário
$horaPedido = $_POST['horaEntrega'];
$dataPedido = date("Y-m-d", strtotime($_POST['dataEntrega'])); // Converter a data para o formato adequado
$enderecoEntrega = $_POST['endEntrega'];
$pagamento = $_POST['pagamento'];

// Insira um registro na tabela "pedido"
$sql = "INSERT INTO pedido (id_cliente, hora_pedido, data_pedido, endereco, pagamento) VALUES ($idCliente, '$horaPedido', '$dataPedido','$enderecoEntrega','$pagamento')";
if ($conn->query($sql) === TRUE) {
    $pedido_id = $conn->insert_id;
} else {
    die("Erro ao inserir pedido: " . $conn->error);
}

// Processar os produtos adicionados
$contador = 1;
while (isset($_POST['nomeProduto' . $contador]) && isset($_POST['qtdProd' . $contador])) {
    $nomeProduto = $_POST['nomeProduto' . $contador];
    $qtdProduto = $_POST['qtdProd' . $contador];
    // Insira os produtos na tabela "DetalhesPedido" sem fornecer um valor para o campo "id"
    $sql = "INSERT INTO DetalhesPedido (pedido_id, produto_id, quantidade) VALUES ($pedido_id, (SELECT id FROM Produto WHERE nome = '$nomeProduto'), $qtdProduto)";
    if ($conn->query($sql) !== TRUE) {
        die("Erro ao inserir detalhes do pedido: " . $conn->error);
    }
    $contador++;
}

// Feche a conexão com o banco de dados
$conn->close();
header("Location: comanda.php?idPedido=$pedido_id");
exit;
?>