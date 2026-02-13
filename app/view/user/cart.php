<?php
require_once __DIR__ . "/../layout/header.php";
?>
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <?php require_once __DIR__ . "/../layout/sidebaruser.php"; ?>
    <main class="flex-1 bg-gray-100 p-6 ml-72">
        `<h2>Your Shopping Cart</h2>

        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Cart</h2>

            <?php if (!empty($products)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-left">Price</th>
                                <th class="px-4 py-2 text-left">Quantity</th>
                                <th class="px-4 py-2 text-left">Total Price</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $index => $item): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $index + 1 ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($item['name']) ?></td>
                                    <td class="px-4 py-2"><?= number_format($item['price'], 2) ?> $</td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-2">

                                            <!-- Minus -->
                                            <button
                                                class="minus-btn flex items-center justify-center w-6 h-6 text-white bg-red-500 rounded-full hover:bg-red-600 transition <?= $item['quantity'] == 1 ? 'opacity-40 cursor-not-allowed' : '' ?>"
                                                data-id="<?= $item['id'] ?>">
                                                <i class="fa-solid fa-minus text-xs"></i>
                                            </button>

                                            <!-- Quantity -->
                                            <span class="font-semibold px-2"><?= $item['quantity'] ?></span>

                                            <!-- Plus -->
                                            <button
                                                class="plus-btn flex items-center justify-center w-6 h-6 text-white bg-green-500 rounded-full hover:bg-green-600 transition"
                                                data-id="<?= $item['id'] ?>">
                                                <i class="fa-solid fa-plus text-xs"></i>
                                            </button>

                                        </div>
                                    </td>

                                    <td class="px-4 py-2 font-semibold"><?= number_format($item['subtotal'], 2) ?> $</td>
                                    <td class="px-4 py-2">
                                        <form method="post" action="/user/cart/remove">
                                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                            <button type="button" class="remove-btn bg-red-500 text-white px-4 py-2 rounded-sm cursor-pointer hover:bg-red-600" data-id="<?= $item['id'] ?>">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="4" class="px-4 py-2 text-right">Total</td>
                                <td class="px-4 py-2"><?= number_format($totalPrice, 2) ?> $</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="/user/checkout" class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition font-semibold">
                        Proceed to Checkout
                    </a>
                </div>

            <?php else: ?>
                <p class="text-gray-500">Your cart is empty.</p>
            <?php endif; ?>
        </div>


    </main>





</div>



<script>
    document.querySelectorAll(".remove-btn").forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            const productId = this.dataset.id;

            fetch("/user/cart/remove", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "product_id=" + productId
                })
                .then(res => res.text())
                .then(() => {
                    location.reload();
                });
        });
    });

    // Increase quantity
    document.querySelectorAll(".plus-btn").forEach(btn => {
        btn.addEventListener("click", function() {

            fetch("/user/cart/increase", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "product_id=" + this.dataset.id
                })
                .then(() => location.reload());
        });
    });

    // Decrease quantity
    document.querySelectorAll(".minus-btn").forEach(btn => {
        btn.addEventListener("click", function() {

            fetch("/user/cart/decrease", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "product_id=" + this.dataset.id
                })
                .then(() => location.reload());
        });
    });
</script>
<?php
require_once __DIR__ . "/../layout/footer.php";
?>