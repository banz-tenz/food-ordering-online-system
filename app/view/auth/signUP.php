<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-10 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">Create User</h2>

        <!-- Message Container -->
        <p id="message" class="text-center font-semibold mb-4"></p>

        <form id="form" enctype="multipart/form-data">

            <!-- Username -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Username</label>
                <input
                    type="text"
                    name="username"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter username">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter email"
                    id="email">
                <p class="text-red-600 text-xs invisible" id="erroremail">Email must contain @</p>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter password"
                    id="password">
                <p id="errorPs" class="text-red-600 text-xs invisible">Password must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Confirm Password</label>
                <input
                    type="password"
                    name="confirm_password"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Confirm password"
                    id="confirmpw">
                <p id="errorPasCf" class="text-red-600 text-xs invisible">Passwords do not match</p>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Role</label>
                <select
                    name="role"
                    required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select role</option>
                    <option value="admin">Admin</option>
                    <option value="user" selected>User</option>
                </select>
            </div>

            <!-- Profile Image -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Profile Image</label>

                <!-- Preview -->
                <div class="mb-2">
                    <img id="profilePreview" src="" alt="Profile Preview" class="w-32 h-32 object-cover rounded-full border border-gray-300 hidden">
                </div>

                <!-- File Input -->
                <input
                    type="file"
                    name="profile"
                    accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="profileInput">
            </div>


            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Save User
            </button>

            <a href="../user/login" class="block text-center mt-4 text-blue-600 hover:underline">Already have an account? Login</a>

        </form>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        // Profile image preview
        $('#profileInput').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePreview').attr('src', e.target.result).removeClass('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                $('#profilePreview').attr('src', '').addClass('hidden');
            }
        });

        // Form submit
        $('#form').on('submit', function(e) {
            e.preventDefault();

            // Clear previous messages
            $('#message').text('').removeClass('text-red-600 text-green-600');
            $('#erroremail, #errorPs, #errorPasCf').addClass('invisible');

            // Front-end validation (trimmed)
            let email = $('#email').val().trim();
            let password = $('#password').val();
            let confirmPassword = $('#confirmpw').val();
            let valid = true;

            if (!email.includes('@')) {
                $('#erroremail').removeClass('invisible');
                valid = false;
            }
            if (password.length < 8) {
                $('#errorPs').removeClass('invisible');
                valid = false;
            }
            if (password !== confirmPassword) {
                $('#errorPasCf').removeClass('invisible');
                valid = false;
            }

            if (!valid) return; // stop submit if invalid

            // AJAX submit
            let formData = new FormData(this);

            $.ajax({
                url: '/user/create',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            $('#message').text(res.message).addClass('text-green-600');
                            $('#form')[0].reset();
                            $('#profilePreview').attr('src', '').addClass('hidden'); // hide preview after reset
                        } else {
                            $('#message').text(res.message).addClass('text-red-600');
                        }
                    } catch (e) {
                        $('#message').text('Unexpected error.').addClass('text-red-600');
                    }
                },
                error: function() {
                    $('#message').text('AJAX error.').addClass('text-red-600');
                }
            });

        });

    });
</script>
<?php
require_once __DIR__ . "/../layout/footer.php";
?>