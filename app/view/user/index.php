<?php
require_once __DIR__ . "/../layout/header.php";
?>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <?php require_once __DIR__ . "/../layout/sidebaruser.php"; ?>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 p-6 ml-72">

        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Welcome, <?= $_SESSION['username'] ?? 'User' ?>!</h2>
            <p class="text-gray-600 mt-2">Explore our menu and place your order quickly.</p>
        </div>

        <!-- Quick Actions / Categories -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
            <a href="#"
                data-cateid="0"
                class="category-filter bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center hover:bg-green-50 transition">

                <span class="font-semibold text-gray-700">
                    All
                </span>
            </a>
            <?php foreach ($categories as $category): ?>
                <a href="#"
                    data-cateid="<?= $category['id'] ?>"
                    class="category-filter bg-white shadow rounded-lg p-4 flex flex-col items-center justify-center hover:bg-green-50 transition">

                    <span class="font-semibold text-gray-700">
                        <?= $category['name'] ?>
                    </span>
                </a>

            <?php endforeach; ?>
        </div>

        <!-- Featured Menu Section -->
        <div id="menuContainer">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Featured Menu</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="products">
                <?php foreach ($featured as $item): ?>
                    <div class="bg-white shadow rounded-lg overflow-hidden hover:scale-105 transform transition duration-300">
                        <img
                            src="data:image/jpeg;base64,<?= base64_encode($item['image']) ?>"
                            class="w-32 h-32 object-cover rounded-lg border"
                            alt="<?= $item['name'] ?> Image">
                        <div class="p-4">
                            <h4 class="font-semibold text-lg text-gray-800"><?= $item['name'] ?></h4>
                            <p class="text-green-600 font-bold mt-1"><?= $item['price'] ?></p>
                            <a href="/user/cart/add.php?id=<?= $item['id'] ?>"
                                class="mt-3 inline-block w-full text-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Add to Cart
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center mt-6 space-x-2">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>"
                            class="px-3 py-1 rounded <?= ($i == $page) ? 'bg-green-600 text-white' : 'bg-white border hover:bg-gray-100' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

    </main>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const categoryLinks = document.querySelectorAll(".category-filter");
        const productsDiv = document.getElementById("products");

        categoryLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const cateId = this.dataset.cateid;

                fetch(`/user/filter?cateId=${cateId}`)
                    .then(response => response.text())
                    .then(html => {
                        productsDiv.innerHTML = html;
                    });
            });
        });
    });
</script>

<?php
require_once __DIR__ . "/../layout/footer.php";
?>