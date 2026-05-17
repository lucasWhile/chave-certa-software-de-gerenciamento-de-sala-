<?php
include_once '../../view/verificacao.php';
include_once '../../model/sala.php';
include_once '../../model/emprestimo.php';

$sala = new Sala(null, null);
$salas = $sala->listarSalas();

$emprestimos = [];
$total = 0;
$devolvidas = 0;
$naoDevolvidas = 0;

$idSala = $_GET['id_sala'] ?? null;
$dataInicial = $_GET['data_inicial'] ?? null;
$dataFinal = $_GET['data_final'] ?? null;

if ($idSala && $dataInicial && $dataFinal) {
    $emprestimo = new Emprestimo(null, null, null, null, null, null, $idSala, null);
    $emprestimos = $emprestimo->buscarEmprestimoPorSala(
        $idSala,
        $dataInicial,
        $dataFinal
    );

    $total = count($emprestimos);

    foreach ($emprestimos as $emp) {
        if ($emp['status_emprestimo'] == 1) {
            $naoDevolvidas++;
        } else {
            $devolvidas++;
        }
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Relatório de Empréstimos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
@media print {

    @page {
        size: A4 landscape; /* 🔥 ISSO É O MAIS IMPORTANTE */
        margin: 10mm;
    }

    form, .btn {
        display: none !important;
    }

    body {
        background: #fff;
        font-size: 11px; /* reduz para caber tudo */
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    h3, h4 {
        text-align: center;
        margin-bottom: 10px;
    }

    table {
        width: 100% !important;
        border-collapse: collapse;
    }

    th, td {
        padding: 4px !important;
        font-size: 11px;
        white-space: nowrap; /* evita quebrar linha */
    }

    .table-responsive {
        overflow: visible !important;
    }
}

</style>
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- FILTRO -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">🔍 Filtros do Relatório</h5>
        </div>

        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sala</label>
                    <select name="id_sala" class="form-select" required>
                        <?php foreach ($salas as $s): ?>
                            <option value="<?= $s['id_sala'] ?>"
                                <?= ($idSala == $s['id_sala']) ? 'selected' : '' ?>>
                                <?= $s['nome_sala'] ?> - <?= $s['nome_bloco'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Data Inicial</label>
                    <input type="date" name="data_inicial" class="form-control"
                           value="<?= $dataInicial ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Data Final</label>
                    <input type="date" name="data_final" class="form-control"
                           value="<?= $dataFinal ?>" required>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success">
                        📊 Gerar
                    </button>
                </div>

            </form>
        </div>
    </div>

<?php if ($idSala && $dataInicial && $dataFinal): ?>

    <!-- RELATÓRIO -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="text-center mb-4">
                <h3 class="fw-bold">Relatório de Empréstimos</h3>

                <h5 class="text-muted">
                    Sala:
                    <?php
                        foreach ($salas as $s) {
                            if ($s['id_sala'] == $idSala) {
                                echo $s['nome_sala'] . ' - ' . $s['nome_bloco'];
                                break;
                            }
                        }
                    ?>
                </h5>

                <p>
                    Período:
                    <?= date('d/m/Y', strtotime($dataInicial)) ?>
                    a
                    <?= date('d/m/Y', strtotime($dataFinal)) ?>
                </p>

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="../emprestimo_chave/tela_inicial.php" class="btn btn-outline-secondary">
                        ⬅️ Voltar
                    </a>

                    <button onclick="window.print()" class="btn btn-danger">
                        📄 Salvar / Imprimir PDF
                    </button>
                </div>
            </div>

            <!-- RESUMO -->
            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <div class="alert alert-primary fw-semibold">
                        🔑 Total de registros <br>
                        <span class="fs-4"><?= $total ?></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="alert alert-success fw-semibold">
                        ✅ Devolvidas <br>
                        <span class="fs-4"><?= $devolvidas ?></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="alert alert-warning fw-semibold">
                        ⏳ Não devolvidas <br>
                        <span class="fs-4"><?= $naoDevolvidas ?></span>
                    </div>
                </div>
            </div>

            <!-- TABELA -->
            <?php if ($total > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>sala</th>
                            <th>Evento / Turma</th>
                            <th>Nome do Usuário</th>
                            <th>Data</th>
                            <th>Retirada</th>
                            <th>Devolução</th>
                            <th>Período</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emprestimos as $emp): ?>
                        <tr>
                            <td class="text-center"><?= $emp['nome_sala'] ?> / <?= $emp['nome_bloco'] ?></td>
                            <td class="text-center"><?= $emp['evento'] ?></td>
                            <td class="text-center"><?= $emp['nome_usuario'] ?></td>
                            <td><?= date('d/m/Y', strtotime($emp['data_emprestimo'])) ?></td>
                            <td><?= date('H:i', strtotime($emp['hora_retirada'])) ?></td>
                            <td>
                                <?= $emp['hora_devolucao']
                                    ? date('H:i', strtotime($emp['hora_devolucao']))
                                    : '— —' ?>
                            </td>
                            <td><?= ucfirst($emp['periodo']) ?></td>
                            <td class="text-center">
                                <span class="badge <?= $emp['status_emprestimo'] == 1 ? 'bg-warning' : 'bg-success' ?>">
                                    <?= $emp['status_emprestimo'] == 1 ? 'Em andamento' : 'Devolvido' ?>
                                </span>
                            </td>
                           
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    Nenhum empréstimo encontrado para este período.
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
