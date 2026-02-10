<?php
require_once __DIR__ . "/../layout/header.php";
$message = isset($_GET['message'])?$_GET['message']:"";
?>

<form action="/user/login" method="POST" class="max-w-lg mx-auto my-auto mt-10 bg-white p-10 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-center mb-6">
        Login user
    </h2>
    <?php if($message==='logined') :?>
        <p class="text-red-600 text-center font-semibold">
            your email is already registered 
        </p>
    <?php endif;?>
    <div class="mb-4">
        <label for="useremail" class="block text-gray-700 mb-1">Email</label>
        <input type="email"
        name="useremail"
        required
        placeholder="Enter your email..."
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>

    <div class="mb-4">
        <label for="userpassword" class="block text-gray-700 mb-1">Password</label>
        <input type="password"
        name="userpassword"
        required
        placeholder="Enter your password..."
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>
    <button type="submit" class="w-full bg-blue-600 px-4 py-2 border border-none rounded-md font-semibold text-white">
        Login
    </button>
    <a href="create" class="block text-center hover:underline mt-4">Don't have account! register?</a>
</form>


<?php
require_once __DIR__ . "/../layout/footer.php";
?>