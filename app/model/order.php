<?php
require_once __DIR__ . "/../../config/db.php";

class orderModel
{
    private $conn;
    private $database;
    private $table = 'orders';

    public function __construct()
    {
        $this->database = new Database();
        $this->conn = $this->database->connect();
    }

    public function pagination()
    {
        $limit = 12;
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        return compact('limit', 'start', 'page');
    }
    public function countOrder()
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        $orderCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return $orderCount;
    }

    public function getAllOrders($start, $limit)
    {
        $sql = "SELECT o.*, u.username, COUNT(oi.id) AS total_items, SUM(p.price*oi.quantity) AS total_price
                FROM orders o 
                JOIN users u 
                ON u.id = o.user_id
                JOIN order_items oi
                ON o.id = oi.order_id
                JOIN products p 
                ON p.id = oi.product_id
                GROUP BY u.username, u.id;
                LIMIT :start, :limit";

        $stmt = $this->conn->prepare($sql);

        // Bind values as integers
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        // Return result
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOrder($id)
    {
        $sql = "SELECT u.username,o.*, u.useremail, p.name, p.price , SUM(p.price*oi.quantity) AS total_price, oi.quantity
                FROM orders o
                JOIN users u 
                ON u.id = o.user_id
                JOIN order_items oi
                ON oi.order_id = o.id
                JOIN products p 
                ON p.id = oi.product_id 
                where o.id = ?
                 GROUP BY p.name;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOrderByUserId($id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = :userId ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['userId' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createOrder($userId, $totalPrice, $status = 'pending')
    {
        $sql = "INSERT INTO {$this->table} (user_id, total_price, status) VALUES(:userId, :totalPrice, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'userId' => $userId,
            'totalPrice' => $totalPrice,
            'status' => $status,
        ]);
        return $this->conn->lastInsertId();
    }


    public function createOrderItems($orderId, $productId, $quantity)
    {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES(:orderId, :productId, :quantity)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'orderId' => $orderId,
            'productId' => $productId,
            'quantity' => $quantity,
        ]);
    }

    public function findOrderWithItems($orderId, $userId)
    {
        $sql = "SELECT o.id AS order_id,
                   o.created_at,
                   o.status,
                   u.username,
                   u.useremail,
                   p.image,
                   p.name AS product_name,
                   p.price AS product_price,
                   oi.quantity,
                   (p.price * oi.quantity) AS subtotal
            FROM orders o
            JOIN users u ON u.id = o.user_id
            JOIN order_items oi ON oi.order_id = o.id
            JOIN products p ON p.id = oi.product_id
            WHERE o.id = :orderId AND u.id = :userId";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'orderId' => $orderId,
            'userId' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
