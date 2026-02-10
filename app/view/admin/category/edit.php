<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>

    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Edit Category</h1>

        <!-- Error Message -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow rounded-xl p-6 max-w-lg">
            <form action="/admin/category/create?id=<?= $category['id'] ?>" method="POST" class="space-y-5">

                <!-- Name -->
                <div>
                    <label class="block mb-1 font-medium">Category Name</label>
                    <input 
                        type="text" 
                        name="name"
                        value="<?= htmlspecialchars($category['name']) ?>"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Description -->
                <div>
                    <label class="block mb-1 font-medium">Description</label>
                    <textarea 
                        name="dsc" 
                        rows="4"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                    ><?= htmlspecialchars($category['dsc']) ?></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                        Update
                    </button>
                    <a href="/admin/category" class="border px-6 py-2 rounded-lg hover:bg-gray-100">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>
