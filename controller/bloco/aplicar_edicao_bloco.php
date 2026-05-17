<?php
session_start();
include '../../model/bloco.php';

$nome_bloco = $_POST['nome_bloco'];
$id_bloco = $_POST['id_bloco'];

$bloco = new Bloco($nome_bloco);

if ($bloco->editarBloco($nome_bloco, $id_bloco)) {
    $_SESSION['msg'] = "Bloco " . $nome_bloco . " editado com sucesso!";
    header("Location: ../../view/bloco/cadastrar_bloco.php");
} else {
    $_SESSION['msg'] = "Erro ao editar bloco: " . $nome_bloco . "!";
    header("Location: ../../view/bloco/cadastrar_bloco.php");
}
