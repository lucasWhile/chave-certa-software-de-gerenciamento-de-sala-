<?php 
session_start();
include_once '../../model/usuario.php';

$usuarioModel = new Usuario(null, null, null, null, null, null);
$usuarios = $usuarioModel->listarUsuarios();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-people-fill me-2 text-primary"></i>
            Usuários cadastrados
        </h3>

        <a href="../emprestimo_chave/tela_inicial.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['msg'] ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                   
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nivel</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                   

                        <td class="fw-semibold">
                            <?= $usuario['nome_usuario'] ?>
                        </td>

                        <td><?= $usuario['email_usuario'] ?></td>
                        <td><?= $usuario['nivel_acesso'] ?></td>

                        <td class="text-center">
                            <!-- Editar -->
                            <a href="editar_usuario.php?id=<?= $usuario['id_usuario'] ?>"
                               class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <!-- Desativar -->
                            <a href="../../controller/usuario/desativar_usuario.php?id=<?= $usuario['id_usuario'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Deseja desativar este usuário?');">
                                <i class="bi bi-person-x-fill"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($usuarios)): ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-info-circle fs-3"></i>
                    <p class="mb-0 mt-2">Nenhum usuário encontrado</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
