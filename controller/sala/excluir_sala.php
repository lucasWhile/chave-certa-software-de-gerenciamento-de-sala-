<?php
$id_sala = $_GET['id'];


include_once '../../model/sala.php';
$salaModel = new Sala('', 0);
if ($salaModel->excluirSala($id_sala)) {
    session_start();
    $_SESSION['msg'] = "Sala excluída com sucesso.";
      header("Location: ../../view/sala/cadastrar_sala.php");
} else {
    session_start();
    $_SESSION['msg'] = "Erro ao excluir a sala.";
    header("Location: ../../view/sala/cadastrar_sala.php");
}

?>