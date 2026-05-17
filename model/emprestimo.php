<?php
include_once '../../conexaobanco/conexao.php';
class emprestimo{

   private $data_emprestimo;

   private $hora_retirada;
    private $hora_devolucao;
    private $periodo;
    private $status_emprestimo;
    private $id_usuario;
    private $id_sala;

    private $evento;
   
   
    public function __construct($data_emprestimo, $hora_retirada, $hora_devolucao, $periodo, $status_emprestimo, $id_usuario, $id_sala, $evento)
    {
        $this->data_emprestimo = $data_emprestimo;
        $this->hora_retirada = $hora_retirada;
        $this->hora_devolucao = $hora_devolucao;
        $this->periodo = $periodo;
        $this->status_emprestimo = $status_emprestimo;
        $this->evento = $evento;
        $this->id_usuario = $id_usuario;
        $this->id_sala = $id_sala;
    }

    public function cadastrarEmprestimo()
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("INSERT INTO emprestimo_chave (data_emprestimo, hora_retirada, hora_devolucao, periodo, status_emprestimo, id_usuario, id_sala, evento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiiis", $this->data_emprestimo, $this->hora_retirada, $this->hora_devolucao, $this->periodo, $this->status_emprestimo, $this->id_usuario, $this->id_sala, $this->evento);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }


    public function buscarEmprestimos($data, $periodo)
{
    $conexao = new conexao();
    $mysqli = $conexao->conectar();

    $sql = "
        SELECT 
            e.id_emprestimo,
            e.data_emprestimo,
            e.hora_retirada,
            e.hora_devolucao,
            e.periodo,
            e.status_emprestimo,
            e.evento,

            u.id_usuario,
            u.nome_usuario,

            s.id_sala,
            s.nome_sala,

            b.id_bloco,
            b.nome_bloco
        FROM emprestimo_chave e
        INNER JOIN usuario u ON e.id_usuario = u.id_usuario
        INNER JOIN sala s ON e.id_sala = s.id_sala
        INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
        WHERE e.data_emprestimo = ?
          AND e.periodo = ?
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $data, $periodo);
    $stmt->execute();

    $result = $stmt->get_result();
    $emprestimos = [];

    while ($row = $result->fetch_assoc()) {
        $emprestimos[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    return $emprestimos;
}

    public function buscarEmprestimosDevolvidos($data, $periodo)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $sql = "
            SELECT 
                e.id_emprestimo,
                e.data_emprestimo,
                e.hora_retirada,
                e.hora_devolucao,
                e.periodo,
                e.status_emprestimo,
                e.evento,

                u.id_usuario,
                u.nome_usuario,

                s.id_sala,
                s.nome_sala,

                b.id_bloco,
                b.nome_bloco
            FROM emprestimo_chave e
            INNER JOIN usuario u ON e.id_usuario = u.id_usuario
            INNER JOIN sala s ON e.id_sala = s.id_sala
            INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
            WHERE e.data_emprestimo = ?
            AND e.periodo = ?
            AND e.status_emprestimo = 0
        ";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $data, $periodo);
        $stmt->execute();

        $result = $stmt->get_result();
        $emprestimos = [];

        while ($row = $result->fetch_assoc()) {
            $emprestimos[] = $row;
        }

        $stmt->close();
        $mysqli->close();

        return $emprestimos;
    }




    public function devolverChave($id_emprestimo, $hora_devolucao)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("UPDATE emprestimo_chave SET hora_devolucao = ?, status_emprestimo = 0 WHERE id_emprestimo = ?");
        $stmt->bind_param("si", $hora_devolucao, $id_emprestimo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }

    public function buscarEmprestimoData($id,$data_inicial,$dataFinal)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $sql = "
            SELECT 
                e.id_emprestimo,
                e.data_emprestimo,
                e.hora_retirada,
                e.hora_devolucao,
                e.periodo,
                e.evento,
                e.status_emprestimo,

                u.id_usuario,
                u.nome_usuario,

                s.id_sala,
                s.nome_sala,

                b.id_bloco,
                b.nome_bloco
            FROM emprestimo_chave e
            INNER JOIN usuario u ON e.id_usuario = u.id_usuario
            INNER JOIN sala s ON e.id_sala = s.id_sala
            INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
            WHERE e.data_emprestimo BETWEEN ? AND ?
              AND e.id_usuario = ?
        ";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssi", $data_inicial, $dataFinal, $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $emprestimos = [];

        while ($row = $result->fetch_assoc()) {
            $emprestimos[] = $row;
        }

        $stmt->close();
        $mysqli->close();

        return $emprestimos;
        
    }


    public function buscarEmprestimoPorSala($id_sala, $data_inicial, $data_final)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $sql = "
            SELECT 
                e.id_emprestimo,
                e.data_emprestimo,
                e.hora_retirada,
                e.hora_devolucao,
                e.periodo,
                e.evento,
                e.status_emprestimo,

                u.id_usuario,
                u.nome_usuario,

                s.id_sala,
                s.nome_sala,

                b.id_bloco,
                b.nome_bloco
            FROM emprestimo_chave e
            INNER JOIN usuario u ON e.id_usuario = u.id_usuario
            INNER JOIN sala s ON e.id_sala = s.id_sala
            INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
            WHERE e.data_emprestimo BETWEEN ? AND ?
              AND e.id_sala = ?
        ";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssi", $data_inicial, $data_final, $id_sala);
        $stmt->execute();

        $result = $stmt->get_result();
        $emprestimos = [];

        while ($row = $result->fetch_assoc()) {
            $emprestimos[] = $row;
        }

        $stmt->close();
        $mysqli->close();

        return $emprestimos;
        
    }

    public function buscarEmprestimoPorBloco($id_bloco, $data_inicial, $data_final)
{
    $conexao = new conexao();
    $mysqli = $conexao->conectar();

    $sql = "
        SELECT 
            e.*,
            u.nome_usuario,
            s.nome_sala,
            b.nome_bloco
        FROM emprestimo_chave e
        INNER JOIN usuario u ON e.id_usuario = u.id_usuario
        INNER JOIN sala s ON e.id_sala = s.id_sala
        INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
        WHERE b.id_bloco = ?
          AND e.data_emprestimo BETWEEN ? AND ?
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iss", $id_bloco, $data_inicial, $data_final);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = [];

    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }

    return $dados;
    }



    public function buscarEmprestimoDataFinal_Inicial($data_inicial,$dataFinal)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $sql = "
            SELECT 
                e.id_emprestimo,
                e.data_emprestimo,
                e.hora_retirada,
                e.hora_devolucao,
                e.periodo,
                e.evento,
                e.status_emprestimo,

                u.id_usuario,
                u.nome_usuario,

                s.id_sala,
                s.nome_sala,

                b.id_bloco,
                b.nome_bloco
            FROM emprestimo_chave e
            INNER JOIN usuario u ON e.id_usuario = u.id_usuario
            INNER JOIN sala s ON e.id_sala = s.id_sala
            INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
            WHERE e.data_emprestimo BETWEEN ? AND ?
              
        ";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $data_inicial, $dataFinal);
        $stmt->execute();

        $result = $stmt->get_result();
        $emprestimos = [];

        while ($row = $result->fetch_assoc()) {
            $emprestimos[] = $row;
        }

        $stmt->close();
        $mysqli->close();

        return $emprestimos;
        
    }



     public function ConfirmarRetiradaChaveAgendada($id_emprestimo, $hora_inicial)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("UPDATE emprestimo_chave SET hora_retirada = ?, status_emprestimo = 1 WHERE id_emprestimo = ?");
        $stmt->bind_param("si", $hora_inicial, $id_emprestimo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }


 

      public function buscarSalasAgendadas($status)
{
    $conexao = new conexao();
    $mysqli = $conexao->conectar();

    $sql = "
        SELECT 
            e.id_emprestimo,
            e.data_emprestimo,
            e.hora_retirada,
            e.hora_devolucao,
            e.periodo,
            e.status_emprestimo,
            e.evento,

            u.id_usuario,
            u.nome_usuario,

            s.id_sala,
            s.nome_sala,

            b.id_bloco,
            b.nome_bloco
        FROM emprestimo_chave e
        INNER JOIN usuario u ON e.id_usuario = u.id_usuario
        INNER JOIN sala s ON e.id_sala = s.id_sala
        INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
        WHERE e.status_emprestimo = ?
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $status);
    $stmt->execute();

    $result = $stmt->get_result();
    $emprestimos = [];

    while ($row = $result->fetch_assoc()) {
        $emprestimos[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    return $emprestimos;
}



 public function Cancelar_agendamento_sala($id_emprestimo)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("UPDATE emprestimo_chave SET status_emprestimo = 4 WHERE id_emprestimo = ?");
        $stmt->bind_param("i", $id_emprestimo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }


        public function verificarConflitoPeriodo($idSala, $dataInicial, $dataFinal)
{
    $conexao = new conexao();
    $mysqli = $conexao->conectar();

    $sql = "
        SELECT id_emprestimo 
        FROM emprestimo_chave
        WHERE id_sala = ?
        AND status_emprestimo IN (1,3)
        AND data_emprestimo BETWEEN ? AND ?
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iss", $idSala, $dataInicial, $dataFinal);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}


 public function buscarEmprestimosDevolvidosAgendamentoRapido($data_inicial, $data_final, $periodo)
{
    $conexao = new conexao();
    $mysqli = $conexao->conectar();

    $sql = "
        SELECT 
            e.id_emprestimo,
            e.data_emprestimo,
            e.hora_retirada,
            e.hora_devolucao,
            e.periodo,
            e.status_emprestimo,
            e.evento,

            u.id_usuario,
            u.nome_usuario,

            s.id_sala,
            s.nome_sala,

            b.id_bloco,
            b.nome_bloco
        FROM emprestimo_chave e
        INNER JOIN usuario u ON e.id_usuario = u.id_usuario
        INNER JOIN sala s ON e.id_sala = s.id_sala
        INNER JOIN bloco_predial b ON s.id_bloco = b.id_bloco
        WHERE e.data_emprestimo BETWEEN ? AND ?
        AND e.periodo = ?
        AND (e.status_emprestimo = 1 OR e.status_emprestimo = 3)
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $data_inicial, $data_final, $periodo);
    $stmt->execute();

    $result = $stmt->get_result();
    $emprestimos = [];

    while ($row = $result->fetch_assoc()) {
        $emprestimos[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    return $emprestimos;
}



}

?>