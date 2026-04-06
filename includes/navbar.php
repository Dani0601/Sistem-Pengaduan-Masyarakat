<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$menu = $_GET['menu'] ?? 'home'; 
?>

<nav class="fixed top-0 w-full z-50 
bg-white/70 dark:bg-[#0F172A]/80 
backdrop-blur-md 
border-b border-gray-200 dark:border-[#334155]">

    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- LOGO -->
        <a href="index.php" class="font-bold text-lg text-gray-800 dark:text-white">
            📢 Pengaduan
        </a>

        <!-- HAMBURGER -->
        <button onclick="toggleMenu()" 
            class="md:hidden text-2xl text-gray-800 dark:text-white">
            ☰
        </button>

        <!-- MENU DESKTOP -->
        <div class="space-x-6 hidden md:flex items-center">

            <!-- HOME -->
            <a href="index.php?menu=home" 
            class="<?= $menu=='home'
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300' ?> 
            hover:text-blue-500 dark:hover:text-blue-400 transition">
                Home
            </a>

            <!-- PENGADUAN -->
            <a href="index.php?menu=daftar" 
            class="<?= $menu=='daftar'
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300' ?> 
            hover:text-blue-500 dark:hover:text-blue-400 transition">
                Pengaduan
            </a>

            <!-- BUAT -->
            <a href="index.php?menu=form" 
            class="<?= $menu=='form'
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300' ?> 
            hover:text-blue-500 dark:hover:text-blue-400 transition">
                Buat
            </a>

            <!-- TRACKING -->
            <a href="index.php?menu=tracking" 
            class="<?= $menu=='tracking'
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300' ?> 
            hover:text-blue-500 dark:hover:text-blue-400 transition">
                Tracking
            </a>

            <!-- TENTANG -->
            <a href="index.php?menu=tentang" 
            class="<?= $menu=='tentang'
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300' ?> 
            hover:text-blue-500 dark:hover:text-blue-400 transition">
                Tentang
            </a>

            <!-- DARK MODE BUTTON -->
            <button onclick="toggleDarkMode()" 
            class="bg-gray-200 dark:bg-gray-700 
            text-gray-800 dark:text-white 
            px-3 py-1 rounded-lg 
            hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                <span id="icon">🌙</span>
            </button>

            <!-- LOGIN -->
            <?php if(isset($_SESSION['login'])): ?>
                <span class="text-gray-700 dark:text-gray-200">
                    👤 <?= $_SESSION['nama']; ?>
                </span>
                <a href="auth/logout.php" 
                   class="text-red-500 hover:text-red-600 transition">
                    Logout
                </a>
            <?php else: ?>
                <a href="auth/login.php" 
                   class="bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700 transition">
                    Login
                </a>
            <?php endif; ?>

        </div>
    </div>

    <!-- 🔥 MOBILE MENU -->
    <div id="mobileMenu" 
    class="hidden md:hidden px-4 pb-4 space-y-2 
    bg-white/90 dark:bg-[#1E293B]/90 backdrop-blur-md">

        <!-- HOME -->
        <a href="index.php?menu=home" 
        class="block px-3 py-2 rounded
        <?= $menu=='home'
            ? 'text-blue-600 dark:text-blue-400 font-semibold'
            : 'text-gray-700 dark:text-gray-300' ?>
        hover:bg-gray-100 dark:hover:bg-[#334155] transition">
            Home
        </a>

        <!-- PENGADUAN -->
        <a href="index.php?menu=daftar" 
        class="block px-3 py-2 rounded
        <?= $menu=='daftar'
            ? 'text-blue-600 dark:text-blue-400 font-semibold'
            : 'text-gray-700 dark:text-gray-300' ?>
        hover:bg-gray-100 dark:hover:bg-[#334155] transition">
            Pengaduan
        </a>

        <!-- BUAT -->
        <a href="index.php?menu=form" 
        class="block px-3 py-2 rounded
        <?= $menu=='form'
            ? 'text-blue-600 dark:text-blue-400 font-semibold'
            : 'text-gray-700 dark:text-gray-300' ?>
        hover:bg-gray-100 dark:hover:bg-[#334155] transition">
            Buat
        </a>

        <!-- TRACKING -->
        <a href="index.php?menu=tracking" 
        class="block px-3 py-2 rounded
        <?= $menu=='tracking'
            ? 'text-blue-600 dark:text-blue-400 font-semibold'
            : 'text-gray-700 dark:text-gray-300' ?>
        hover:bg-gray-100 dark:hover:bg-[#334155] transition">
            Tracking
        </a>

        <!-- TENTANG -->
        <a href="index.php?menu=tentang" 
        class="block px-3 py-2 rounded
        <?= $menu=='tentang'
            ? 'text-blue-600 dark:text-blue-400 font-semibold'
            : 'text-gray-700 dark:text-gray-300' ?>
        hover:bg-gray-100 dark:hover:bg-[#334155] transition">
            Tentang
        </a>

        <!-- DARK MODE -->
        <button onclick="toggleDarkMode()" 
        class="w-full bg-gray-200 dark:bg-gray-700 
        text-gray-800 dark:text-white 
        p-2 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            🌙 Dark Mode
        </button>

        <!-- LOGIN -->
        <?php if(isset($_SESSION['login'])): ?>
            <div class="text-sm text-gray-700 dark:text-gray-300">
                👤 <?= $_SESSION['nama']; ?>
            </div>
            <a href="auth/logout.php" 
               class="block text-red-500 hover:text-red-600">
                Logout
            </a>
        <?php else: ?>
            <a href="auth/login.php" 
               class="block bg-blue-600 text-white text-center p-2 rounded hover:bg-blue-700">
                Login
            </a>
        <?php endif; ?>

    </div>
</nav>

<!-- SCRIPT -->
<script>
function toggleMenu(){
    document.getElementById('mobileMenu').classList.toggle('hidden');
}

// DARK MODE TOGGLE
function toggleDarkMode(){
    const html = document.documentElement;
    const icon = document.getElementById('icon');

    html.classList.toggle('dark');

    if(html.classList.contains('dark')){
        localStorage.setItem('theme','dark');
        icon.innerText = '☀️';
    } else {
        localStorage.setItem('theme','light');
        icon.innerText = '🌙';
    }
}

// SET ICON SAAT LOAD
window.onload = function(){
    const icon = document.getElementById('icon');
    if(document.documentElement.classList.contains('dark')){
        icon.innerText = '☀️';
    } else {
        icon.innerText = '🌙';
    }
}
</script>