<?php
// session_start();
require_once __DIR__ . "/../model/user.php";

class UsersController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
        // if logged in → continue (NO redirect here)
    }

    /* =========================
       Check if user is admin
       ========================= */
    private function checkIsAdmin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /user/login");
            exit();
        }
    }

    /* =========================
       Admin home / list users
       ========================= */
    public function index()
    {
        $this->checkIsLogin();
        $this->checkIsAdmin();

        $pagination = $this->userModel->pagination();
        $start = $pagination['start'];
        $limit = $pagination['limit'];
        $currentPage = $pagination['page'];

        $users = $this->userModel->getAllUser($start, $limit);

        $totalUsers = $this->userModel->countUsers();
        $totalPages = ceil($totalUsers / $limit);

        require_once __DIR__ . "/../view/admin/user/user.php";
    }

    /* =========================
       Register form
       ========================= */
    public function create()
    {
        if (isset($_SESSION['userid'])) {
            header("Location: /admin/home");
            exit();
        }

        require_once __DIR__ . "/../view/auth/signUP.php";
    }

    /* =========================
       Store user (register)
       ========================= */
    // public function store()
    // {
    //     $username = htmlspecialchars($_POST['username']);
    //     $email = htmlspecialchars($_POST['email']);
    //     $password = htmlspecialchars($_POST['password']);
    //     $confirmPassword = htmlspecialchars($_POST['confirm_password']);

    //     // check confirm password
    //     if ($password !== $confirmPassword) {
    //         header("Location: /user/create?message=passwordnotmatch");
    //         exit();
    //     }

    //     // check if email already exists
    //     $exists = $this->userModel->checkEmail($email);
    //     if ($exists) {
    //         header("Location: /user/login?message=alreadyRegistered");
    //         exit();
    //     }

    //     // create user
    //     $this->userModel->createUser($username, $email, $password);

    //     header("Location: /user/login");
    //     exit();
    // }
    public function store()
    {
        // Check if request is AJAX
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Validate password match
        if ($password !== $confirmPassword) {
            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
                exit();
            } else {
                header("Location: /user/create?message=passwordnotmatch");
                exit();
            }
        }

        // Check email exists
        if ($this->userModel->checkEmail($email)) {
            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
                exit();
            } else {
                header("Location: /user/login?message=alreadyRegistered");
                exit();
            }
        }

        /* ===== IMAGE UPLOAD ===== */
        $imageData = null;
        $imageType = null;
        $imageName = null;

        if (!empty($_FILES['profile']['tmp_name'])) {

            $allowed = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($_FILES['profile']['type'], $allowed)) {
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid image type']);
                    exit();
                } else {
                    header("Location: /user/create?message=invalidImage");
                    exit();
                }
            }

            if ($_FILES['profile']['size'] > 2000000) {
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => 'Image too large']);
                    exit();
                } else {
                    header("Location: /user/create?message=imageTooLarge");
                    exit();
                }
            }

            $imageData = file_get_contents($_FILES['profile']['tmp_name']);
            $imageType = $_FILES['profile']['type'];
            $imageName = $_FILES['profile']['name'];
        }

        $this->userModel->createUser(
            $username,
            $email,
            $password,
            $imageData,
            $imageType,
            $imageName
        );

        if ($isAjax) {
            echo json_encode(['status' => 'success', 'message' => 'User created successfully']);
            header("Location: /user/login");
        } else {
            header("Location: /user/login");
        }
        exit();
    }



    /* =========================
       Login form
       ========================= */
    public function loginForm()
    {
        if (isset($_SESSION['userid'])) {
            header("Location: /admin/home");
            exit();
        }

        require_once __DIR__ . "/../view/auth/signIn.php";
    }

    /* =========================
       Login process
       ========================= */
    public function login()
    {
        $email = trim($_POST['useremail']);
        $password = trim($_POST['userpassword']);

        $user = $this->userModel->verifyUser($email, $password);

        if (!$user) {
            header("Location: /user/login?message=wrongLogin");
            exit();
        }

        // save session
        $_SESSION['userid'] = $user['id'];
        $_SESSION['role'] = $user['role']; // admin / user
        $_SESSION['username'] = $user['username'];

        if ($user['role'] === 'admin') {
            header("Location: /admin/home");
        } else {
            header("Location: /user/home");
        }
        exit();
    }

    /*==========================
     Edit user
    ==========================*/
    public function show(){
        $id = $_GET['id'];
        $user = $this->userModel->findUserById($id);
        require_once __DIR__ . "/../view/user/profile.php";
    }




    /* =========================
       Logout
       ========================= */
    public function logout()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear session variables
        $_SESSION = [];

        // Destroy session
        session_destroy();

        // Redirect to login page
        header("Location: /user/login");
        exit();
    }
}
