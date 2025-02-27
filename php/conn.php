<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'doceleituraamandaetarsila';
    // private $db_name = 'amanda';
    private $username = 'postgres';
    private $password = 'pabd';
    private $port = '5432';
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>