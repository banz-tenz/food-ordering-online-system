<?php
require_once __DIR__ . "/../../layout/header.php";
?>

<div class="flex min-h-screen bg-gray-100">

    <!-- SIDEBAR -->
    <?php
    require_once __DIR__ . "/../../layout/sidebar.php";
    ?>
    <div class="w-1/2 mx-auto p-6 bg-white rounded-lg shadow">

        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-6">Order Details</h2>

        <!-- Order Info -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-500">Order ID</p>
                <p class="font-semibold"><?= $order[0]['id'] ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Order Date</p>
                <p class="font-semibold"><?= $order[0]['created_at'] ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-3 py-1 rounded-full text-sm
                <?= ($order[0]['status'] === 'pending') ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' ?>">
                    <?= $order[0]['status'] ?>
                </span>
            </div>
            <!-- <div>
                <p class="text-sm text-gray-500">Payment</p>
                <p class="font-semibold">Cash on Delivery</p>
            </div> -->
        </div>

        <!-- Customer Info -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Customer Information</h3>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Name:</strong> <?= $order[0]['username'] ?></p>
                <p><strong>Email:</strong> <?= $order[0]['useremail'] ?></p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Ordered Items</h3>
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Product</th>
                        <th class="border px-3 py-2">Price</th>
                        <th class="border px-3 py-2">Qty</th>
                        <th class="border px-3 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td class="border px-3 py-2">Fried Rice</td>
                        <td class="border px-3 py-2 text-center">$3.00</td>
                        <td class="border px-3 py-2 text-center">2</td>
                        <td class="border px-3 py-2 text-center">$6.00</td>
                    </tr> -->
                    <?php foreach ($order as $ord): ?>
                        <tr>
                            <td class="border px-3 py-2"><?= $ord['name'] ?></td>
                            <td class="border px-3 py-2 text-center"><?= $ord['price'] ?></td>
                            <td class="border px-3 py-2 text-center"><?= $ord['quantity'] ?></td>
                            <td class="border px-3 py-2 text-center"><?= $ord['total_price'] ?></td>
                        </tr>
                        <?php $total += $ord['total_price'] ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="flex justify-end mb-6">
            <p class="text-lg font-bold">
                Total: <span class="text-green-600"><?= $total ?></span>
            </p>
        </div>

        <!-- Actions -->
        <div class="flex justify-between">
            <a href="/admin/order" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                ← Back
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Mark as Completed
            </button>
        </div>

    </div>

</div>


<?php require_once __DIR__ . "/../../layout/footer.php" ?>