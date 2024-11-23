<?php
//Nao tenho a certeza se é o index aqui porque nessa posição é utilizada para fazer a ligação a base de dados
include('ConfigApp.php');
session_start();
$cod_produto = $_GET['cod_produto'];

$consulta_cod_compra = mysql_query("SELECT cod_compra FROM compras WHERE cod_produto=".$cod_produto);

$cod_compra = mysql_fetch_array($consulta_cod_compra);
$cod_compra = $cod_compra['cod_compra'];

$deleta_registro = mysql_query("DELETE FROM carrinho WHERE cod_compra=".$cod_compra);

$resposta = '';
if($deleta_registro){
    $resposta .= 'excluiu';
}

$respostaJSON = Array(array("resposta"=>"".$resposta.""));
echo json_encode($respostaJSON);
?>