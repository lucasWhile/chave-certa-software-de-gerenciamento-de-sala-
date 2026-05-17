<?php
include_once '../../model/emprestimo.php';
session_start();
$data=$_POST['data'];        // ex: 2026-02-10
$_POST['periodo'];     // matutino | vespertino | noturno
$_POST['id_usuario'];  // id do usuário
//$_POST['hora'];      
date_default_timezone_set('America/Campo_Grande');
$hora = date('H:i:s');
echo $hora;
  // hora atual
$id_salas = $_POST['id_sala'];     // id da sala selecionada
$evento = $_POST['evento']; // evento ou turma
echo "Periodo: $_POST[periodo] <br>";
echo "Data: $_POST[data] <br>";
echo "ID Usuario: $_POST[id_usuario] <br>";
echo "Horário: $_POST[hora] <br>";
print_r($id_salas); // array de ids das salas selecionadas


if(isset($_POST['agendamento'])){

foreach ($id_salas as $id_sala) {
    $emprestimo = new emprestimo($_POST['data'], null, null, $_POST['periodo'], 3, $_POST['id_usuario'], $id_sala,$evento);
    if ($emprestimo->cadastrarEmprestimo()) {
      
    $_SESSION['msg'] = 'Empréstimo registrado com sucesso!';
     header("Location: ../../view/emprestimo_chave/tela_inicial.php?data=$data&periodo=$_POST[periodo]&buscar=true");
    } 
}

}

else{
    foreach ($id_salas as $id_sala) {
    $emprestimo = new emprestimo($_POST['data'], $hora, null, $_POST['periodo'], 1, $_POST['id_usuario'], $id_sala,$evento);
    if ($emprestimo->cadastrarEmprestimo()) {
    $_SESSION['msg'] = 'Empréstimo registrado com sucesso!';
    header("Location: ../../view/emprestimo_chave/tela_inicial.php?data=$data&periodo=$_POST[periodo]&buscar=true");
    } else {
        echo "Erro ao registrar empréstimo para a sala ID: $id_sala <br>";
    }
}
}




?>
