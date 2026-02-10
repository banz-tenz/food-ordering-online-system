<?php
// get current URL path
$currentPath = $_SERVER['REQUEST_URI'];

function isActive($path, $currentPath)
{
    return strpos($currentPath, $path) !== false
        ? 'bg-gray-700'
        : '';
}
?>

<aside class="w-64 bg-gray-900 text-white min-h-screen">
    <div class="p-6 text-xl font-bold border-b border-gray-700">
        Admin Panel
    </div>

    <nav class="mt-6 space-y-1">

        <a href="/admin/home"
           class="flex items-center px-6 py-3 hover:bg-gray-700 <?= isActive('/admin/home', $currentPath) ?>">
            <i class="fa-solid fa-house mr-3"></i>
            Dashboard
        </a>

        <a href="/admin/users"
           class="flex items-center px-6 py-3 hover:bg-gray-700 <?= isActive('/admin/users', $currentPath) ?>">
            <i class="fa-solid fa-user mr-3"></i>
            Users
        </a>

        <a href="/admin/category"
           class="flex items-center px-6 py-3 hover:bg-gray-700 <?= isActive('/admin/category', $currentPath) ?>">
            <i class="fa-solid fa-layer-group mr-3"></i>
            Categories
        </a>

        <a href="/admin/product"
           class="flex items-center px-6 py-3 hover:bg-gray-700 <?= isActive('/admin/product', $currentPath) ?>">
            <i class="fa-brands fa-product-hunt mr-3"></i>
            Products
        </a>

        <a href="/admin/order"
           class="flex items-center px-6 py-3 hover:bg-gray-700 <?= isActive('/admin/order', $currentPath) ?>">
            <i class="fa-solid fa-cart-plus mr-3"></i>
            Orders
        </a>

        <a href="/user/logout"
           class="flex items-center px-6 py-3 hover:bg-red-600 mt-6">
            <i class="fa-solid fa-right-from-bracket mr-3"></i>
            Logout
        </a>

    </nav>
</aside>
