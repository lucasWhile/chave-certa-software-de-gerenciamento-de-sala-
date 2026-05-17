<?php
session_start();
include '../../model/bloco.php';

$nome_bloco = $_POST['nome_bloco'];

$bloco = new Bloco($nome_bloco);

if ($bloco->cadastrarBloco()) {
    $_SESSION['msg'] = "Bloco " . $nome_bloco . " cadastrado com sucesso!";
    header("Location: ../../view/bloco/cadastrar_bloco.php");
} else {
    $_SESSION['msg'] = "Erro ao cadastrar bloco: " . $nome_bloco . "!";
    header("Location: ../../view/bloco/cadastrar_bloco.php");
}
