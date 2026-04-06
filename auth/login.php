<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 to-white h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-xl shadow-lg w-80">

    <h2 class="text-xl font-bold mb-4 text-center">🔐 Login</h2>

    <form action="proses_login.php" method="POST" class="space-y-3">

        <input type="email" name="email" placeholder="Email"
            class="w-full border p-2 rounded-lg">

        <input type="password" name="password" placeholder="Password"
            class="w-full border p-2 rounded-lg">

        <img src="captcha.php" class="mx-auto">

        <input type="text" name="captcha" placeholder="Masukkan captcha"
            class="w-full border p-2 rounded-lg">

        <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            Login
        </button>

        <p class="text-sm text-center">
            Belum punya akun?
            <a href="register.php" class="text-blue-600">Register</a>
        </p>

    </form>

</div>

</body>
</html>