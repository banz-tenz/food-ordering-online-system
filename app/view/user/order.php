<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <?php require_once __DIR__ . "/../layout/sidebaruser.php"; ?>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 p-6 ml-72">

        <h2 class="text-3xl font-bold text-gray-800 mb-6">My Orders</h2>

        <?php if (!empty($orders)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 text-gray-700 font-semibold">#</th>
                            <th class="text-left px-6 py-3 text-gray-700 font-semibold">Order ID</th>
                            <th class="text-left px-6 py-3 text-gray-700 font-semibold">Date</th>
                            <th class="text-left px-6 py-3 text-gray-700 font-semibold">Total Price</th>
                            <th class="text-left px-6 py-3 text-gray-700 font-semibold">Status</th>
                            <th class="text-center px-6 py-3 text-gray-700 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $index => $order): ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3"><?= $index + 1 ?></td>
                                <td class="px-6 py-3 font-medium text-gray-800"><?= $order['id'] ?></td>
                                <td class="px-6 py-3 text-gray-600"><?= date('d-m-Y', strtotime($order['created_at'])) ?></td>
                                <td class="px-6 py-3 font-semibold text-green-600">$<?= number_format($order['total_price'], 2) ?></td>
                                <td class="px-6 py-3">
                                    <?php
                                    $statusClass = match ($order['status']) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $statusClass ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <a href="/user/order/details?id=<?= $order['id'] ?>"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                You have no orders yet.
            </div>
        <?php endif; ?>

    </main>

</div>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>