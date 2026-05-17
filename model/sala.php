<?php
include_once '../../conexaobanco/conexao.php';
class Sala
{

    private $nome_sala;
    private $id_bloco;

    public function __construct($nome_sala, $id_bloco)
    {
        $this->nome_sala = $nome_sala;
        $this->id_bloco = $id_bloco;
    }


    public function cadastrarSala()
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("INSERT INTO sala (nome_sala, id_bloco, status_sala) VALUES (?, ?, 'ativo')");
        $stmt->bind_param("si", $this->nome_sala, $this->id_bloco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }


    public function listarSalas()
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $result = $mysqli->query("SELECT * FROM sala s JOIN bloco_predial b ON s.id_bloco = b.id_bloco where s.status_sala = 'ativo' ORDER BY b.nome_bloco, s.nome_sala");

        $salas = [];
        while ($row = $result->fetch_assoc()) {
            $salas[] = $row;
        }

        $mysqli->close();
        return $salas;
    }

        public function excluirSala($id_sala){
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("DELETE FROM sala WHERE id_sala = ?");
        $stmt->bind_param("i", $id_sala);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();

    }


    public function EditarSala($id_sala, $nome_sala, $id_bloco) : bool {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("UPDATE sala SET nome_sala = ?, id_bloco = ? WHERE id_sala = ?");
        $stmt->bind_param("ssi", $nome_sala, $id_bloco, $id_sala);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $mysqli->close();
    }

    public function buscarSala($id_sala) {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("SELECT * FROM sala WHERE id_sala = ?");
        $stmt->bind_param("i", $id_sala);
        $stmt->execute();
        $result = $stmt->get_result();

        $sala = $result->fetch_assoc();

        $stmt->close();
        $mysqli->close();

        return $sala;
        
    }


    public function desativar_sala($id_sala)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();
        $stmt = $mysqli->prepare("UPDATE sala SET status = 'desativado' WHERE id_sala = ?");
        $stmt->bind_param("i", $id_sala);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function listar_sala_bloco() {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $result = $mysqli->query("SELECT 
    s.id_sala,
    s.nome_sala,
    b.id_bloco,
    b.nome_bloco
    FROM sala s
    JOIN bloco_predial b ON b.id_bloco = s.id_bloco 
    WHERE s.status_sala = 'ativo'
    AND b.status = 'ativo'
    ORDER BY b.nome_bloco, s.nome_sala;

        ");

        return $result;
        
    }


    public function listar_sala_bloco_id($id_bloco) {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $stmt = $mysqli->prepare("SELECT
    s.id_sala,
    s.nome_sala,
    b.id_bloco,
    b.nome_bloco
    FROM sala s
    JOIN bloco_predial b ON b.id_bloco = s.id_bloco 
    WHERE s.status_sala = 'ativo'
    AND b.status = 'ativo'
    AND b.id_bloco = ?
    ORDER BY b.nome_bloco, s.nome_sala");

        $stmt->bind_param("i", $id_bloco);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
        
    }


}

