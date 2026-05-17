<?php
session_start();
$nome_sala = $_POST['nome_sala'];
$id_bloco = $_POST['id_bloco'];
$id_sala = $_POST['id_sala'];


include_once '../../model/sala.php';
$salaModel = new Sala($nome_sala, $id_bloco);


if ($salaModel->editarSala($id_sala, $nome_sala, $id_bloco)) {
    $_SESSION['msg'] = "Sala editada com sucesso!";
    header("Location: ../../view/sala/editar_sala.php?id=$id_sala");
} else {
    $_SESSION['msg'] = "Erro ao editar sala.";
    header("Location: ../../view/sala/editar_sala.php?id=$id_sala");
}
?>