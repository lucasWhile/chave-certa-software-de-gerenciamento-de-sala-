<?php
include_once '../../conexaobanco/conexao.php';
class Bloco
{
    private $nome_bloco;

    public function __construct($nome_bloco)
    {
        $this->nome_bloco = $nome_bloco;
    }


    public function cadastrarBloco()
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("INSERT INTO bloco_predial (nome_bloco, status) VALUES (?, 'ativo')");
        $stmt->bind_param("s", $this->nome_bloco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }

    public function listarBlocos()
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("SELECT * FROM bloco_predial WHERE status = 'ativo' ORDER BY nome_bloco");
        $stmt->execute();
        $result = $stmt->get_result();

        $blocos = array();
        while ($row = $result->fetch_assoc()) {
            $blocos[] = $row;
        }

        $stmt->close();
        $pdo->close();

        return $blocos;
    }

    public function editarBloco($nome_bloco, $id_bloco)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("UPDATE bloco_predial SET nome_bloco = ? WHERE id_bloco = ?");
        $stmt->bind_param("si", $nome_bloco, $id_bloco);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }

    public function buscarBloco($id_bloco)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("SELECT * FROM bloco_predial WHERE id_bloco = ? AND status = 'ativo'");
        $stmt->bind_param("i", $id_bloco);
        $stmt->execute();
        $result = $stmt->get_result();

        $bloco = $result->fetch_assoc();

        $stmt->close();
        $pdo->close();

        return $bloco;
    }

    public function desativarBloco($id_bloco)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("UPDATE bloco_predial SET status = 'inativo' WHERE id_bloco = ?");
        $stmt->bind_param("i", $id_bloco);
        $stmt->execute();
        $stmt = $pdo->prepare("UPDATE sala SET status_sala = 'inativo' WHERE id_bloco = ?");
        $stmt->bind_param("i", $id_bloco);


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }


        
    
}
