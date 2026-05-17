<?php 

session_start(); 
include_once '../../view/verificacao.php';
include_once '../../model/sala.php';
$salaModel = new Sala(null, null);
$salas = $salaModel->listar_sala_bloco();

include_once '../../model/usuario.php';
$usuarios = new Usuario(null, null, null, null, null, null);
$lista_usuarios = $usuarios->listarUsuarios();

include_once '../../model/emprestimo.php';
$emprestimoModel = new emprestimo(null, null, null, null, null, null, null,null);

$salasOcupadas = [];

date_default_timezone_set('America/Campo_Grande');
$hora = date('H:i:s');



    $emprestimos = $emprestimoModel->buscarSalasAgendadas(3);
  

    if (!empty($emprestimos)) {
        foreach ($emprestimos as $e) {
            if ($e['status_emprestimo'] == 1 || $e['status_emprestimo'] == 3 ) {
                $salasOcupadas[$e['id_sala']] = true;
            }
        }
    }



?>

<!doctype html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Seleção de Salas</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Fonte moderna -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #4f46e5;
    --secondary: #22c55e;
    --danger: #ef4444;
    --bg: #f8fafc;
    --card: #ffffff;
    --text: #0f172a;
    --muted: #64748b;
}

body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: var(--text);
}

/* NAVBAR */
.navbar {
    background: rgba(255,255,255,.85) !important;
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 30px rgba(0,0,0,.08);
}

.navbar-brand {
    font-weight: 700;
    letter-spacing: .5px;
}

/* CARD */
.card-box {
    background: var(--card);
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
    border: 1px solid #e5e7eb;
}

/* SALAS */
.sala {
    height: 70px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--primary), #6366f1);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .25s ease;
    user-select: none;
    box-shadow: 0 10px 20px rgba(79,70,229,.35);
    position: relative;
    overflow: hidden;
}

.sala::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,.12);
    opacity: 0;
    transition: .3s;
}

.sala:hover::after {
    opacity: 1;
}

.sala:hover {
    transform: translateY(-4px) scale(1.04);
}

.sala-nome {
    color: #fff;
    font-size: .9rem;
    font-weight: 600;
    text-align: center;
    z-index: 2;
}

.sala.selecionada {
    background: linear-gradient(135deg, var(--secondary), #16a34a);
    box-shadow: 0 0 0 3px rgba(34,197,94,.35);
}

.sala-ocupada {
    background: linear-gradient(135deg, var(--danger), #b91c1c) !important;
    cursor: not-allowed;
    opacity: .75;
    box-shadow: none;
}

/* ACCORDION */
.accordion-button {
    font-weight: 600;
}

.accordion-item {
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    margin-bottom: 12px;
}

/* FORM */
.form-control,
.form-select {
    border-radius: 12px;
    padding: 10px 14px;
}

/* BOTÕES */
.btn {
    border-radius: 14px;
    font-weight: 600;
}

.btn-primary {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
}

/* TABELAS */
.table {
    border-radius: 16px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    color: #fff;
}

.table-hover tbody tr:hover {
    background: #f1f5f9;
}

/* ANIMAÇÃO */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-box,
.accordion-item,
.table {
    animation: fadeUp .4s ease;
}
</style>
</head>


<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../emprestimo_chave/tela_inicial.php">ChaveCerta</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    

        <?php if(isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso']=='gerencia' || $_SESSION['nivel_acesso']=='coordenacao' || $_SESSION['nivel_acesso']=='admin'   ) { 
         ?>  

           <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Painel
          </a>
          <ul class="dropdown-menu">
            <li> <a class="dropdown-item" href="../../view/painel/painel.php">Painel p/ Usuario</a></li>
            <li><a class="dropdown-item" href="../../view/painel/painel_sala.php">Painel p/ Sala</a></li>
            <li><a class="dropdown-item" href="../../view/painel/painel_bloco.php">Painel p/ bloco</a></li>
          <li><a class="dropdown-item" href="../../view/painel/painel_geral.php">Painel Geral</a></li>
            </ul>
           </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cadastros
          </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../view/bloco/cadastrar_bloco.php">Cadastrar Bloco</a></li>
            <li><a class="dropdown-item" href="../../view/sala/cadastrar_sala.php">Cadastrar Sala</a></li>
            <li><a class="dropdown-item" href="../../view/usuario/cadastro_usuario.php">Cadastrar Usuário</a></li>
          <li><a class="dropdown-item" href="../../view/usuario/listar_usuarios.php">Lista de Usuários</a></li>
        </ul>
            </li>

               <li class="nav-item dropdown">
                <a class="nav-link" href="#">
                Salas agendadas
                </a>
             </li>



      <?php  } ?>
      


       
        <?php 
        if(isset($_SESSION['nome'])){ ?>
        <li class="nav-item">
          <a class="nav-link" href="../../controller/usuario/logout.php">Sair</a>
        </li>
        <?php  }  ?>

      </ul>
    
    </div>
  </div>
</nav>


<?php
if (isset($_SESSION['auth']) && empty($_SESSION['boas_vindas_mostrada'])) {

    $nome = explode(" ", $_SESSION['nome']);
    $_SESSION['boas_vindas_mostrada'] = true;
?>
    <div class="alert alert-success" role="alert">
        Olá <?php echo $nome[0]; ?>, nível acesso: <?php echo $_SESSION['nivel_acesso']; ?>
    </div>
<?php } ?>



<div class="container-xl py-4">

<h3 class="fw-bold mb-4">📋 Salas agendadas</h3>


<div class="row">


  <table class="table table-bordered table-hover mt-4">
    <thead class="table-dark">
        <tr>
            <th>Sala / Bloco</th>
            <th>Evento</th>
            <th>Período</th>
            <th>Usuário</th>
            <th>Data</th>
            <th>Hora retirada</th>
            <th>Hora entrega</th>
           
            <th>Devolução</th>
       
             
            


        </tr>
    </thead>
    <tbody>

    <?php if (!empty($emprestimos)): ?>
        <?php foreach ($emprestimos as $e): ?>
            <?php if ($e['status_emprestimo'] == 3 ): ?>
            <tr>
                <td>
                    <?= $e['nome_sala'] ?> / <?= $e['nome_bloco'] ?>
                </td>
               <td><?= $e['evento'] ?></td>
                <td><?= $e['periodo'] ?></td>
                <td><?= $e['nome_usuario'] ?></td>
                <td><?= date('d/m/Y', strtotime($e['data_emprestimo'])) ?></td>
                <td><?= $e['hora_retirada'] ?></td>
                <td><?= $e['hora_devolucao'] ?? '-' ?></td>

                 <?php if ($_SESSION['nivel_acesso'] == 'admin' || $_SESSION['nivel_acesso'] == 'gerente' || $_SESSION['nivel_acesso'] == 'coordenador' || $_SESSION['nivel_acesso'] == 'portaria' 
                 || $_SESSION['nivel_acesso']=='instrutor' && $_SESSION['nome']== $e['nome_usuario']): ?>

                <?php
                if($e['status_emprestimo'] == 3){?>

                <td>      
                    <form action="../../controller/emprestimo/confirmar_retirada.php" method="post">
                     
                        <input type="hidden" name="confirmar_retirada" value="confirmar">
                        <input type="hidden" name="periodo" value="<?= $e['periodo'] ?>">
                        <input type="hidden" name="data_emprestimo" value="<?= $e['data_emprestimo'] ?>">
                        <input type="hidden" name="id_emprestimo" value="<?= $e['id_emprestimo'] ?>">
                        <button class="btn btn-sm btn-success">Confirmar retirada</button>
                    </form>

                      <form action="../../controller/emprestimo/cancelar_emprestimo.php" method="post">
                     
                        <input type="hidden" name="confirmar_retirada" value="confirmar">
                        <input type="hidden" name="periodo" value="<?= $e['periodo'] ?>">
                        <input type="hidden" name="data_emprestimo" value="<?= $e['data_emprestimo'] ?>">
                        <input type="hidden" name="id_emprestimo" value="<?= $e['id_emprestimo'] ?>">
                        <button class="btn btn-sm btn-danger">Cancelar agendamento</button>
                    </form>
                </td>
               
                <?php } 
                else if($e['status_emprestimo'] == 1){     ?>
                <td>      
                    <form action="../../controller/emprestimo/devolucao_emprestimo.php" method="post">
                        <input type="hidden" name="periodo" value="<?= $_GET['periodo'] ?>">
                        <input type="hidden" name="data_emprestimo" value="<?= $e['data_emprestimo'] ?>">
                        <input type="hidden" name="id_emprestimo" value="<?= $e['id_emprestimo'] ?>">
                        <button class="btn btn-sm btn-success">Registrar Devolução</button>
                    </form>
                </td>
              <?php   }
                ?>



               
                <?php endif; ?>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center text-muted">
                Nenhuma sala ocupada neste período
            </td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>


</div>



</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
const agora = new Date();
document.getElementById('hora').value =
    agora.getHours().toString().padStart(2,'0') + ':' +
    agora.getMinutes().toString().padStart(2,'0');

let salasSelecionadas = [];
const form = document.querySelector('form[action*="registrar_emprestimo"]');

document.querySelectorAll('.sala').forEach(sala => {
    sala.addEventListener('click', () => {

        if (sala.classList.contains('sala-ocupada')) return;

        const id = sala.dataset.id;

        if (salasSelecionadas.includes(id)) {
            salasSelecionadas = salasSelecionadas.filter(s => s !== id);
            sala.classList.remove('selecionada');
        } else {
            salasSelecionadas.push(id);
            sala.classList.add('selecionada');
        }

        document.querySelectorAll('input[name="id_sala[]"]').forEach(i => i.remove());

        salasSelecionadas.forEach(idSala => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_sala[]';
            input.value = idSala;
            form.appendChild(input);
        });
    });
});

form?.addEventListener('submit', e => {
    if (salasSelecionadas.length === 0) {
        e.preventDefault();
        alert('Selecione ao menos uma sala!');
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const buscar = <?= $buscar ? 'true' : 'false' ?>;

    if (buscar) {
        document.getElementById('btnBuscar').click();
    }
});


</script>

</body>
</html>
