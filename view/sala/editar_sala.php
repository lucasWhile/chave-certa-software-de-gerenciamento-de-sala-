<?php
session_start();
include '../../model/sala.php';
$salaModel = new sala(  null,null);
$id_sala = $_GET['id'];
$sala = $salaModel->buscarSala($id_sala);

include_once '../../model/bloco.php';
$blocoModel = new Bloco(null);
$blocos = $blocoModel->listarBlocos();


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
                            Editar Sala
                        </h5>

                        <form action="../../controller/sala/aplicar_edicao_sala.php" method="post">
                            <div class="mb-3">

                                <label for="nome_sala" class="form-label fw-semibold">
                                    Nome da Sala
                                </label>
                                <input type="hidden" id="id_sala" name="id_sala" value="<?= $sala['id_sala'] ?>">
                                <input type="text" id="nome_sala" name="nome_sala" class="form-control" placeholder="Digite o nome da sala" value="<?= $sala['nome_sala'] ?>" required>
                            </div>


                            <div class="mb-3">
                                <label for="bloco" class="form-label fw-semibold">
                                    Bloco
                                </label>
                                <select id="bloco" name="id_bloco" class="form-select" required>
                                    <option value="">Selecione um bloco</option>
                                    <?php foreach ($blocos as $bloco): ?>
                                        <option value="<?= $bloco['id_bloco'] ?>" <?= $bloco['id_bloco'] == $sala['id_bloco'] ? 'selected' : '' ?>>
                                            <?= $bloco['nome_bloco'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    Salvar
                                </button>

                                <a href="cadastrar_sala.php" class="btn btn-outline-secondary">
                                    Voltar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>



    </div>

</body>

</html>