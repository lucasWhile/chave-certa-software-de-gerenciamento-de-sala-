<?php

include_once '../../model/emprestimo.php';
$emprestimo = new emprestimo(null, null, null, null, null, null, null,null);
date_default_timezone_set('America/Campo_Grande');
$periodo=$_POST['periodo'];

$hora = date('H:i:s');

$id_emprestimo=$_POST['id_emprestimo'];


    $dataVolta=$_POST['data_volta'];
     if ($emprestimo->Cancelar_agendamento_sala($id_emprestimo)) {
            $_SESSION['msg'] = 'Cancelado';
         header("Location: ../../view/emprestimo_chave/salas_agendadas.php");
        } else {
            echo "Erro ao devolver empréstimo, Contrate o administrador";
        }


     




/*
 <input type="hidden" name="periodo" value="<?= $_GET['periodo'] ?>">
                        <input type="hidden" name="data_emprestimo" value="<?= $e['data_emprestimo'] ?>">
                        <input type="hidden" name="id_emprestimo" value="<?= $e['id_emprestimo'] ?>">
 * 
 */
?>