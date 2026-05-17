<?php
$_GET[ 'id' ] = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
include_once '../../model/usuario.php';
    $usuarioModel = new Usuario(null, null, null, null, null, null);
    if ($usuarioModel->desativarUsuario($_GET['id'])) {
        session_start();
        $_SESSION['msg'] = "Usuário desativado com sucesso!";
        header("Location:../../view/usuario/listar_usuarios.php");
        exit();
    } else {
        echo "Erro ao desativar usuário.";
    }

?>