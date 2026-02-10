<?php
require_once __DIR__ . "/../../config/db.php";

class ProductModel
{
    private $conn;
    private $database;
    private $table = 'products';

    public function __construct()
    {
        $this->database = new Database();
        $this->conn = $this->database->connect();
    }

    public function pagination()
    {
        $limit = 10;
        $page  = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        return compact('limit', 'start', 'page');
    }

    public function countProducts()
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        $productsCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return $productsCount;
    }

    public function getAll($start, $limit)
    {
        $sql = "SELECT p.*,
                   c.name AS cate_name
            FROM {$this->table} p
            LEFT JOIN categories c
                ON p.category_id = c.id
            LIMIT :start, :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find($id)
    {
        $sql = "SELECT 
                p.*, 
                c.name AS category_name
            FROM {$this->table} p
            LEFT JOIN categories c 
                ON p.category_id = c.id
            WHERE p.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $price, $cate_id, $image, $stock)
    {
        $sql = "INSERT INTO {$this->table}
            (name, price, category_id, image, stock)
            VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $cate_id);
        $stmt->bindParam(4, $image, PDO::PARAM_LOB);
        $stmt->bindParam(5, $stock);

        $stmt->execute();
    }


    public function edit($name, $price, $cate_id, $stock, $id, $image = null)
    {
        if ($image !== null) {

            $sql = "UPDATE {$this->table}
                SET name = ?, price = ?, category_id = ?, image = ?, stock = ?
                WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $cate_id);
            $stmt->bindParam(4, $image, PDO::PARAM_LOB);
            $stmt->bindParam(5, $stock);
            $stmt->bindParam(6, $id);

            return $stmt->execute();
        } else {

            $sql = "UPDATE {$this->table}
                SET name = ?, price = ?, category_id = ?, stock = ?
                WHERE id = ?";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$name, $price, $cate_id, $stock, $id]);
        }
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }
}
