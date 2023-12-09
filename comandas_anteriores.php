<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMANDA - CAMBUTIÁ</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body>
    <div id="mensagem"></div>
    <!-- Barra de navegação -->
    <ul class="navbar">
        <li class="nav-item"><a href="index.html">Home</a></li>
        <li class="nav-item"><a href="cadastro_cliente.html">Cadastrar Cliente</a></li>
        <li class="nav-item"><a href="cadastro_produto.html">Cadastrar Produto</a></li>
        <li class="nav-item"><a href="gerar_comanda.html">Criar Comanda</a></li>
        <li class="nav-item"><a href="comandas_anteriores.php">Comandas Anteriores</a></li>
    </ul>


    <!-- Formulário de Pesquisa -->
    <form action="" method="POST">
        <label for="pedido_id">Número do Pedido:</label>
        <input type="text" id="pedido_id" name="pedido_id" autocomplete="no" required>
        <br>
        <input type="submit" value="Pesquisar Pedido">
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cambutia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['pedido_id']) && !empty($_POST['pedido_id'])) {
            $pedido_id = $_POST['pedido_id'];
            // Faça algo com $pedido_id, como redirecionar para outra página
            header("Location: comanda.php?idPedido=$pedido_id");
            exit; // Certifique-se de encerrar o script após o redirecionamento.
        } else {
            echo "O campo Número do Pedido não foi preenchido.";
            header("refresh:3;url=comandas_anteriores.php"); // Redireciona de volta para a página anterior após 3 segundos.
        }
    }
    ?>
</body>

</html>