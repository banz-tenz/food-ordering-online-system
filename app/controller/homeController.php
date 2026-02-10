<?php

require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../model/product.php";
require_once __DIR__ . "/../model/order.php";
require_once __DIR__ . "/../model/category.php";

class HomeController
{
    private $userModel;
    private $productModel;
    private $orders;
    private $cate;

    public function __construct()
    {
        // ✅ Start session once
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->orders = new orderModel();
        $this->cate = new cateModel();
    }

    /* =========================
       Check if user is logged in
       ========================= */
    private function checkIsLogin()
    {
        if (!isset($_SESSION['userid'])) {
            header("Location: /user/login");
            exit();
        }
    }

    /* =========================
       Check if user is admin
       ========================= */
    private function checkIsAdmin()
    {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: /");
            exit();
        }
    }

    public function index()
    {
        // ✅ LOGIN check FIRST
        $this->checkIsLogin();

        // ✅ Then ADMIN check
        $this->checkIsAdmin();

        $userCount = $this->userModel->countUsers();
        $productCount = $this->productModel->countProducts();
        $orderCount = $this->orders->countOrder();
        $cateCount = $this->cate->countcategory();

        $pagination = $this->orders->pagination();
        $start = $pagination['start'];
        $limit = $pagination['limit'];
        $currentPage = $pagination['page'];

        $orders = $this->orders->getAllOrders($start, $limit);

        $totalUsers = $this->userModel->countUsers();
        $totalPages = ceil($totalUsers / $limit);

        require_once __DIR__ . "/../view/admin/index.php";
    }
}
