<?php
class Database {
    private $host = "localhost";
    private $dbname = "shop_ordering_online";
    private $dbuser = "root";
    private $dbpassword = "";
    private $conn;

    public function connect(){
        try{
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->dbuser,
                $this->dbpassword
            );

            // Set PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}
?>
