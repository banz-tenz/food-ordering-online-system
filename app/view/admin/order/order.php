<?php
require_once __DIR__ . "/../../layout/header.php";
?>

<div class="flex min-h-screen bg-gray-100">

    <!-- SIDEBAR -->
    <?php
    require_once __DIR__ . "/../../layout/sidebar.php";
    ?>
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Orders</h1>
        <div class="bg-white shadow rounded-xl p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Order ID</th>
                        <th class="py-2">Customer</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2"><?= $order['id'] ?></td>
                            <td class="py-2"><?= $order['username'] ?></td>
                            <td class="py-2">$<?= $order['total_price'] ?></td>
                            <td class="py-2">
                                <span class=" font-semibold <?= ($order['status']==='done')?"text-green-600":"text-orange-500"; ?>"><?= $order['status'] ?></span>
                            </td>
                            <td class="py-2">
                                <a href="/admin/order/show?id=<?= $order['id'] ?>" class="text-blue-500 hover:underline">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php require_once __DIR__ . "/../../layout/footer.php" ?>