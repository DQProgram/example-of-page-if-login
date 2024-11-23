<?php
include('ConfigApp.php');
session_start();
$parametro_recebido = $_GET['cod_produto_quantidade'];
$parametro_dividido = explode('@', $parametro_recebido);
$cod_produto = $parametro_dividido[0];
$quantidade = $parametro_dividido[1];
$data = date('Y/m/d');
$hora = date('H:i:s');
$consulta_compra_aberta = mysql_query("SELECT cod_compra FROM compras WHERE cod_produto = '$cod_produto' AND status = 'aberta'");
$resposta = "";

if (mysql_num_rows($consulta_compra_aberta) == 0) {
    $insere_compra = mysql_query("INSERT INTO compras(cod_cliente, status) VALUES ('$cod_cliente', 'aberta')");
    if ($insere_compra) {
        $cod_compra = mysql_insert_id(); // Get the last inserted ID
        $insere_produto = mysql_query("INSERT INTO carrinho(cod_compra, cod_produto, quantidade, data, hora) VALUES ('$cod_compra', '$cod_produto', '$quantidade', '$data', '$hora')");
        if ($insere_produto) {
            $resposta .= "inseriu";
        }
    }
} else {
    $row = mysql_fetch_array($consulta_compra_aberta);
    $cod_compra = $row['cod_compra'];
    $consulta_produto_inserido = mysql_query("SELECT cod_produto FROM carrinho WHERE cod_produto = '$cod_produto' AND cod_compra = '$cod_compra'");
    if (mysql_num_rows($consulta_produto_inserido) == 0) {
        $insere_produto = mysql_query("INSERT INTO carrinho(cod_compra, cod_produto, quantidade, data, hora) VALUES ('$cod_compra', '$cod_produto', '$quantidade', '$data', '$hora')");
        if ($insere_produto) {
            $resposta .= "inseriu";
        }
    } else {
        $resposta .= "jainserido";
    }
}

$respostaJSON = array(
    array(
        "resposta" => "" . $resposta . ""
    )
);
echo json_encode($respostaJSON);
?>