<?php
 class conexao
{
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $dbname = "chavesenai";

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