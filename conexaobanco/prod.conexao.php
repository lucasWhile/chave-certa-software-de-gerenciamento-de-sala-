<?php
 class conexao
{
    private $host = "sql207.infinityfree.com";
    private $usuario = "if0_41117736";
    private $senha = "04U5xaReL4XvPe8";
    private $dbname = "if0_41117736_chavesenai";

    public function conectar()
    {
        $conn = mysqli_connect($this->host, $this->usuario, $this->senha, $this->dbname);
        if (!$conn) {
            die("Falha na conexão: " . mysqli_connect_error());
        }
        return $conn;
    }
}

?>