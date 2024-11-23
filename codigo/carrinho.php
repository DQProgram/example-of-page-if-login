<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<table>
<tr>
<td>Produto</td>
<td>Preço Un.</td>
<td>Quantidade</td>
<td>Preço Total</td>
<td>Excluir</td>
<td>Atualizar</td>
</tr>
<?php
session_start();
$con = mysqli_connect("localhost","my_user","my_password","my_db");
$consulta_compra = mysqli_query($con, "SELECT cod_compra FROM compras WHERE cod_cliente='".$_SESSION['cod_cliente']."'");
$resultado_consulta_compra = mysqli_num_rows($consulta_compra);

if($resultado_consulta_compra == 0){
    echo "<tr><td colspan='4'>O carrinho encontra-se vazio! </td</tr>";
}else{
    $row = mysqli_fetch_array($consulta_compra);
    $cod_compra = $row['cod_compra'];
    $preenche_carrinho = mysqli_query($con, "SELECT carrinho.cod_produto, carrinho.carrinho.cod_compra = ".$cod_compra." AND carrinho.cod_produto = produtos.id");
    $resultado_consulta_carrinho = mysqli_num_rows($preenche_carrinho);

    if($resultado_consulta_carrinho == 0){
        echo "<tr><td colspan='4'>O carrinho encontra-se vazio! </td</tr>";
    }else{
        $total = 0;
        $i = 1;
        while($dados = mysqli_fetch_array($preenche_carrinho)){
            $preco_total = $dados['preco']*$dados['unidades_vendidas'];
            echo "<tr><td>".$dados['nome']."</td><td>".$dados['preco']."</td><td><input type='number' id='quantidade".$i."' name='quantidade".$i."' value='".$dados['unidades_vendidas']."'></td><td>".$preco_total."</td><td><input type='button' id='excluir".$i."' name='excluir' value='Excluir'></td><td><input type='button' id='atualizar".$i."' name='atualizar' value='Atualizar'></td></tr>";
            $total += $preco_total;
            $i++;
        }
        echo "<tr><td colspan='4'>Total: ".$total." </td</tr>";
    }
}
?>
</table>
<script>
    function atualizar(linha, quantidade){
        var codigo = linha.substring(9);
        var quantidade = $('#quantidade'+codigo).val();
        $.getJSON('atualizar_carrinho.php?cod_produto_quantidade='+codigo+'@'+quantidade, function(retorno){
            if(retorno[0].resposta == 'atualizou'){
                alert('Carrinho atualizado!');
            }else{
                alert('Erro ao atualizar carrinho!');
            }
        });
    }
    function excluir(linha){
        var codigo = linha.substring(7);
        $.getJSON('excluir_carrinho.php?cod_produto='+codigo, function(retorno){
            if(retorno[0].resposta == 'excluiu'){
                alert('Produto excluído do carrinho!');
                location.reload();
            }else{
                alert('Erro ao excluir produto do carrinho!');
            }
        });
    }
</script>
</body>
</html>