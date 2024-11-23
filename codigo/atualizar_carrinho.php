<?php
include('ConfigApp.php');
session_start();
$parametro_recebido = $_GET['cod_produto_quantidade'];
$parametro_dividido = explode('@', $parametro_recebido);
$cod_produto = $parametro_dividido[0];
$quantidade = $parametro_dividido[1];
$consulta_cod_compra = mysql_query("SELECT cod_compra FROM compras WHERE cod_cliente = ".$_SESSION['id']." AND status = 'A'");
$row = mysql_fetch_array($consulta_cod_compra);
$cod_compra = $row['cod_compra'];
$consulta_produto_inserido = mysql_query("SELECT cod_produto FROM carrinho WHERE cod_compra = ".$cod_compra." AND cod_produto = ".$cod_produto."");
$row = mysql_fetch_array($consulta_produto_inserido);
$cod_produto_inserido = $row['cod_produto'];
if($cod_produto_inserido == ""){
    $insere_produto = mysql_query("INSERT INTO carrinho(cod_compra, cod_produto, quantidade) VALUES (".$cod_compra.", ".$cod_produto.", ".$quantidade.")");
    if($insere_produto){
        $resposta = 'inseriu';
    }
}else{
    $atualiza_registro = mysql_query("UPDATE carrinho SET quantidade=".$quantidade." WHERE cod_compra = ".$cod_compra." AND cod_produto = ".$cod_produto."");
    if($atualiza_registro){
        $resposta = 'atualizou';
    }
}
$respostaJSON = Array(
array(
"resposta"=>"".$resposta.""
));
echo json_encode($respostaJSON);
?>