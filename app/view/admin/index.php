<?php require_once __DIR__ . "/../layout/header.php"; ?>

<div class="flex min-h-screen bg-gray-100">

    <!-- SIDEBAR -->
    <?php 
    require_once __DIR__ . "/../layout/sidebar.php";
    ?>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <span class="text-gray-600">Welcome, Admin 👋</span>
        </div>

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Users</p>
                        <h2 class="text-3xl font-bold"><?= $userCount ?></h2>
                    </div>
                    <i class="fa-solid fa-user text-3xl text-blue-500"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Foods</p>
                        <h2 class="text-3xl font-bold"><?= $productCount ?></h2>
                    </div>
                    <i class="fa-solid fa-burger text-3xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Orders</p>
                        <h2 class="text-3xl font-bold"><?= $orderCount ?></h2>
                    </div>
                    <i class="fa-solid fa-cart-shopping text-3xl text-orange-500"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Categories</p>
                        <h2 class="text-3xl font-bold"><?= $cateCount ?></h2>
                    </div>
                    <i class="fa-solid fa-layer-group text-3xl text-purple-500"></i>
                </div>
            </div>

        </div>

        <!-- TABLE / CONTENT AREA -->
        <div class="mt-10 bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Order ID</th>
                        <th class="py-2">Customer</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $index=>$order): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= $index+1 ?></td>
                        <td class="py-2"><?= $order['username'] ?></td>
                        <td class="py-2"><?= $order['total_price'] ?></td>
                        <td class="py-2 <?= ($order['status']==='done')?'text-green-600':'text-orange-600'; ?>">
                            <?= $order['status'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>
