<?php
session_start();
include_once '../../model/sala.php';
$id_sala = $_GET['id'];
$salaModel = new Sala(null, null);
if ($salaModel->desativar_sala($id_sala)) {
    $_SESSION['msg'] = "Sala desativada com sucesso!";
} else {
    $_SESSION['msg'] = "Erro ao desativar sala.";
}
header("Location: ../../view/sala/listar_salas.php");
?>