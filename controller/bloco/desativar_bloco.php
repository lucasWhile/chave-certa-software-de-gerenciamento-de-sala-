<?php
session_start();
$id_bloco = $_GET['id'];
include_once '../../model/bloco.php';
$blocoModel = new Bloco(null);
$blocoModel->desativarBloco($id_bloco);
$_SESSION['msg'] = "Bloco deletado com sucesso.";

header("Location: ../../view/bloco/cadastrar_bloco.php");
?>