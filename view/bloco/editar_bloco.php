<?php
session_start();
include '../../model/bloco.php';
$blocoModel = new Bloco(null);
$id_bloco = $_GET['id'];
$bloco = $blocoModel->buscarBloco($id_bloco);

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
                            Editar Bloco
                        </h5>

                        <form action="../../controller/bloco/aplicar_edicao_bloco.php" method="post">
                            <div class="mb-3">

                                <label for="nome_bloco" class="form-label fw-semibold">
                                    Nome do Bloco
                                </label>
                                <input type="hidden" id="id_bloco" name="id_bloco" value="<?= $bloco['id_bloco'] ?>">
                                <input type="text" id="nome_bloco" name="nome_bloco" class="form-control" placeholder="Digite o nome do bloco" value="<?= $bloco['nome_bloco'] ?>" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    Salvar
                                </button>

                                <a href="../" class="btn btn-outline-secondary">
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