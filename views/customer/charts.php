<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: ../../index.php");
  exit();
}

$user = $_SESSION['user'];

require_once __DIR__ . '/../../controllers/ChartController.php';

$chartController = new ChartController();
$charts = $chartController->getCharts();
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="../../assets/css/style.css">
  <title>Keranjang - Kopi Kenangan Senja</title>
</head>

<body class="bg-gray-900 text-white font-poppins">
  <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-800 bg-opacity-80 py-4 px-6 flex justify-between items-center border-b border-gray-700">
    <a href="home.php" class="text-2xl font-bold italic text-white">kenangan<span class="text-yellow-500">senja</span></a>
    <div class="flex space-x-4 items-center">
      <span class="text-white"><?= htmlspecialchars($user['name']); ?></span>
      <form action="../../controllers/LogoutController.php" method="POST" class="flex items-center">
        <button type="submit" class="hover:text-yellow-500 bg-transparent border-0 p-0 text-white flex items-center">
          <i data-feather="log-out" class="mr-2"></i>
        </button>
      </form>
    </div>
  </nav>

  <main class="mt-20 px-64">
    <h2 class="text-3xl text-center font-bold mb-6">Keranjang Belanja</h1>
      <?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="fixed z-50 top-32 left-1/2 transform -translate-x-1/2 p-4 w-64 rounded-lg shadow-lg text-center <?= $_SESSION['message']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
          <?= $_SESSION['message']['text']; ?>
          <?php unset($_SESSION['message']); ?>
        </div>
      <?php endif; ?>
      <div class="space-y-6">
        <?php if (!empty($charts)): ?>
          <?php foreach ($charts as $chart): ?>
            <div class="flex bg-gray-800 p-6 rounded-lg shadow-lg items-center">
              <img src="../../storage/images/<?= htmlspecialchars($chart['menu_image']); ?>"
                alt="<?= htmlspecialchars($chart['menu_name']); ?>"
                class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
              <div class="ml-6 flex-1">
                <h3 class="text-2xl font-semibold"><?= htmlspecialchars($chart['menu_name']); ?></h3>
                <p class="text-gray-400 mt-2"><?= htmlspecialchars($chart['description']); ?></p>
                <p class="text-yellow-500 mt-4">IDR <?= number_format($chart['price'], 0, ',', '.'); ?></p>
              </div>

              <div class="flex items-center space-x-2">
                <button
                  class="order-button bg-yellow-500 py-2 px-4 rounded-lg hover:bg-yellow-400 w-full"
                  data-id="<?= $chart['menu_id']; ?>"
                  data-name="<?= htmlspecialchars($chart['menu_name']); ?>"
                  data-price="<?= $chart['price']; ?>">
                  Pesan
                </button>
                <form action="../../controllers/DeleteChartController.php" method="POST" class="text-red-500 hover:text-red-700">
                  <input type="hidden" value="<?= $chart['chart_id']; ?>" name="chart_id">
                  <button type="submit"><i data-feather="trash-2" class="w-6 h-6"></i></button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-gray-400">Keranjang belanja masih kosong</p>
        <?php endif; ?>
      </div>
  </main>

  <div id="order-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-12 z-50 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out">
    <form action="../../controllers/OrderController.php" method="POST" enctype="multipart/form-data" class="relative bg-white/60 backdrop-blur-lg p-6 rounded-lg shadow-lg w-full max-w-md">
      <button id="order-close" type="button" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
        <i data-feather="x"></i>
      </button>
      <input type="hidden" id="menu_id" name="menu_id">
      <input type="hidden" value="<?= $user['id']; ?>" name="orderer_id">
      <label for="orderer_name" class="block mt-2">Nama Kamu</label>
      <input type="text" id="orderer_name" value="<?= htmlspecialchars($user['name']); ?>" name="orderer_name" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>
      <label for="quantity" class="block mt-4">Jumlah Pesanan</label>
      <input type="number" id="quantity" name="quantity" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>
      <label for="table_number" class="block mt-4">Nomor Meja</label>
      <input type="text" id="table_number" name="table_number" class="w-full p-2 mt-1 focus:outline-none text-gray-900" required>
      <button type="submit" class="mt-4 w-full py-2 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold rounded-lg transition duration-300 ease-in-out">BUAT PESANAN</button>
    </form>
  </div>

  <script>
    feather.replace();

    setTimeout(() => {
      const message = document.getElementById('message');
      if(message) {
        message.remove();
      }
    }, 2000);

    const orderModal = document.getElementById('order-modal');
    const orderClose = document.getElementById('order-close');
    const menuIdInput = document.getElementById('menu_id');

    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('order-button')) {
        const menuId = event.target.getAttribute('data-id');
        menuIdInput.value = menuId;

        orderModal.classList.remove('opacity-0', 'pointer-events-none');
        orderModal.classList.add('opacity-100', 'pointer-events-auto');
      }
    });

    orderClose.addEventListener('click', function() {
      orderModal.classList.remove('opacity-100', 'pointer-events-auto');
      orderModal.classList.add('opacity-0', 'pointer-events-none');
    });
  </script>
</body>

</html>