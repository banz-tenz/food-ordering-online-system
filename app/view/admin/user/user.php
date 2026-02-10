<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<div class="flex min-h-screen bg-gray-100">
    <?php require_once __DIR__ . "/../../layout/sidebar.php"; ?>

    <main class="flex-1 p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Users</h1>
            <a href="/admin/user/create" class="px-4 py-2 bg-green-500 rounded-lg text-white font-semibold hover:bg-green-600 transition">
                Add User
            </a>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">ID</th>
                        <th class="py-2">Username</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Role</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2"><?= $user['id'] ?></td>
                            <td class="py-2"><?= $user['username'] ?></td>
                            <td class="py-2"><?= $user['useremail'] ?></td>
                            <td class="py-2"><?= $user['role'] ?></td>
                            <td class="py-2 space-x-2">
                                <a href="/user/edit-profile?id=<?= $user['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                                <a href="/admin/users/delete/<?= $user['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination OUTSIDE table -->
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