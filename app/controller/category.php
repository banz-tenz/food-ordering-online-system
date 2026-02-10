<?php
require_once __DIR__ . "/../model/category.php";

class categoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new cateModel();
    }

    public function index()
    {
        $pagination = $this->categoryModel->pagination();
        $start = $pagination['start'];
        $limit = $pagination['limit'];
        $currentPage = $pagination['page'];

        $categories = $this->categoryModel->getAllCate($start, $limit);

        $totalCate = $this->categoryModel->countcategory();
        $totalPages = ceil($totalCate / $limit);


        require_once __DIR__ . "/../view/admin/category/category.php";
    }

    public function create()
    {
        require_once __DIR__ . "/../view/admin/category/create.php";
    }

    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = $_POST['name'];
            $dsc = $_POST['dsc'];

            $this->categoryModel->create($name, $dsc);

            header("location:/admin/category");
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $category = $this->categoryModel->find($id);
        require_once __DIR__ . "/../view/admin/category/edit.php";
    }

    public function update()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = $_POST['name'];
            $dsc = $_POST['dsc'];

            $this->categoryModel->edit($name, $dsc, $id);

            header("location:/admin/category");
            exit();
        }
    }


    public function delete(){
        $id = $_GET['id'];

        $this->categoryModel->delete($id);

        header("location:/admin/category");
        exit();
    }
}
