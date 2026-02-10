<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>

    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow rounded-xl p-6 max-w-xl">
            <form action="/admin/product/edit?id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-5">

                <!-- Name -->
                <div>
                    <label class="block mb-1 font-medium">Product Name</label>
                    <input type="text" name="name"
                        value="<?= htmlspecialchars($product['name']) ?>"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Category -->
                <div>
                    <label class="block mb-1 font-medium">Category</label>
                    <select name="category_id" class="w-full border rounded-lg px-4 py-2">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= $cat['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block mb-1 font-medium">Price</label>
                    <input type="number" step="0.01" name="price"
                        value="<?= $product['price'] ?>"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Stock -->
                <div>
                    <label class="block mb-1 font-medium">Stock</label>
                    <input type="number" name="stock"
                        value="<?= $product['stock'] ?>"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <!-- Image -->
                <div class="bg-gray-50 p-4 rounded-xl border">
                    <label class="block text-sm font-semibold mb-2">
                        Product Image
                    </label>

                    <!-- Current Image Preview -->
                    <?php if (!empty($product['image'])): ?>
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-1">Current image</p>
                            <img
                                src="data:image/jpeg;base64,<?= base64_encode($product['image']) ?>"
                                class="w-32 h-32 object-cover rounded-lg border"
                                alt="Current Product Image">
                        </div>
                    <?php endif; ?>

                    <!-- Upload New Image -->
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="block w-full text-sm text-gray-700
               file:mr-4 file:py-2 file:px-4
               file:rounded-lg file:border-0
               file:bg-blue-50 file:text-blue-600
               hover:file:bg-blue-100
               border rounded-lg px-3 py-2">

                    <p class="text-xs text-gray-500 mt-2">
                        Leave empty to keep current image
                    </p>
                </div>


                <button class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                    Update
                </button>
                <a href="/admin/product" class="px-4 py-2 rounded-lg bg-blue-500 ml-8 text-white">Concel</a>
            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>