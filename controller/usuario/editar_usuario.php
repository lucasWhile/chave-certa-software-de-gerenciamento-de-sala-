<?php

include_once '../../model/usuario.php';

if ($_POST) {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $nivel_acesso = $_POST['nivel_acesso'];

    $usuarioModel = new Usuario($nome, $email, $senha, $telefone, $nivel_acesso, $cpf);
    
    if ($usuarioModel->editarUsuario($id_usuario)) {
        session_start();
        $_SESSION['msg'] = "Usuário editado com sucesso!";
        header("Location: ../../view/usuario/editar_usuario.php?id=$id_usuario");
        exit();
    } else {
        echo "Erro ao editar usuário.";
    }
}

?>