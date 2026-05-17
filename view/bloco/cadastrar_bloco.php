<?php
session_start();
include '../../model/bloco.php';
$blocoModel = new Bloco(null);
$blocos = $blocoModel->listarBlocos();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Bloco</title>

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
                            Cadastro de Bloco
                        </h5>

                        <form action="../../controller/bloco/cadastrar_bloco.php" method="post">
                            <div class="mb-3">
                                <label for="nome_bloco" class="form-label fw-semibold">
                                    Nome do Bloco
                                </label>
                                <input type="text"
                                    id="nome_bloco"
                                    name="nome_bloco"
                                    class="form-control"
                                    placeholder="Digite o nome do bloco"
                                    required>
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

        <!-- Card da tabela -->
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            Blocos Cadastrados
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Ações</th>
                                        <th>Excluir</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blocos as $bloco): ?>
                                        <tr>
                                            <td><?= $bloco['nome_bloco'] ?></td>
                                            <td>
                                                <a href="editar_bloco.php?id=<?= $bloco['id_bloco'] ?>" class="btn btn-primary">
                                                    Editar
                                                </a>
                                            </td>
                                            <td>
                                                <a href="../../controller/bloco/desativar_bloco.php?id=<?= $bloco['id_bloco'] ?>" class="btn btn-danger">
                                                    desativar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (empty($blocos)): ?>
                            <p class="text-muted text-center mb-0">
                                Nenhum bloco cadastrado.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

</html>