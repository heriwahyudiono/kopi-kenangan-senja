<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user'];

require_once __DIR__ . '/../controllers/TransactionController.php';

$transactionController = new TransactionController();
$transactions = $transactionController->getTransactions();
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <title>Transactions - Kopi Kenangan Senja</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-800 bg-opacity-90 py-4 px-6 flex justify-between items-center shadow-md">
        <a href="#" class="text-2xl font-bold italic text-white">
            kenangan<span class="text-yellow-500">senja</span>
        </a>
        <div class="flex space-x-4 items-center text-white">
            <span class="hidden md:block font-medium"><?= htmlspecialchars($user['name']); ?></span>
            <a href="#" id="user" class="hover:text-yellow-500"><i data-feather="user"></i></a>
            <a href="#" class="md:hidden hover:text-yellow-500"><i data-feather="menu"></i></a>
        </div>
    </nav>

    <aside class="fixed top-16 left-0 w-64 h-full bg-white shadow-lg hidden md:block">
        <nav class="flex flex-col h-full py-8">
            <a href="home.php" class="hover:bg-yellow-100 py-3 px-8 font-medium text-gray-700">Menu</a>
            <a href="orders.php" class="hover:bg-yellow-100 py-3 px-8 font-medium text-gray-700">Pesanan</a>
            <a href="transactions.php" class="hover:bg-yellow-100 py-3 px-8 font-medium text-gray-700">Transaksi</a>
        </nav>
    </aside>

    <div class="container mx-auto mt-32 px-4 md:ml-72">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Transaksi</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-left">
                        <th class="px-6 py-3 border">Nama Pemesan</th>
                        <th class="px-6 py-3 border">Menu</th>
                        <th class="px-6 py-3 border">Jumlah</th>
                        <th class="px-6 py-3 border">Harga</th>
                        <th class="px-6 py-3 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-4"><?= htmlspecialchars($transaction['orderer_name']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($transaction['menu_name']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($transaction['quantity']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($transaction['price']); ?></td>
                                <td class="px-6 py-4 text-green-500">
                                    <?= htmlspecialchars($transaction['status']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500">Belum ada transaksi</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>