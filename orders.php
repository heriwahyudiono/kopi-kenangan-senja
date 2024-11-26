<?php
require_once __DIR__ . '/controllers/OrderController.php';

$orderController = new OrderController();
$orders = $orderController->getOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Orders</title>
</head>
<body class="bg-gray-50 p-6">

<?php if (isset($_SESSION['message'])): ?>
    <div class="fixed top-16 left-1/2 transform -translate-x-1/2 p-4 w-80 rounded-lg shadow-lg text-center <?= $_SESSION['message']['type'] === 'success' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?> animate-fade-in">
        <?= $_SESSION['message']['text']; ?>
        <?php unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-semibold mb-6 text-gray-800">Daftar Pesanan</h1>

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
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">Tidak ada pesanan lain yang masuk</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
