<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 to-white h-screen flex items-center justify-center">

<div class="bg-white/70 backdrop-blur-lg p-8 rounded-2xl shadow-xl w-96">

    <h2 class="text-xl font-bold mb-4 text-center">📝 Register (NIK)</h2>

    <form action="proses_register.php" method="POST" class="space-y-3">

        <input type="text" name="nik" placeholder="NIK"
            class="w-full border p-2 rounded-lg" required>

        <input type="text" name="nama" placeholder="Nama"
            class="w-full border p-2 rounded-lg" required>

        <input type="email" name="email" placeholder="Email (untuk login)"
            class="w-full border p-2 rounded-lg" required>

        <input type="password" name="password" placeholder="Password"
            class="w-full border p-2 rounded-lg" required>

        <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
            Register
        </button>
        <p class="text-sm text-center">
            Sudah punya akun?
            <a href="login.php" class="text-blue-600">Login</a>
        </p>
    </form>

</div>

</body>
</html>