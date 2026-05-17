<?php
include_once '../../model/emprestimo.php';
session_start();
date_default_timezone_set('America/Campo_Grande');

$hora = date('H:i:s');

$data_inicial = $_POST['data_inicial'];
$data_final   = $_POST['data_final'];
$periodo      = $_POST['periodo'];
$id_usuario   = $_POST['id_usuario'];
$evento       = $_POST['evento'] ?? null;

if (isset($_POST['agendamento'])) {

    foreach ($_POST['agendamento'] as $id_sala => $datas) {

        foreach ($datas as $data) {

            // status 3 = agendamento futuro
            $emprestimo = new emprestimo(
                $data,          // data emprestimo
                null,           // hora retirada
                null,           // hora devolucao
                $periodo,
                3,              // status agendado
                $id_usuario,
                $id_sala,
                $evento
            );

            if (!$emprestimo->cadastrarEmprestimo()) {
                echo "Erro ao registrar agendamento para sala $id_sala na data $data <br>";
            }
        }
    }

    $_SESSION['msg'] = 'Agendamento realizado com sucesso!';
  header("Location: ../../view/emprestimo_chave/agendamento_rapido.php?data_inicial=$data_inicial&data_final=$data_final&periodo=$periodo&buscar=true");
    exit;
}
?>