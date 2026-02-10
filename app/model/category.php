<?php
require_once __DIR__ . "/../../config/db.php";

class cateModel
{
    private $conn;
    private $database;
    private $table = 'categories';

    public function __construct()
    {
        $this->database = new Database();
        $this->conn = $this->database->connect();
    }

    public function pagination()
    {
        $limit = 10;
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        return compact('limit', 'start', 'page');
    }

    public function countcategory()
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        $cateCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return $cateCount;
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM {$this->table}";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCate($start, $limit)
    {
        $sql = "SELECT * FROM {$this->table} LIMIT :start, :limit";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters as integers
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $dsc)
    {
        $sql = "INSERT INTO {$this->table} (name, dsc) VALUES(?, ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $dsc]);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function edit($name, $dsc, $id)
    {
        $sql = "UPDATE {$this->table} 
            SET name = ?, dsc = ?
            WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $dsc, $id]);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
