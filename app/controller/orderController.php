<?php
require_once __DIR__ . "/../model/order.php";

class orderController
{
    private $orderModels;

    public function __construct()
    {
        $this->orderModels = new orderModel();
    }

    public function index()
    {
        $pagination = $this->orderModels->pagination();
        $start = $pagination['start'];
        $limit = $pagination['limit'];
        $currentPage = $pagination['page'];

        $orders = $this->orderModels->getAllOrders($start, $limit);

        $totalUsers = $this->orderModels->countOrder();
        $totalPages = ceil($totalUsers / $limit);

        require_once __DIR__ . "/../view/admin/order/order.php";
    }

    public function show()
    {
        $id = $_GET['id'];
        $total = 0;
        $order = $this->orderModels->findOrder($id);
        require_once __DIR__ . "/../view/admin/order/view.php";
    }
}
