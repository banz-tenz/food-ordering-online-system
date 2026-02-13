<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <?php require_once __DIR__ . "/../layout/sidebaruser.php"; ?>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 p-6 ml-72">

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Order #<?= $orderItems[0]['order_id'] ?></h2>
            <p class="text-gray-600 mb-2">Placed on: <?= date('d-m-Y H:i', strtotime($orderItems[0]['created_at'])) ?></p>
            <p>Status:
                <?php
                $status = $orderItems[0]['status'];
                $statusClass = match ($status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                };
                ?>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $statusClass ?>">
                    <?= ucfirst($status) ?>
                </span>
            </p>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">#</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Product</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Price</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Quantity</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $index => $item): ?>
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-3"><?= $index + 1 ?></td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-start gap-4">
                                        <img
                                            src="data:image/jpeg;base64,<?= base64_encode($item['image']) ?>"
                                            class="w-12 h-12  object-cover rounded-md "
                                            alt="Image">
                                        <span>
                                            <?= htmlspecialchars($item['product_name']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-green-600 font-semibold">$<?= number_format($item['product_price'], 2) ?></td>
                                <td class="px-6 py-3"><?= $item['quantity'] ?></td>
                                <td class="px-6 py-3 font-semibold">$<?= number_format($item['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right text-xl font-bold text-gray-800">
                Total: $<?= number_format($totalPrice, 2) ?>
            </div>

            <div class="mt-6">
                <a href="/user/orders?id=<?= $_SESSION['userid'] ?>"
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition font-semibold">
                    Back to Orders
                </a>
            </div>
        </div>

    </main>

</div>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>