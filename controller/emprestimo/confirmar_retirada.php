<?php

include_once '../../model/emprestimo.php';
$emprestimo = new emprestimo(null, null, null, null, null, null, null,null);
date_default_timezone_set('America/Campo_Grande');
$periodo=$_POST['periodo'];

$hora = date('H:i:s');

$id_emprestimo=$_POST['id_emprestimo'];

if(isset($_POST['data_volta'])){
    $dataVolta=$_POST['data_volta'];
     if ($emprestimo->ConfirmarRetiradaChaveAgendada($id_emprestimo, $hora)) {
            $_SESSION['msg'] = 'Agendamento confirmado';
        header("Location: ../../view/emprestimo_chave/tela_inicial.php?data=$dataVolta&periodo=$periodo&buscar=true");
        } else {
            echo "Erro ao devolver empréstimo.";
        }

}
else{
       if ($emprestimo->ConfirmarRetiradaChaveAgendada($id_emprestimo, $hora)) {
            $_SESSION['msg'] = 'Agendamento confirmado';
        header("Location: ../../view/emprestimo_chave/salas_agendadas.php");
        } else {
            echo "Erro ao devolver empréstimo.";
        }
}

     




/*
 <input type="hidden" name="periodo" value="<?= $_GET['periodo'] ?>">
                        <input type="hidden" name="data_emprestimo" value="<?= $e['data_emprestimo'] ?>">
                        <input type="hidden" name="id_emprestimo" value="<?= $e['id_emprestimo'] ?>">
 * 
 */
?>