<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Food Detail</h1>
            <a href="/admin/product" class="text-blue-500 hover:underline">← Back</a>
        </div>

        <div class="flex-col items-center justify-center bg-white shadow rounded-xl p-6 max-w-2xl h-full">

            <!-- Image -->
            <?php if (!empty($food['image'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($food['image']) ?>"
                    alt="<?= $food['name'] ?>"
                    class="w-64 h-64 object-cover rounded-lg border">

            <?php endif; ?>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-500">Name</p>
                    <p class="font-semibold text-lg"><?= $food['name'] ?></p>
                </div>

                <div>
                    <p class="text-gray-500">Category</p>
                    <p class="font-semibold text-lg"><?= $food['category_name'] ?></p>
                </div>

                <div>
                    <p class="text-gray-500">Price</p>
                    <p class="font-semibold text-lg">$<?= $food['price'] ?></p>
                </div>

                <div>
                    <p class="text-gray-500">Stock</p>
                    <p class="font-semibold text-lg"><?= $food['stock'] ?></p>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="/admin/product/edit?id=<?= $food['id'] ?>"
                    class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600">
                    Edit
                </a>

                <a href="/admin/product"
                    class="border px-5 py-2 rounded-lg hover:bg-gray-100">
                    Back
                </a>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>