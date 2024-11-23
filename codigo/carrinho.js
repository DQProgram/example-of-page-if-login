function atualizar(linha, quantidade){
    var codigo = document.getElementById(linha).value;
    var quantidade = document.getElementById(linha).value;
    $.getJSON('atualizar_carrinho.php?cod_produto_quantidade='+cod_produto+'@'+quantidade,if(retorno[0].resposta == 'atualizou'){
    alert('Carrinho atualizado com sucesso!');
    document.location.reload(true);
    }else{
    alert('Não foi possível atulizar o carrinho!');
    }
    });
    }
    function excluir(linha){
    var codigo = document.getElementById(linha).cod_produto.value;
    $.getJSON('exclui_carrinho.php?cod_produto='+cod_produto, function(retorno){
    if(retorno[0].resposta == 'excluiu'){
    document.location.reload(true);
    }
    });
    }