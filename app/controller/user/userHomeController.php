<?php

require_once __DIR__ . "/../../model/order.php";
require_once __DIR__ . "/../../model/product.php";
require_once __DIR__ . "/../../model/user.php";

class userHomeController
{

    private $cateModel;
    private $productModel;
    private $userModel;

    public function __construct()
    {
        $this->cateModel = new cateModel;
        $this->productModel = new ProductModel;
        $this->userModel = new UserModel;
    }

    public function index()
    {
        // Pagination settings
        $limit = 12; // number of products per page
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        // Get categories (for sidebar or quick actions)
        $numOfCate = $this->cateModel->countCategory();
        $categories = $this->cateModel->getAllCate(0, $numOfCate);

        // Get featured products with pagination
        $totalProducts = $this->productModel->countProducts();
        $totalPages = ceil($totalProducts / $limit);
        $featured = $this->productModel->getAll($start, $limit);

        require_once __DIR__ . "/../../view/user/index.php";
    }

    // show user infor by id
    public function show()
    {
        $id = $_GET['id'];
        $user = $this->userModel->findUserById($id);
        require_once __DIR__ . "/../../view/user/profile.php";
    }

    // bring user to edit form 
    public function edit()
    {
        $id = $_SESSION['userid'];
        $user = $this->userModel->findUserById($id);
        require_once __DIR__ . "/../../view/user/edit-profile.php";
    }

    // update user infor
    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_SESSION['userid'];
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $role = htmlspecialchars($_POST['role']);
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Password validation
        if ($password && $password !== $confirmPassword) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
            exit;
        }

        // Image upload
        $imageData = null;
        $imageType = null;

        if (!empty($_FILES['profile']['tmp_name'])) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($_FILES['profile']['type'], $allowed)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid image type']);
                exit;
            }
            if ($_FILES['profile']['size'] > 2000000) {
                echo json_encode(['status' => 'error', 'message' => 'Image too large']);
                exit;
            }
            $imageData = file_get_contents($_FILES['profile']['tmp_name']);
            $imageType = $_FILES['profile']['type'];
        }

        // Call model to update user
        $result = $this->userModel->edit($id, $username, $email, $role, $password, $imageData, $imageType);

        if ($result) {
            // Update session
            $_SESSION['username'] = $username;
            $_SESSION['useremail'] = $email;
            $_SESSION['role'] = $role;
            if ($imageData) {
                $_SESSION['profile'] = $imageData;
                $_SESSION['profile_type'] = $imageType;
            }
            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
        }
    }

}
