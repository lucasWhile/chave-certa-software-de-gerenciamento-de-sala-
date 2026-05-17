<?php
session_start();
$data= filter_input(INPUT_POST, 'data_emprestimo', FILTER_SANITIZE_SPECIAL_CHARS);
$id_emprestimo = filter_input(INPUT_POST, 'id_emprestimo', FILTER_SANITIZE_NUMBER_INT);
$periodo = filter_input(INPUT_POST, 'periodo', FILTER_SANITIZE_SPECIAL_CHARS);
date_default_timezone_set('America/Campo_Grande');
$hora = date('H:i:s');
echo $hora;

include_once '../../model/emprestimo.php';
$emprestimo = new emprestimo(null, null, null, null, null, null, null,null);




if ($emprestimo->devolverChave($id_emprestimo, $hora)) {
    $_SESSION['msg'] = 'Devolução registrada com sucesso!';
   header("Location: ../../view/emprestimo_chave/tela_inicial.php?data=$data&periodo=$periodo&buscar=true");
} else {
    echo "Erro ao devolver empréstimo.";
}

?>