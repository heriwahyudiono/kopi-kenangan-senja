<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible=" IE="edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Keranjang Belanja</title>
</head>
<body>
    <?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="fixed z-50 top-24 left-1/2 transform -translate-x-1/2 p-4 w-64 rounded-lg shadow-lg text-center <?= $_SESSION['message']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?= $_SESSION['message']['text']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <script>
        setTimeout(() => {
            const message = document.getElementById('message');
            if (message) {
                message.remove();
            }
        }, 2000);
    </script>
</body>
</html>