<?php
$conexao = new mysqli("localhost", "usuario", "senha", "nome_do_banco");

if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

$resultado = $conexao->query("SELECT id, nome, email, tipo FROM usuarios WHERE login = '".$login."' AND senha = '".$senha."'");

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    
    // Verifica se o usuário é administrador ou normal
    if ($usuario['tipo'] == 'A') {
        // Exibe recursos ou executa funções para administradores
    } else {
        // Exibe recursos ou executa funções para usuários normais
    }
} else {
    echo "Usuário ou senha incorretos";
}

$conexao->close();
?>