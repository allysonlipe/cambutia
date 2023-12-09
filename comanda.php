<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMANDA - CAMBUTIÁ</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            width: 70mm;
            word-wrap: break-word;
            margin-left: auto;
            margin-right: auto;
            /* Para centralizar verticalmente */

        }

        .nomeLoja h1 {
            margin-bottom: 0;
        }

        .nomeLoja p {
            margin-top: 0;
        }


        .travessao,
        .comanda-idPedido p {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .comanda-idPedido p {
            margin-bottom: 16px;
        }


        .travessao2,
        .travessao {
            text-align: center;
        }

        .comanda {
            /* background-color: rgb(243, 166, 166); */
        }

        .produto {
            text-align: left;
        }

        .comanda-header {
            text-align: center;
        }

        .comanda-idPedido {
            background-color: #000000;
            color: white;
            font-size: 5vh;
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            vertical-align: middle;
        }

        .dataHoraEntrega {
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-align: center;

        }

        .dataHoraEntrega,
        .dataHoraEntrega p {
            font-size: 3vh;
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .contato p,
        .endereco {
            padding-left: .5vw;
        }

        .precoTotal,
        .saudacao {
            text-align: right;
        }
    </style>

</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cambutia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $pedido_id = $_GET['idPedido'];

    // Consulta para obter o nome do cliente
    $sqlNome = "SELECT C.nome
    FROM cliente AS C
    INNER JOIN pedido AS P ON C.id = P.id_cliente
    WHERE P.id = $pedido_id";

    $resultNome = $conn->query($sqlNome);

    if ($resultNome->num_rows > 0) {
        $rowNome = $resultNome->fetch_assoc();
        $nomeCliente = $rowNome['nome'];
    } else {
        $nomeCliente = "Cliente não encontrado";
    }

    // Consulta para obter o CPF do cliente
    $sqlCpf = "SELECT C.cpf
            FROM cliente AS C
            INNER JOIN pedido AS P ON C.id = P.id_cliente
            WHERE P.id = $pedido_id";

    $resultCpf = $conn->query($sqlCpf);

    if ($resultCpf->num_rows > 0) {
        $rowCpf = $resultCpf->fetch_assoc();
        $cpfCliente = $rowCpf['cpf'];
    } else {
        $cpfCliente = "CPF não encontrado";
    }
    // Consulta para obter o telefone do cliente
    $sqlTel = "SELECT C.telefone
            FROM cliente AS C
            INNER JOIN pedido AS P ON C.id = P.id_cliente
            WHERE P.id = $pedido_id";

    $resultTel = $conn->query($sqlTel);

    if ($resultTel->num_rows > 0) {
        $rowTel = $resultTel->fetch_assoc();
        $telCliente = $rowTel['telefone'];
    } else {
        $telCliente = "CPF não informado";
    }
    //Consulta para obter a hora do pedido
    $sqlHora = "SELECT hora_pedido FROM pedido WHERE id=$pedido_id";

    $resultHora = $conn->query($sqlHora);

    if ($resultHora->num_rows > 0) {
        $rowHora = $resultHora->fetch_assoc();
        $horaPedido = $rowHora['hora_pedido'];
    } else {
        $horaPedido = "Horário não cadastrado";
    }
    $horaCompleta = "$horaPedido"; // Substitua pelo valor da hora obtido da consulta
    
    // Use a função substr para pegar os primeiros 5 caracteres
    $horaMinutos = substr($horaCompleta, 0, 5);
    //Consulta para obter a data do pedido
    
    $sqlData = "SELECT DATE_FORMAT(data_pedido, '%d/%m') AS data_pedido_formatada FROM pedido WHERE id=$pedido_id";

    $resultData = $conn->query($sqlData);

    if ($resultData->num_rows > 0) {
        $rowData = $resultData->fetch_assoc();
        $dataPedidoFormatada = $rowData['data_pedido_formatada'];
    } else {
        $dataPedidoFormatada = "Horário não cadastrado";
    }


    //Consulta SQL para obter o endereço do pedido
    $sqlEnd = "SELECT endereco FROM pedido WHERE id=$pedido_id";
    $resultEnd = $conn->query($sqlEnd);

    if ($resultEnd->num_rows > 0) {
        $rowEnd = $resultEnd->fetch_assoc();
        $enderecoPedido = $rowEnd['endereco'];
    } else {
        $enderecoPedido = "Endereço não cadastrado";
    }



    // Consulta SQL para obter os detalhes do pedido
    $sqlDetPed1 = "SELECT p.nome, dp.quantidade, p.preco
    FROM detalhespedido dp
    JOIN produto p ON dp.produto_id = p.id
    WHERE pedido_id = $pedido_id";



    $resultDetPed1 = $conn->query($sqlDetPed1);

    if ($resultDetPed1->num_rows > 0) {
        // Inicializa a lista de produtos e quantidades
        $produtos = array();
        while ($rowDetPed1 = $resultDetPed1->fetch_assoc()) {
            // Adiciona o nome do produto e a quantidade à lista
            $produtos[] = $rowDetPed1['quantidade'] . 'x ' . $rowDetPed1['nome'] . ' - (R$ ' . $rowDetPed1['preco'] . ')';

        }
        // Converte a lista de produtos em uma string HTML
        $produtosHtml = implode("<br>", $produtos);
    } else {
        $produtosHtml = "Comanda nao cadastrada.";
    }

    //Consulta SQL para obter preço do pedido
    $sqlPreco = "SELECT SUM(dp.quantidade * p.preco) AS total
    FROM detalhespedido dp
    JOIN produto p ON dp.produto_id = p.id
    WHERE dp.pedido_id = $pedido_id";

    $resultPreco = $conn->query($sqlPreco);

    $row = $resultPreco->fetch_assoc();
    $total = $row["total"];

    //Consulta SQL para ober a forma de pagamento.
    $sqlPagamento = "SELECT pagamento FROM pedido WHERE id = $pedido_id";

    $resultPedido = $conn->query($sqlPagamento);

    $rowPedido = $resultPedido->fetch_assoc();
    $formaPagamento = $rowPedido["pagamento"];



    //fechar a comunicação
    $conn->close();
    ?>

    <div class="comanda">
        <div class="comanda-header">
            <span class="nomeLoja">
                <h1>CAMBUTIÁ</h1>
                <p>COMIDA SAUDÁVEL</p>
            </span>
            <div class="comanda-idPedido">
                <p>ENTREGA:<span class="idpedido"></span> </p>
            </div>
            <p class="travessao">=============================</p>
        </div>
        <div class="contato">
            <p>
                <b>Nome:</b>
                <?php echo $nomeCliente; ?>
            </p>
            <p>
                <b>CPF:</b>
                <?php echo $cpfCliente; ?>
            </p>
            <p>
                <b>Telefone:</b>
                <?php echo $telCliente; ?>
            </p>
        </div>
        <p class="travessao2">-------------------------------------------------</p>

        <div class="dataHoraEntrega">
            <p>
                <?php echo $dataPedidoFormatada ?>
            </p>
            <p>
                <?php echo $horaMinutos ?>
            </p>
        </div>
        <p class="travessao2">-------------------------------------------------</p>
        <div class="endEntrega">
            <p class="endereco">
                <b>Endereço:</b>
                <?php echo $enderecoPedido ?>
            </p>
        </div>
        <p class="travessao2">-------------------------------------------------</p>
        <b>
            <p style="text-align: center;padding: 0;margin-bottom: 0px;margin-top: 0px;">Produtos: </p>
        </b>
        <div class="detalhesPedido">
            <p class="produto" style="margin-top: 0px;">
                <?php echo $produtosHtml ?>
            </p>
        </div>
        <p class="precoTotal">
            <strong>Preço Total: </strong> <br>
            <?php echo "R$ $total" ?>
        </p>

        <p class="travessao2">-------------------------------------------------</p>

        <div class="pagamento">
            <p>
                <strong>Forma de Pagamento:</strong> <br>
            </p>
            <p class="formaPag">
                <?php echo $formaPagamento ?>
            </p>
        </div>

        <div class="saudacao">
            <p> Te desejamos uma refeição incrível,</br> <strong>até breve!</strong></p>
        </div>
    </div>





    <!-- Script pra passar o valor do id_pedido via url -->
    <script>
        // Função para extrair parâmetros da URL
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Extrair o ID do pedido da URL
        let pedido_id = getParameterByName("idPedido");

        // Mostra o ID do pedido no span com classe idpedido. 
        var idPedidoSpan = document.querySelector('.idpedido');
        idPedidoSpan.textContent = pedido_id;
        //Mostra o nome do cliente na pagina

    </script>
    <!-- Script para receber a  -->

</body>

</html>