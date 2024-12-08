<?php
require_once '../models/UserModel.php';

session_start();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $name = $user['name'];
    $email = $user['email'];
    $profilePicture = 'https://via.placeholder.com/150';
} else {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-900 font-sans leading-normal tracking-normal text-gray-200">
    <div class="max-w-md mx-auto mt-16 p-8 bg-gray-800 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-white mb-8">Profile</h1>

        <div class="flex items-center justify-center mb-8">
            <img src="<?= $profilePicture; ?>" alt="<?= $profilePicture; ?>" class="w-32 h-32 rounded-full border-4 border-gray-600">
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div id="message" class="mb-4 text-center <?= $_SESSION['message']['type'] === 'success' ? 'text-green-500' : 'text-red-500'; ?>">
                <?= htmlspecialchars($_SESSION['message']['text']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form action="../controllers/UpdateUserController.php" method="POST">
            <input type="hidden" value="<?= $user['id'] ?>" name="id">

            <div class="mb-6">
                <label for="name" class="block text-gray-300 font-semibold">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($name); ?>" class="w-full mt-2 p-3 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>

            <div class="mb-6">
                <label for="email" class="block text-gray-300 font-semibold">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email); ?>" class="w-full mt-2 p-3 bg-gray-700 text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>

            <div class="mt-8 text-center">
                <button type="submit" class="w-full bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-yellow-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">Update Profile</button>
            </div>
        </form>
    </div>

    <script>
    setTimeout(() => {
      const message = document.getElementById('message');
      if(message) {
        message.remove();
      }
    }, 2000);
    </script>
</body>
</html>
