<?php



require_once __DIR__ . "/../model/product.php";
require_once __DIR__ . "/../model/category.php";

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $table;

    public function __construct()
    {
        $this->productModel = new ProductModel;
        $this->categoryModel = new cateModel;
    }

    public function index()
    {
        $pagination = $this->productModel->pagination();
        $start = $pagination['start'];
        $limit = $pagination['limit'];
        $currentPage = $pagination['page'];

        $products = $this->productModel->getAll($start, $limit);

        $totalUsers = $this->productModel->countProducts();
        $totalPages = ceil($totalUsers / $limit);

        require_once __DIR__ . "/../view/admin/product/product.php";
    }

    public function create()
    {
        $categories = $this->categoryModel->getAllCategories();

        require_once __DIR__ . "/../view/admin/product/create.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = $_POST['name'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];

            $image = null;
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            }



            $this->productModel->create($name, $price, $category_id, $image, $stock);

            header("location:/admin/product");
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $product = $this->productModel->find($id);
        $categories = $this->categoryModel->getAllCategories();

        require_once __DIR__ . "/../view/admin/product/edit.php";
    }

    public function update()
    {
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $name        = $_POST['name'];
            $category_id = $_POST['category_id'];
            $price       = $_POST['price'];
            $stock       = $_POST['stock'];

            // default: do not update image
            $image = null;

            // if user uploads new image
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            }

            $this->productModel->edit(
                $name,
                $price,
                $category_id,
                $stock,
                $id,
                $image
            );

            header("location:/admin/product");
            exit();
        }
    }

    public function show()
    {
        $id = $_GET['id'];

        $food = $this->productModel->find($id);

        if (!$food) {
            header("location:/admin/product");
            exit();
        }

        require_once __DIR__ . "/../view/admin/product/show.php";
        require_once __DIR__ . "/../view/user/index.php";
    }
}
