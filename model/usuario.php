<?php

include_once '../../conexaobanco/conexao.php';

class Usuario
{
    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $nivel_acesso;
    private $cpf;

    public function __construct($nome, $email, $senha, $telefone, $nivel_acesso, $cpf)
    {

        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
        $this->nivel_acesso = $nivel_acesso;
        $this->cpf = $cpf;
    }

    public function cadastrarUsuario()
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("INSERT INTO usuario (nome_usuario, email_usuario, telefone_usuario, nivel_acesso, senha_usuario, cpf_usuario, status_usuario) VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssssss", $this->nome, $this->email, $this->telefone, $this->nivel_acesso, $this->senha, $this->cpf);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }

    public function authUsuario($cpf, $senha)
    {
        $conexao = new conexao();
        $mysqli = $conexao->conectar();

        $sql = "SELECT * FROM usuario WHERE cpf_usuario = ? AND senha_usuario = ? AND status_usuario = 1";
        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param("ss", $cpf, $senha);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return true;
        }

        return false;
    }



    public function getUsuario($cpf)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE cpf_usuario = ?");
        $stmt->bind_param("s", $cpf);

        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_assoc();
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }


    public function listarUsuarios()
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE status_usuario = 1 ORDER BY nome_usuario ASC");

        if ($stmt->execute()) {
            return $stmt->get_result();
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }


    public function BuscarUsuario($id_usuario)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE   id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_assoc();
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }

     public function desativarUsuario($id_usuario)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("UPDATE usuario SET status_usuario = 0 WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }

    public function editarUsuario($id_usuario)
    {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("UPDATE usuario SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ?, nivel_acesso = ?, senha_usuario = ?, cpf_usuario = ? WHERE id_usuario = ?");
        $stmt->bind_param("ssssssi", $this->nome, $this->email, $this->telefone, $this->nivel_acesso, $this->senha, $this->cpf, $id_usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }


    public function getnome($id_usuario)  {
        $conexao = new conexao();
        $pdo = $conexao->conectar();

        $stmt = $pdo->prepare("SELECT nome_usuario FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_assoc()['nome_usuario'];
        } else {
            return false;
        }

        $stmt->close();
        $pdo->close();
    }
}
