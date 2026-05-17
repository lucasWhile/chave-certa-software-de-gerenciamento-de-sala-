<?php
   
session_start();
include_once '../../view/verificacao.php';

date_default_timezone_set('America/Campo_Grande');

include_once '../../model/sala.php';
include_once '../../model/usuario.php';
include_once '../../model/emprestimo.php';
include_once '../../model/bloco.php';

$salaModel = new Sala(null, null);
$emprestimoModel = new Emprestimo(null, null, null, null, null, null, null, null);
$usuarios = new Usuario(null, null, null, null, null, null);
$blocoModel = new Bloco(null);

$lista_usuarios = $usuarios->listarUsuarios();

if ($lista_usuarios === false) {
    die("Erro ao buscar usuários no banco de dados.");
}
$blocos = $blocoModel->listarBlocos();

$salasBlocos = [];
$emprestimos = [];
$mapaEmprestimos = [];

if (isset($_GET['data_inicial'], $_GET['data_final'], $_GET['id_bloco'], $_GET['periodo'])) {

    $data_inicial = trim($_GET['data_inicial']);
    $data_final   = trim($_GET['data_final']);
    $id_bloco     = (int) $_GET['id_bloco'];
    $periodoFiltro = trim($_GET['periodo']);

    // Validação simples das datas
    if ($data_final < $data_inicial) {
        die("A data final não pode ser menor que a data inicial.");
    }

    $salasBlocos = $salaModel->listar_sala_bloco_id($id_bloco);

    $emprestimos = $emprestimoModel
        ->buscarEmprestimosDevolvidosAgendamentoRapido(
            $data_inicial,
            $data_final,
            $periodoFiltro
        );

    // Criar mapa rápido [id_sala][data] = true
    foreach ($emprestimos as $emp) {
        $mapaEmprestimos[$emp['id_sala']][$emp['data_emprestimo']][$emp['periodo']] = true;
    }
}

// Detectar período atual automático
$horaAtual = date('H:i');

if (isset($_GET['periodo'])) {

    $periodoAtual = $_GET['periodo'];

} else {

    if ($horaAtual >= '06:00' && $horaAtual < '12:00') {

        $periodoAtual = 'matutino';

    } elseif ($horaAtual >= '12:00' && $horaAtual < '18:00') {

        $periodoAtual = 'vespertino';

    } elseif ($horaAtual >= '18:00' && $horaAtual <= '22:00') {

        $periodoAtual = 'noturno';

    } else {

        $periodoAtual = '';
    }
}
?>

<!doctype html>
<html lang="pt-br">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Agendamento Rápido</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background: linear-gradient(135deg,#eef2ff,#f8fafc);
}

.card-box{
    background:#fff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 20px 40px rgba(0,0,0,.08);
}

.table thead{
    background:linear-gradient(135deg,#1e293b,#0f172a);
    color:#fff;
}

.table-success{
    background:#e6fffa !important;
}

.table-danger{
    background:#ffe5e5 !important;
}

</style>

</head>

<body>

<div class="container">

<div class="row">

<div class="col-12 mt-4">
<a type="button" class="btn btn-primary" href="../emprestimo_chave/tela_inicial.php">
Voltar
</a>
</div>

</div>

<div class="container py-5">

<h3 class="fw-bold mb-4">⚡ Agendamento Rápido</h3>

<div class="card-box mb-4">

<form method="get" class="row g-3">

<div class="col-md-3">

<label class="form-label fw-semibold">Data Inicial</label>

<input 
type="date" 
name="data_inicial" 
class="form-control"
value="<?= $_GET['data_inicial'] ?? '' ?>" 
required>

</div>

<div class="col-md-3">

<label class="form-label fw-semibold">Data Final</label>

<input 
type="date" 
name="data_final" 
class="form-control"
value="<?= $_GET['data_final'] ?? '' ?>" 
required>

</div>

<div class="col-md-3">

<label class="form-label fw-semibold">Bloco</label>

<select name="id_bloco" class="form-select" required>

<option value="">Selecione</option>

<?php foreach ($blocos as $bloco): ?>

<option 
value="<?= $bloco['id_bloco'] ?>"
<?= (isset($_GET['id_bloco']) && $_GET['id_bloco'] == $bloco['id_bloco']) ? 'selected' : '' ?>>

<?= $bloco['nome_bloco'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="col-md-3">

<label class="form-label fw-semibold">Período</label>

<select name="periodo" class="form-select" required>

<option value="matutino" <?= ($periodoAtual == 'matutino') ? 'selected' : '' ?>>
Matutino
</option>

<option value="vespertino" <?= ($periodoAtual == 'vespertino') ? 'selected' : '' ?>>
Vespertino
</option>

<option value="noturno" <?= ($periodoAtual == 'noturno') ? 'selected' : '' ?>>
Noturno
</option>

</select>

</div>

<div class="col-md-3 d-flex align-items-end">

<button class="btn btn-primary w-100">
🔍 Buscar Salas
</button>

</div>

</form>

</div>

</div>

<?php if (!empty($salasBlocos)): ?>

<?php

$data_inicio = new DateTime($_GET['data_inicial']);

$data_fim = new DateTime($_GET['data_final']);

$data_fim->modify('+1 day');

$datasPeriodo = new DatePeriod(
    $data_inicio,
    new DateInterval('P1D'),
    $data_fim
);

// Transformar em array reutilizável
$datasArray = [];

foreach ($datasPeriodo as $data) {
    $datasArray[] = clone $data;
}

?>

<div class="container mb-5">

<div class="card-box">

<form method="post" action="../../controller/emprestimo/registrar_emprestimo_rapido.php">

<input 
type="hidden" 
name="data_inicial" 
value="<?= $_GET['data_inicial'] ?? '' ?>">

<input 
type="hidden" 
name="data_final" 
value="<?= $_GET['data_final'] ?? '' ?>">

<input 
type="hidden" 
name="periodo" 
value="<?= $_GET['periodo'] ?? '' ?>">

<div class="mb-4">

<label class="form-label fw-semibold">
Usuário responsável
</label>

<?php if(isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] == 'instrutor'): ?>

<select name="id_usuario" class="form-select" required>

<option value="<?= $_SESSION['id_usuario'] ?>">
<?= $_SESSION['nome'] ?>
</option>

</select>

<?php else: ?>

<select name="id_usuario" class="form-select" required>

<?php if ($lista_usuarios instanceof mysqli_result): ?>

    <?php while($u = $lista_usuarios->fetch_assoc()): ?>

    <option value="<?= $u['id_usuario'] ?>">
    <?= $u['nome_usuario'] ?>
    </option>

    <?php endwhile; ?>

<?php else: ?>

    <?php foreach($lista_usuarios as $u): ?>

    <option value="<?= $u['id_usuario'] ?>">
    <?= $u['nome_usuario'] ?>
    </option>

    <?php endforeach; ?>

<?php endif; ?>

</select>

<?php endif; ?>

</div>

<div class="mb-4">

<label class="form-label fw-semibold">
Evento/turma
</label>

<input 
type="text" 
name="evento" 
class="form-control"
maxlength="100"
required>

</div>

<div class="table-responsive">

<table class="table table-bordered text-center align-middle">

<thead>

<tr>

<th>Sala</th>

<?php foreach ($datasArray as $data): ?>

<th><?= $data->format('d/m') ?></th>

<?php endforeach; ?>

</tr>

</thead>

<tbody>

<?php foreach ($salasBlocos as $sala): ?>

<tr>

<td class="fw-semibold">
<?= $sala['nome_sala'] ?>
</td>

<?php foreach ($datasArray as $data): ?>

<?php

$data_formatada = $data->format('Y-m-d');

$ocupado = isset($mapaEmprestimos[$sala['id_sala']][$data_formatada]);

?>

<td class="<?= $ocupado ? 'table-danger' : 'table-success' ?>">

<input 
type="checkbox"
name="agendamento[<?= $sala['id_sala'] ?>][]"
value="<?= $data_formatada ?>"
<?= $ocupado ? 'checked disabled' : '' ?>>

</td>

<?php endforeach; ?>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<div class="mt-3 text-end">

<button type="submit" class="btn btn-success">
💾 Salvar Agendamentos
</button>

</div>

</form>

</div>

</div>

<?php endif; ?>

</body>

</html>