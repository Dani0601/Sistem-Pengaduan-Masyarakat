<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="fixed top-0 left-0 w-64 h-screen bg-white dark:bg-[#0F172A] 
shadow-lg border-r border-gray-200 dark:border-[#1E293B] transition">

    <!-- LOGO -->
    <div class="p-5 text-xl font-bold text-gray-800 dark:text-white border-b dark:border-[#1E293B]">
        🛠 Admin Panel
    </div>

    <!-- MENU -->
    <ul class="p-4 space-y-2 text-sm">

        <!-- DASHBOARD -->
        <li>
            <a href="index.php?menu=dashboard"
               class="flex items-center gap-3 p-3 rounded-lg transition
               <?= $current == 'index.php' && (!isset($_GET['menu']) || $_GET['menu'] == 'dashboard') ? 
               'bg-blue-600 text-white shadow' : 
               'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1E293B]' ?>">
               
               📊 <span>Dashboard</span>
            </a>
        </li>

        <!-- PENGADUAN -->
        <li>
            <a href="index.php?menu=pengaduan"
               class="flex items-center gap-3 p-3 rounded-lg transition
               <?= $current == 'index.php' && isset($_GET['menu']) && $_GET['menu'] == 'pengaduan' ? 
               'bg-blue-600 text-white shadow' : 
               'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1E293B]' ?>">
               
               📋 <span>Kelola Pengaduan</span>
            </a>
        </li>

        <li>
            <a href="index.php?menu=verifikasi"
               class="flex items-center gap-3 p-3 rounded-lg transition
               <?= $current == 'index.php' && isset($_GET['menu']) && $_GET['menu'] == 'verifikasi' ? 
               'bg-blue-600 text-white shadow' : 
               'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1E293B]' ?>">
               
               ✅ <span>Verifikasi User</span>
            </a>
        </li>
        <!-- LOGOUT -->
        <li>
            <a href="../auth/logout.php"
               class="flex items-center gap-3 p-3 rounded-lg text-red-500 hover:bg-red-100 dark:hover:bg-red-900 transition">
               
               🚪 <span>Logout</span>
            </a>
        </li>

    </ul>
    <!-- DARK MODE TOGGLE -->
    <div class="absolute bottom-0 w-full p-4 border-t dark:border-[#1E293B]">

        <button onclick="toggleDarkMode()" 
            class="w-full flex items-center justify-center gap-2 bg-gray-200 dark:bg-[#1E293B] 
            text-gray-700 dark:text-gray-300 py-2 rounded-lg hover:shadow transition">

            <span id="icon">🌙</span>
            <span>Mode</span>
        </button>

    </div>


</div>

<!-- SCRIPT DARK MODE -->
<script>
function toggleDarkMode(){
    let html = document.documentElement;
    let icon = document.getElementById('icon');

    if(html.classList.contains('dark')){
        html.classList.remove('dark');
        localStorage.setItem('theme','light');
        icon.innerHTML = '🌙';
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme','dark');
        icon.innerHTML = '☀️';
    }
}

// SET ICON SAAT LOAD
if(localStorage.getItem('theme') === 'dark'){
    document.getElementById('icon').innerHTML = '☀️';
}
</script>