<?php
require_once __DIR__ . "/../../layout/header.php";
?>
<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Foods</h1>
        <div class="bg-white shadow rounded-xl p-6">
            <a href="/admin/product/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Food</a>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">NB</th>
                        <th class="py-2">Name</th>
                        <th class="py-2">Category</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $food): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2"><?= $food['id'] ?></td>
                            <td class="py-2"><?= $food['name'] ?></td>
                            <td class="py-2"><?= $food['cate_name'] ?></td>
                            <td class="py-2">$<?= $food['price'] ?></td>
                            <td class="py-2 space-x-2">
                                <a href="/admin/product/edit?id=<?= $food['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                                <a href="/admin/product/delete?id=<?= $food['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                                <a href="/admin/product/show?id=<?= $food['id'] ?>"
                                    class="text-green-600 hover:underline">
                                    Detail
                                </a>
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
<?php require_once __DIR__ . "/../../layout/footer.php"; ?>