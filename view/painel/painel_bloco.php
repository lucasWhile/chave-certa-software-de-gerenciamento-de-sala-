<?php
include_once '../../view/verificacao.php';
include_once '../../model/bloco.php';
include_once '../../model/emprestimo.php';

$bloco = new Bloco(null);
$blocos = $bloco->listarBlocos();

$emprestimos = [];
$total = $devolvidas = $naoDevolvidas = 0;

$idBloco = $_GET['id_bloco'] ?? null;
$dataInicial = $_GET['data_inicial'] ?? null;
$dataFinal = $_GET['data_final'] ?? null;

if ($idBloco && $dataInicial && $dataFinal) {
    $emprestimo = new Emprestimo(null, null, null, null, null, null, null, null);
    $emprestimos = $emprestimo->buscarEmprestimoPorBloco(
        $idBloco,
        $dataInicial,
        $dataFinal
    );

    $total = count($emprestimos);

    foreach ($emprestimos as $e) {
        ($e['status_emprestimo'] == 1) ? $naoDevolvidas++ : $devolvidas++;
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Relatório por Bloco</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
@media print {
    @page { size: A4 landscape; margin: 10mm; }
    form, .btn { display: none !important; }
    body { font-size: 11px; }
    th, td { white-space: nowrap; padding: 4px !important; }
}
</style>
</head>

<body class="bg-light">
<div class="container py-4">
 <div class="d-flex justify-content-start gap-3 mt-3">
                    <a href="../emprestimo_chave/tela_inicial.php" class="btn btn-outline-secondary">
                        ⬅️ Voltar
                    </a>

         
</div>
<!-- FILTRO -->
<form method="get" class="card p-3 mb-4">
<div class="row g-3">
    <div class="col-md-4">
        <label>Bloco</label>
        <select name="id_bloco" class="form-select" required>
            <?php foreach ($blocos as $b): ?>
                <option value="<?= $b['id_bloco'] ?>" <?= ($idBloco==$b['id_bloco'])?'selected':'' ?>>
                    <?= $b['nome_bloco'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label>Data Inicial</label>
        <input type="date" name="data_inicial" value="<?= $dataInicial ?>" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label>Data Final</label>
        <input type="date" name="data_final" value="<?= $dataFinal ?>" class="form-control" required>
    </div>
    <div class="col-md-2 d-grid">
        <button class="btn btn-success mt-4">📊 Gerar</button>
    </div>
</div>
</form>

<?php if ($idBloco): ?>

<!-- RESUMO -->
<div class="row text-center mb-3">
    <div class="col alert alert-primary">Total<br><b><?= $total ?></b></div>
    <div class="col alert alert-success">Devolvidas<br><b><?= $devolvidas ?></b></div>
    <div class="col alert alert-warning">Não devolvidas<br><b><?= $naoDevolvidas ?></b></div>
</div>


 <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="../emprestimo_chave/tela_inicial.php" class="btn btn-outline-secondary">
                        ⬅️ Voltar
                    </a>

                    <button onclick="window.print()" class="btn btn-danger">
                        📄 Salvar / Imprimir PDF
                    </button>
</div>
<!-- TABELA -->

<p>
                    Período:
                    <?= date('d/m/Y', strtotime($dataInicial)) ?>
                    a
                    <?= date('d/m/Y', strtotime($dataFinal)) ?>
</p>
<table class="table table-bordered table-sm">
<thead class="table-dark text-center">
<tr>
    <th>Bloco</th>
    <th>Sala</th>
    <th>Usuário</th>
    <th>Evento</th>
    <th>Data</th>
    <th>Retirada</th>
    <th>Devolução</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
<?php foreach ($emprestimos as $e): ?>
<tr>
    <td><?= $e['nome_bloco'] ?></td>
    <td><?= $e['nome_sala'] ?></td>
    <td><?= $e['nome_usuario'] ?></td>
    <td><?= $e['evento'] ?></td>
    <td><?= date('d/m/Y', strtotime($e['data_emprestimo'])) ?></td>
    <td><?= date('H:i', strtotime($e['hora_retirada'])) ?></td>
    <td><?= $e['hora_devolucao'] ? date('H:i', strtotime($e['hora_devolucao'])) : '—' ?></td>
    <td><?= $e['status_emprestimo'] ? 'Em andamento' : 'Devolvido' ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php endif; ?>

</div>
</body>
</html>
