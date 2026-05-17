<?php 
session_start();
include_once '../../model/usuario.php';

$usuarioModel = new Usuario(null, null, null, null, null, null);
$usuarios = $usuarioModel->BuscarUsuario($_GET['id']);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>

    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container min-vh-100 d-flex align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-7 col-lg-5">

            <div class="card shadow-lg border-0 rounded-4">

                <!-- Cabeçalho -->
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Edição de Usuário
                    </h4>
                </div>

                <div class="card-body p-4">

                <?php if (isset($_SESSION['msg'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION['msg'] ?>
                    </div>
                    <?php endif; ?>
                <?php unset($_SESSION['msg']); ?>

                    <form action="../../controller/usuario/editar_usuario.php" method="post">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" id="nome" name="nome" class="form-control" value="<?= $usuarios['nome_usuario'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" class="form-control" value="<?= $usuarios['email_usuario'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" id="senha" name="senha" class="form-control" value="<?= $usuarios['senha_usuario'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" id="cpf" name="cpf" class="form-control" value="<?= $usuarios['cpf_usuario'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel" id="telefone" name="telefone" class="form-control" value="<?= $usuarios['telefone_usuario'] ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                            <select id="nivel_acesso" name="nivel_acesso" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="admin" <?= ($usuarios['nivel_acesso'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="gerente" <?= ($usuarios['nivel_acesso'] == 'gerente') ? 'selected' : '' ?>>Gerente</option>
                                <option value="coordenador" <?= ($usuarios['nivel_acesso'] == 'coordenador') ? 'selected' : '' ?>>Coordenação</option>
                                <option value="instrutor" <?= ($usuarios['nivel_acesso'] == 'instrutor') ? 'selected' : '' ?>>Instrutor</option>
                                 <option value="portaria" <?= ($usuarios['nivel_acesso'] == 'portaria') ? 'selected' : '' ?>>Portaria</option>
                            </select>
                        </div>
                           <input type="hidden" name="id_usuario" value="<?= $usuarios['id_usuario'] ?>">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i>
                                Editar
                            </button>

                            <a href="../usuario/listar_usuarios.php" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-left me-1"></i>
                                Voltar
                            </a>
                        </div>

                     

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
