<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema de Gerenciamento de Salas</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.35), transparent 35%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.25), transparent 35%),
                linear-gradient(135deg, #0f172a, #111827, #1e3a8a);
            overflow: hidden;
        }

        .card {
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.4rem;
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        }

        .brand-box {
            background: linear-gradient(160deg, #0f172a, #1d4ed8);
            position: relative;
        }

        .brand-box::before {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }

        .brand-box::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -60px;
            left: -60px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
        }

        .brand-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #93c5fd;
        }

        .brand-title {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-body {
            background: rgba(248, 250, 252, 0.97);
        }

        .login-title {
            color: #0f172a;
            font-weight: 700;
        }

        .input-group-text {
            background: #e0e7ff;
            border-color: #c7d2fe;
            color: #1d4ed8;
        }

        .form-control {
            border-color: #dbeafe;
            padding: 0.75rem;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.20);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            padding: 0.85rem;
            font-weight: 600;
            transition: 0.3s ease;
            border-radius: 0.8rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.35);
        }

        .footer-credit {
            font-size: 0.78rem;
            color: #6b7280;
        }

        .version-badge {
            display: inline-block;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 0.78rem;
            margin-top: 0.5rem;
        }

        hr {
            opacity: 0.2;
        }

        @media(max-width: 768px) {
            body {
                overflow: auto;
                padding: 1rem 0;
            }

            .brand-box {
                min-height: 250px;
            }
        }
    </style>
</head>

<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card">

                <div class="row g-0">

                    <!-- Lado esquerdo -->
                    <div class="col-md-5 brand-box text-white d-flex align-items-center">

                        <div class="p-4 text-center w-100 brand-content">

                            <i class="bi bi-buildings-fill brand-icon"></i>

                            <h3 class="brand-title">
                                Bem-vindo!
                            </h3>

                            <p class="small mb-2">
                                Sistema de Gerenciamento de Salas
                            </p>

                            <span class="version-badge">
                                Versão 0002 • Beta
                            </span>

                            <hr class="border-light my-4">

                            <p class="small mb-0">
                                Projeto desenvolvido para o<br>
                                <strong>SENAI – Corumbá/MS</strong>
                            </p>

                        </div>

                    </div>

                    <!-- Lado direito -->
                    <div class="col-md-7">

                        <div class="card-body p-4 p-md-5">

                            <?php
                            if (isset($_SESSION['msg'])) {
                                echo '
                                <div class="alert alert-danger text-center shadow-sm">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    ' . $_SESSION['msg'] . '
                                </div>';
                                unset($_SESSION['msg']);
                            }
                            ?>

                            <h4 class="text-center mb-4 login-title">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Acesso ao Sistema
                            </h4>

                            <form action="../../controller/usuario/login_usuario.php" method="post">

                                <!-- CPF -->
                                <div class="mb-3">

                                    <label for="cpf" class="form-label fw-semibold">
                                        CPF
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-person-vcard"></i>
                                        </span>

                                        <input
                                            type="text"
                                            id="cpf"
                                            name="cpf"
                                            class="form-control"
                                            placeholder="000.000.000-00"
                                            required>

                                    </div>

                                </div>

                                <!-- Senha -->
                                <div class="mb-4">

                                    <label for="senha" class="form-label fw-semibold">
                                        Senha
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>

                                        <input
                                            type="password"
                                            id="senha"
                                            name="senha"
                                            class="form-control"
                                            placeholder="Digite sua senha"
                                            required>

                                    </div>

                                </div>

                                <!-- Botão -->
                                <div class="d-grid">

                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">

                                        <i class="bi bi-door-open-fill me-1"></i>
                                        Entrar

                                    </button>

                                </div>

                            </form>

                            <!-- Rodapé -->
                            <div class="text-center footer-credit mt-4">

                                Desenvolvido por
                                <strong>Instrutor Lucas</strong><br>

                                SENAI – Corumbá/MS

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>