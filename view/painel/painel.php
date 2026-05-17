<?php
 include_once '../../view/verificacao.php';
include_once '../../model/usuario.php';
include_once '../../model/emprestimo.php';
$usuarios = new Usuario(null, null, null, null, null, null);
$lista_usuarios = $usuarios->listarUsuarios();

if(isset($_GET['id_usuario']) && isset($_GET['data_inicial']) && isset($_GET['data_final'])){
    $emprestimo = new Emprestimo(null, null, null, null, null, $_GET['id_usuario'], null, null);
    $emprestimos = $emprestimo->buscarEmprestimoData($_GET['id_usuario'], $_GET['data_inicial'], $_GET['data_final']);

$total = count($emprestimos);
$devolvidas = 0;
$naoDevolvidas = 0;

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
    form, button {
        display: none !important;
    }

    body {
        background: #fff;
    }

    .card {
        border: none;
        box-shadow: none;
    }

    h3, h4 {
        text-align: center;
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
                    <label class="form-label fw-semibold">Usuário responsável</label>
                    <select name="id_usuario" class="form-select" required>
                        <?php while($u = $lista_usuarios->fetch_assoc()): ?>
                            <option value="<?= $u['id_usuario'] ?>">
                                <?= $u['nome_usuario'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Data Inicial</label>
                    <input type="date" name="data_inicial" class="form-control"
                           value="<?= $_GET['data_inicial'] ?? '' ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Data Final</label>
                    <input type="date" name="data_final" class="form-control"
                           value="<?= $_GET['data_final'] ?? '' ?>" required>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-success">
                        📊 Gerar
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- RELATÓRIO -->
    <?php if(isset($_GET['id_usuario'], $_GET['data_inicial'], $_GET['data_final'])): ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="text-center mb-4">
                <h3 class="fw-bold">Relatório de Empréstimos</h3>
                <h5 class="text-muted">
                    Usuário: <?= $usuarios->getnome($_GET['id_usuario']) ?>
                </h5>
                <p>
                    Período:
                    <?= date('d/m/Y', strtotime($_GET['data_inicial'])) ?>
                    a
                    <?= date('d/m/Y', strtotime($_GET['data_final'])) ?>
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

        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="alert alert-primary fw-semibold">
                    🔑 Total de chaves(salas) usadas: <br>
                    <span class="fs-4"><?= $total ?></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-success fw-semibold">
                    ✅ Devolvidas: <br>
                    <span class="fs-4"><?= $devolvidas ?></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-warning fw-semibold">
                    ⏳ Não devolvidas: <br>
                    <span class="fs-4"><?= $naoDevolvidas ?></span>
                </div>
            </div>
        </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Retirada</th>
                            <th>Devolução</th>
                            <th>Período</th>
                            <th>Status</th>
                            <th>Evento / Turma</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($emprestimos as $emp): ?>
                        <tr>
                            <td class="text-center"><?= $emp['id_emprestimo'] ?></td>
                            <td><?= date('d/m/Y', strtotime($emp['data_emprestimo'])) ?></td>
                            <td><?= date('H:i', strtotime($emp['hora_retirada'])) ?></td>
                            <td><?= date('H:i', strtotime($emp['hora_devolucao'])) ?></td>
                            <td><?= ucfirst($emp['periodo']) ?></td>
                            <td>
                                <span class="badge <?= $emp['status_emprestimo'] == 1 ? 'bg-warning' : 'bg-success' ?>">
                                    <?= $emp['status_emprestimo'] == 1 ? 'Em andamento' : 'Devolvido' ?>
                                </span>
                            </td>
                            <td><?= $emp['evento'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



