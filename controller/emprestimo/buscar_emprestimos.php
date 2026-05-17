<?php
$periodo=$_GET['periodo'];
$data=$_GET['data'];


include_once '../../model/emprestimo.php';

$emprestimo = new emprestimo(null, null, null, $periodo, null, null, null,null);
$emprestimos = $emprestimo->buscarEmprestimos($data, $periodo);


header("Location: ../../view/emprestimo_chave/tela_inicial.php?data=$data&periodo=$periodo");
?>