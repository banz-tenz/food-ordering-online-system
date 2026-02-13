<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Page Title -->
    <h2 class="text-3xl font-bold text-gray-800 mb-8">
        Checkout
    </h2>

    <div class="grid md:grid-cols-3 gap-8">

        <!-- LEFT : Product List -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-md p-6">

            <h3 class="text-xl font-semibold text-gray-700 mb-6">
                Order Items
            </h3>

            <?php foreach ($products as $item): ?>
                <div class="flex justify-between items-center border-b py-4">
                    <div class="flex gap-4 items-center">
                        <img
                            src="data:image/jpeg;base64,<?= base64_encode($item['image']) ?>"
                            class="w-12 h-12  object-cover rounded-md "
                            alt="<?= $item['name'] ?> Image">
                        <div>
                            <p class="font-semibold text-gray-800">
                                <?= htmlspecialchars($item['name']) ?>
                            </p>

                            <p class="text-sm text-gray-500">
                                Quantity: <?= $item['quantity'] ?>
                            </p>
                        </div>
                    </div>

                    <p class="font-semibold text-green-600">
                        $<?= number_format($item['subtotal'], 2) ?>
                    </p>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- RIGHT : Order Summary -->
        <div class="bg-white rounded-xl shadow-md p-6 h-fit">

            <h3 class="text-xl font-semibold text-gray-700 mb-6">
                Order Summary
            </h3>

            <!-- Total -->
            <div class="flex justify-between text-lg font-semibold border-b pb-4">
                <span>Total</span>
                <span class="text-green-600">
                    $<?= number_format($totalPrice, 2) ?>
                </span>
            </div>

            <!-- Info -->
            <p class="text-sm text-gray-500 mt-4">
                Please review your order before confirming.
            </p>

            <!-- Confirm + Cancel Buttons -->
            <div class="flex gap-3 mt-6">

                <!-- Back to Cart -->
                <a href="/user/cart?id=<?= $_SESSION['userid'] ?>"
                    class="w-1/2 text-center border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Back to Cart
                </a>

                <!-- Confirm Order -->
                <form method="POST" action="/user/order/place" class="w-1/2">

                    <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
                    <input type="hidden" name="status" value="Pending">

                    <button
                        class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Confirm Order
                    </button>

                </form>

            </div>


        </div>

    </div>

</div>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>