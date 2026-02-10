<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="flex min-h-screen bg-gray-100">


    <!-- Main Content -->
    <main class="flex-1 flex justify-center items-center p-6 overflow-auto">

        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8">


            <h2 class="text-2xl font-semibold text-center mb-6">Edit Profile</h2>

            <p id="message" class="text-center font-semibold mb-4"></p>

            <form id="editProfileForm" enctype="multipart/form-data">

                <!-- Profile Image -->
                <div class="mb-6 text-center">
                    <img id="profilePreview"
                        src="<?= !empty($user['userProfile']) ? 'data:' . $user['profile_type'] . ';base64,' . base64_encode($user['userProfile']) : '/images/default.png' ?>"
                        alt="Profile Preview"
                        class="w-32 h-32 object-cover rounded-full border border-gray-300 mb-3">
                    <input type="file" name="profile" id="profileInput" accept="image/*" class="mx-auto block">
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" required
                        value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                        value="<?= htmlspecialchars($user['useremail'] ?? '') ?>"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        placeholder="Leave blank to keep current password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="confirm_password"
                        placeholder="Leave blank to keep current password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <!-- Role -->
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-1">Role</label>
                        <select name="role" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-space-tween gap-10">
                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-700 transition block">
                        Update Profile
                    </button>

                    <a href="<?=
                                ($_SESSION['role'] === 'admin')
                                    ? '/admin/users'
                                    : '/user/profile?id=' . $_SESSION['userid'];
                                ?>" class="block py-2 px-4 rounded-sm bg-blue-500 text-white font-semibold">
                        Back
                    </a>

                </div>

            </form>

        </div>
    </main>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        // Profile image preview
        $('#profileInput').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // AJAX submit
        $('#editProfileForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '/user/update-profile',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            $('#message').text(res.message).addClass('text-green-600').removeClass('text-red-600');
                        } else {
                            $('#message').text(res.message).addClass('text-red-600').removeClass('text-green-600');
                        }
                    } catch (e) {
                        $('#message').text('Unexpected error').addClass('text-red-600');
                    }
                },
                error: function() {
                    $('#message').text('AJAX error').addClass('text-red-600');
                }
            });
        });

    });
</script>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>