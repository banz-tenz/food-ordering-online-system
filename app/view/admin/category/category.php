<?php
require_once __DIR__ . "/../../layout/header.php";
?>
<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>
    <main class="flex-1 p-8">

        <h1 class="text-2xl font-bold mb-6">Categories</h1>

        <div class="bg-white shadow rounded-xl p-6">
            <a href="/admin/category/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">Add Category</a>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">ID</th>
                        <th class="py-2">Name</th>
                        <th class="py-2">Description</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2"><?= $cat['id'] ?></td>
                            <td class="py-2"><?= $cat['name'] ?></td>
                            <td class="py-2"><?= $cat['dsc'] ?></td>
                            <td class="py-2 space-x-2">
                                <a href="/admin/category/edit?id=<?= $cat['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                                <!-- Delete button triggers modal -->
                                <button onclick="openDeleteModal(<?= $cat['id'] ?>)"
                                    class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-6 flex justify-center space-x-2">
                <?php if ($totalPages > 1): ?>
                    <!-- Previous button -->
                    <a href="?page=<?= max(1, $currentPage - 1) ?>"
                        class="px-3 py-1 rounded <?= $currentPage == 1 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300' ?>">Prev</a>

                    <!-- Page numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>"
                            class="px-3 py-1 rounded <?= $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Next button -->
                    <a href="?page=<?= min($totalPages, $currentPage + 1) ?>"
                        class="px-3 py-1 rounded <?= $currentPage == $totalPages ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300' ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="deleteModal" onclick="closeDeleteModal()" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
        <p class="mb-6">Are you sure you want to delete this category?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
            <a id="confirmDeleteBtn" href="#" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">Delete</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>