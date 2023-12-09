<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cambutia";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nomeCliente = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

    // SQL para selecionar os registros
    $result_msg_cont = "SELECT nome FROM cliente WHERE NOME LIKE '%" . $nomeCliente . "%' ORDER BY nome ASC LIMIT 10";
    // Preparar e executar a consulta
    $stmt = $conn->prepare($result_msg_cont);
    $stmt->execute();

    $data = array(); // Inicialize a variável $data como um array vazio

    while ($row_msg_cont = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row_msg_cont['nome'];
    }

    echo json_encode($data);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>