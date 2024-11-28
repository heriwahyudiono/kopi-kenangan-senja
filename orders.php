<?php
require_once __DIR__ . '/controllers/OrderController.php';

$orderController = new OrderController();

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$orders = $orderController->getOrders($searchTerm);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Daftar Pesanan</title>
</head>
<body class="bg-gray-50 p-6">
    <div class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Daftar Pesanan</h1>

        <form method="GET" action="orders.php" class="mb-6 flex">
            <input type="text" name="search" placeholder="Cari berdasarkan nama..."
                value="<?= htmlspecialchars($searchTerm); ?>"
                class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Cari</button>
        </form>

        <table class="min-w-full bg-white border-collapse rounded-lg overflow-hidden shadow-md">
            <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-teal-500 text-white">
                    <th class="px-6 py-3 text-left">Nama Pemesan</th>
                    <th class="px-6 py-3 text-left">Menu</th>
                    <th class="px-6 py-3 text-left">Jumlah</th>
                    <th class="px-6 py-3 text-left">Nomor Meja</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr class="border-b hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($order['orderer_name']); ?></td>
                            <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($order['menu_name']); ?></td>
                            <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($order['quantity']); ?></td>
                            <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($order['table_number']); ?></td>
                            <td class="px-6 py-4 text-green-600 font-semibold"><?= htmlspecialchars($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center px-6 py-4 text-gray-500">Pesanan tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>