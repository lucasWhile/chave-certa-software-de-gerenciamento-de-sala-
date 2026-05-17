<?php

$nome_sala = $_POST['nome_sala'];
$id_bloco = $_POST['id_bloco'];

  session_start();
include '../../model/sala.php';
$sala = new Sala($nome_sala, $id_bloco);
if ($sala->cadastrarSala()) {
    $_SESSION['msg'] = "Sala cadastrada com sucesso!";
    header("Location: ../../view/sala/cadastrar_sala.php");
} else {
    
    $_SESSION['msg'] = "Erro ao cadastrar sala. Tente novamente.";
   header("Location: ../../view/sala/cadastrar_sala.php");
}


?>