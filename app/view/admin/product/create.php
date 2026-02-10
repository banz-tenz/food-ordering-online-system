<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>

    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Create Product</h1>

        <div class="bg-white shadow rounded-xl p-6 max-w-xl">
            <form action="/admin/product/create" method="POST" enctype="multipart/form-data" class="space-y-5">

                <!-- Product Name -->
                <div>
                    <label class="block mb-1 font-medium">Product Name</label>
                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter product name">
                </div>

                <!-- Category -->
                <div>
                    <label class="block mb-1 font-medium">Category</label>
                    <select
                        name="category_id"
                        required
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" selected disabled>-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>">
                                <?= $cat['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block mb-1 font-medium">Price ($)</label>
                    <input
                        type="number"
                        name="price"
                        step="0.01"
                        required
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="0.00">
                </div>

                <!-- Stock -->
                <div>
                    <label class="block mb-1 font-medium">Stock</label>
                    <input
                        type="number"
                        name="stock"
                        required
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Available quantity">
                </div>

                <!-- Image -->
                <div>
                    <label class="block mb-1 font-medium">Product Image</label>
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="w-full border rounded-lg px-4 py-2 bg-white">
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                        Save
                    </button>
                    <a href="/admin/product" class="px-6 py-2 rounded-lg border hover:bg-gray-100">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>