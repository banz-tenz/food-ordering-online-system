<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <?php require_once __DIR__ . "/../layout/sidebaruser.php"; ?>

    <!-- Main Content -->
    <main class="flex-1 flex justify-center items-center p-6 overflow-auto">

        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8">

            <h2 class="text-2xl font-semibold text-center mb-6">User Profile</h2>

            <!-- Profile Image -->
            <div class="flex justify-center mb-6">
                <?php if (!empty($user['userProfile'])): ?>
                    <img src="data:<?= $user['profile_type'] ?>;base64,<?= base64_encode($user['userProfile']) ?>"
                        alt="Profile Picture"
                        class="w-32 h-32 rounded-full object-cover border-4 border-green-500">
                <?php else: ?>
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-4xl border-4 border-gray-300">
                        <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- User Info -->
            <div class="text-center space-y-2">
                <div>
                    <span class="font-semibold text-gray-700">Username:</span>
                    <span class="text-gray-800"><?= htmlspecialchars($user['username'] ?? 'User') ?></span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">Email:</span>
                    <span class="text-gray-800"><?= htmlspecialchars($user['useremail'] ?? 'user@example.com') ?></span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">Password:</span>
                    <span class="text-gray-800"><?= str_repeat('*', 8) ?></span> <!-- Masked -->
                </div>
                <div>
                    <span class="font-semibold text-gray-700">Role:</span>
                    <span class="text-gray-800 capitalize"><?= htmlspecialchars($user['role'] ?? 'user') ?></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-center space-x-4">
                <a href="/user/edit-profile"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Edit Profile
                </a>
                <a href="/user/logout"
                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Logout
                </a>
            </div>

        </div>
    </main>
</div>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>