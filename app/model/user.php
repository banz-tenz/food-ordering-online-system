<?php

require_once __DIR__ . "/../../config/db.php";

class UserModel
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    /* =======================
       GET USERS (Pagination)
    ======================== */
    public function getAllUser($start, $limit)
    {
        $sql = "SELECT * FROM {$this->table} LIMIT :start, :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUsers()
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /* =======================
       CHECK EMAIL EXISTS
    ======================== */
    public function checkEmail($email)
    {
        $sql = "SELECT id FROM {$this->table} WHERE useremail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /* =======================
       CREATE USER
    ======================== */
    // public function createUser($username, $email, $password)
    // {
    //     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //     $role = 'user';

    //     $sql = "INSERT INTO {$this->table} (username, useremail, password, role)
    //             VALUES (?, ?, ?, ?)";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([$username, $email, $hashedPassword, $role]);
    // }
    public function createUser($username, $email, $password, $image = null, $type = null, $name = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';

        $sql = "INSERT INTO {$this->table} 
            (username, useremail, password, role, userProfile, profile_type, profile_name)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $username,
            $email,
            $hashedPassword,
            $role,
            $image,
            $type,
            $name
        ]);
    }


    /* =======================
       VERIFY USER
    ======================== */
    public function verifyUser($email, $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE useremail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    /* =======================
       DELETE USER
    ======================== */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    /* =======================
       PAGINATION
    ======================== */
    public function pagination()
    {
        $limit = 10;
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        return compact('limit', 'start', 'page');
    }

    public function edit($id, $username, $email, $password = null, $image = null, $type = null, $name = null)
    {
        // Start building SQL
        $sql = "UPDATE {$this->table} SET username = :username, useremail = :useremail";
        $params = [
            'username' => $username,
            'useremail' => $email,
            'id' => $id
        ];

        // Only update password if provided
        if (!empty($password)) {
            $sql .= ", password = :password";
            $params['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Only update image if provided
        if (!empty($image)) {
            $sql .= ", userProfile = :image, profile_type = :type, profile_name = :name";
            $params['image'] = $image;
            $params['type'] = $type;
            $params['name'] = $name;
        }

        // Add WHERE clause
        $sql .= " WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }


    public function findUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
