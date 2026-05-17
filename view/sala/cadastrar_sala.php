<?php
session_start();
include_once '../../model/bloco.php';
include_once '../../model/sala.php';
$blocoModel = new Bloco(null);
$blocos = $blocoModel->listarBlocos();

$salaModel = new Sala(null, null);
$salas = $salaModel->listarSalas();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Sala</title>

    <!-- Bootstrap 5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row justify-content-center mb-4">
            <div class="col-md-5 col-lg-4">

                <?php if (isset($_SESSION['msg'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION['msg'] ?>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['msg']); ?>

                <!-- Card do formulário -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">
                            Cadastro de Sala
                        </h5>

                        <form action="../../controller/sala/cadastrar_sala.php" method="post">
                            <div class="mb-3">
                                <label for="nome_sala" class="form-label fw-semibold">
                                    Nome da Sala
                                </label>
                                <input type="text"
                                    id="nome_sala"
                                    name="nome_sala"
                                    class="form-control"
                                    placeholder="Digite o nome da sala"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="bloco" class="form-label fw-semibold">
                                    Bloco
                                </label>
                                <select name="id_bloco" id="id_bloco" class="form-select">
                                    <option value="">Selecione o bloco</option>
                                    <?php foreach ($blocos as $bloco): ?>
                                        <option value="<?= $bloco['id_bloco'] ?>"><?= $bloco['nome_bloco'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    Cadastrar
                                </button>

                                 <a href="../emprestimo_chave/tela_inicial.php" class="btn btn-outline-secondary">
                                    Voltar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>




            </div>
        </div>

      
            <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            Salas Cadastrados
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Bloco</th>
                                        <th>Ações</th>
                                        <th>Excluir</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($salas as $sala): ?>
                                        <tr>
                                            <td><?= $sala['nome_sala'] ?></td>
                                            <td><?= $sala['nome_bloco'] ?></td>
                                            <td>
                                                <a href="editar_sala.php?id=<?= $sala['id_sala'] ?>" class="btn btn-primary">
                                                    Editar
                                                </a>
                                            </td>
                                                <td>
                                                <a href="../../controller/sala/excluir_sala.php?id=<?= $sala['id_sala'] ?>" class="btn btn-danger">
                                                    Excluir
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (empty($salas)): ?>
                            <p class="text-muted text-center mb-0">
                                Nenhuma sala cadastrada.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
    </div>

    </div>

</body>

</html>