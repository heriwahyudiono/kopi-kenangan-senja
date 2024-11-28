<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}

$user = $_SESSION['user'];

require_once __DIR__ . '/../../controllers/MenuController.php';
$menuController = new MenuController();
$menus = $menuController->getMenus();
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible=" IE="edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Kopi Kenangan Senja</title>
</head>

<body class="bg-gray-900 text-white font-poppins">
  <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-800 bg-opacity-80 py-4 px-6 flex justify-between items-center border-b border-gray-700">
    <a href="#" class="text-2xl font-bold italic text-white">kenangan<span class="text-yellow-500">senja</span></a>
    <div class="flex space-x-4 items-center">
      <span class="hidden md:block"><?= htmlspecialchars($user['name']); ?></span>
      <a href="#" id="user" class="hover:text-yellow-500"><i data-feather="user"></i></a>
      <a href="#" class="md:hidden hover:text-yellow-500"><i data-feather="menu"></i></a>
    </div>
  </nav>

  <aside class="h-screen mt-16 fixed w-64 bg-white text-black shadow-lg hidden md:block">
    <nav class="flex flex-col h-full py-8">
      <a href="home.php" class="hover:bg-yellow-100 py-2 px-8">Menu</a>
      <a href="orders.php" class="hover:bg-yellow-100 py-2 px-8">Pesanan</a>
      <a href="transactions.php" class="hover:bg-yellow-100 py-2 px-8">Transaksi</a>
    </nav>
  </aside>

  <div class="absolute right-10 top-20 cursor-pointer">
    <button id="modal-button" class="flex items-center gap-2 py-2 px-4 bg-yellow-500 hover:bg-yellow-400 text-white text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-300">
        <i data-feather="shopping-cart" class="w-4 h-4"></i>
        Keranjang
    </button>
</div>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="fixed top-24 left-1/2 transform -translate-x-1/2 p-4 w-64 rounded-lg shadow-lg text-center <?= $_SESSION['message']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
      <?= $_SESSION['message']['text']; ?>
      <?php unset($_SESSION['message']); ?>
    </div>
  <?php endif; ?>

  <section class="absolute left-8 md:left-72 top-32">
    <h3 class="text-2xl font-bold mb-4">Menu</h3>
    <p class="text-gray-300 mb-6">Menu yang tersedia</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php foreach ($menus as $menu): ?>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center">
          <div class="flex justify-center gap-4 mb-4">
            <a href="#" class="text-yellow-500 bg-gray-900 p-3 rounded-full hover:bg-yellow-500 hover:text-gray-900 transition duration-300 ease-in-out">
              <i data-feather="shopping-cart"></i>
            </a>
            <button id="order-button" class="bg-yellow-500 p-3 hover:bg-yellow-400 transition duration-300 ease-in-out flex items-center justify-center">Pesan Sekarang</button>
          </div>
          <img src="../../storage/images/<?= $menu['menu_image']; ?>" alt="<?= $menu['menu_name']; ?>" class="rounded-lg mb-4 w-full h-48 object-cover">
          <h3 class="text-xl font-semibold text-white"><?= $menu['menu_name']; ?></h3>
          <p class="text-yellow-500 mt-2">IDR <?= $menu['price']; ?></p>
          <p class="text-gray-400 mt-2"><?= $menu['description']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <div id="modal-order" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-12 z-50 opacity-0 pointer-events-none transition-opacity duration-500 ease-in-out">
    <form action="../../controllers/OrderController.php" method="POST" enctype="multipart/form-data" class="relative bg-white/60 backdrop-blur-lg p-6 rounded-lg shadow-lg w-full max-w-md">
      <button id="order-close" type="button" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
        <i data-feather="x"></i>
      </button>

      <input type="hidden" value="<?= $menu['id']; ?>" name="menu_id">

      <input type="hidden" value="<?= $user['id']; ?>" name="orderer_id">

      <label for="orderer_name" class="block mt-2">Nama Kamu</label>
      <input type="text" id="orderer_name" value="<?= htmlspecialchars($user['name']); ?>" name="orderer_name" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>

      <label for="quantity" class="block mt-4">Jumlah Pesanan</label>
      <input type="text" id="quantity" name="quantity" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>

      <label for="table_number" class="block mt-4">Nomor Meja</label>
      <input type="text" id="table_number" name="table_number" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>

      <button type="submit" class="mt-4 w-full py-2 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold rounded-lg transition duration-300 ease-in-out">BUAT PESANAN</button>
    </form>
  </div>

  <div id="update-menu" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-12 z-50 opacity-0 pointer-events-none transition-opacity duration-500 ease-in-out">
    <form action="../controllers/MenuController.php" method="POST" enctype="multipart/form-data" class="relative bg-white/60 backdrop-blur-lg p-6 rounded-lg shadow-lg w-full max-w-md">
      <button id="update-modal-close" type="button" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
        <i data-feather="x"></i>
      </button>

      <input type="hidden" id="update-menu-id" name="id" value="<?= $menu['id']; ?>">

      <label for="update-menu-name" class="block mt-2">Nama Menu</label>
      <input type="text" id="update-menu-name" name="menu_name" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>

      <label for="update-description" class="block mt-4">Deskripsi</label>
      <textarea id="update-description" name="description" class="w-full p-2 mt-1 focus:outline-none text-gray-900" rows="2"></textarea>

      <label for="update-price" class="block mt-4">Harga</label>
      <input type="text" id="update-price" name="price" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>

      <label for="update-menu-image" class="block mt-4">Gambar Menu</label>
      <input type="file" id="update-menu-image" name="menu_image" class="w-full p-2 mt-1 text-gray-900">
      <button type="submit" class="mt-4 w-full py-2 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold rounded-lg transition duration-300 ease-in-out">UPDATE</button>
    </form>
  </div>

  <script>
    feather.replace();

    const orderButton = document.getElementById('order-button');
    const modalOrder = document.getElementById('modal-order');
    const orderClose = document.getElementById('order-close');

    orderButton.addEventListener('click', function() {
      modalOrder.classList.remove('opacity-0', 'pointer-events-none');
      modalOrder.classList.add('opacity-100', 'pointer-events-auto');
    });

    orderClose.addEventListener('click', function() {
      modalOrder.classList.remove('opacity-100', 'pointer-events-auto');
      modalOrder.classList.add('opacity-0', 'pointer-events-none');
    });
  </script>

</body>

</html>