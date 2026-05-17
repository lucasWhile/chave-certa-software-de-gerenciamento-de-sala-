<?php

session_start();
include_once '../../model/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo  $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
    echo   $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($cpf) || empty($senha)) {
        $_SESSION['msg'] = 'Preencha todos os campos!';
        header("Location: ../view/usuario/login_usuario.php");
    } else {
        $usuario = new usuario(null, null, null, null, null, null);

        if ($usuario->authUsuario($cpf, $senha)) {
            $dados = $usuario->getUsuario($cpf);
            $_SESSION['id_usuario'] = $dados['id_usuario'];
            $_SESSION['nome'] = $dados['nome_usuario'];
            $_SESSION['email'] = $dados['email_usuario'];
            $_SESSION['telefone'] = $dados['telefone_usuario'];
            $_SESSION['nivel_acesso'] = $dados['nivel_acesso'];
            $_SESSION['cpf'] = $dados['cpf_usuario'];
            $_SESSION['auth'] = true;  
            header("Location: ../../view/emprestimo_chave/tela_inicial.php");
        } else {
            $_SESSION['msg'] = 'CPF ou senha inválidos!';
            header("Location: ../../view/usuario/login_usuario.php");
        }
    }
}
