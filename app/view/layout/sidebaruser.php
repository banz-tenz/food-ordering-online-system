<aside class="fixed left-0 top-0 h-screen w-72 bg-white shadow-lg flex flex-col justify-between">

    <!-- Logo / Title -->
    <div>
        <div class="px-6 py-6 border-b">
            <h1 class="text-2xl font-bold text-green-600">🍔 Food Order</h1>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-4 space-y-2">

            <a href="/user/home" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= ($_SERVER['REQUEST_URI'] == '/user/home') ? 'bg-green-100 text-green-600 font-medium' : 'hover:bg-gray-100 transition' ?>">
                <span>📋</span>
                Menu
            </a>

            <a href="/user/cart?id=<?= $_SESSION['userid'] ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= (strpos($_SERVER['REQUEST_URI'], '/user/cart') !== false) ? 'bg-green-100 text-green-600 font-medium' : 'hover:bg-gray-100 transition' ?>">
                <span>🛒</span>
                My Cart
            </a>

            <a href="/user/orders?id=<?= $_SESSION['userid'] ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg <?= ($_SERVER['REQUEST_URI'] == '/user/orders') ? 'bg-green-100 text-green-600 font-medium' : 'hover:bg-gray-100 transition' ?>">
                <span>📦</span>
                Order History
            </a>

            <a href="/user/profile?id=<?= $_SESSION['userid'] ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg <?= ($_SERVER['REQUEST_URI'] == '/user/profile?id=' . $_SESSION['userid']) ? 'bg-green-100 text-green-600 font-medium' : 'hover:bg-gray-100 transition' ?>">
                <span>👤</span>
                Profile
            </a>


        </nav>
    </div>

    <!-- Logout -->
    <div class="p-4 border-t">
        <a href="/user/logout" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-500 hover:bg-red-50 transition">
            <span>🚪</span>
            Logout
        </a>
    </div>

</aside>