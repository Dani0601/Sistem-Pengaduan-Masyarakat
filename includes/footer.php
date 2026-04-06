<footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-gray-300 mt-10">

    <div class="max-w-6xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-8">

        <!-- BRAND -->
        <div>
            <h2 class="text-lg font-bold text-white mb-2">📢 Pengaduan</h2>
            <p class="text-sm text-gray-400">
                Platform pengaduan masyarakat untuk menyampaikan keluhan secara cepat, mudah, dan transparan.
            </p>
        </div>

        <!-- MENU -->
        <div>
            <h3 class="text-white font-semibold mb-3">Menu</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="index.php?menu=home" class="hover:text-white transition">Home</a></li>
                <li><a href="index.php?menu=daftar" class="hover:text-white transition">Pengaduan</a></li>
                <li><a href="index.php?menu=form" class="hover:text-white transition">Buat Pengaduan</a></li>
                <li><a href="index.php?menu=tracking" class="hover:text-white transition">Tracking</a></li>
            </ul>
        </div>

        <!-- INFO -->
        <div>
            <h3 class="text-white font-semibold mb-3">Kontak</h3>
            <p class="text-sm text-gray-400">
                📧 support@pengaduan.com <br>
                📞 0812-3456-7890
            </p>
        </div>

    </div>

    <!-- BOTTOM -->
    <div class="border-t border-gray-700 text-center py-4 text-sm text-gray-400">
        © <?= date('Y'); ?> Sistem Pengaduan Masyarakat • Dibuat dengan ❤️
    </div>
<script>
document.addEventListener("DOMContentLoaded", function(){

    const html = document.documentElement;
    const icon = document.getElementById('icon');

    // load awal
    if(localStorage.getItem('theme') === 'dark'){
        html.classList.add('dark');
        if(icon) icon.innerHTML = '☀️';
    }

    // toggle
    window.toggleDarkMode = function(){
        if(html.classList.contains('dark')){
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            if(icon) icon.innerHTML = '🌙';
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            if(icon) icon.innerHTML = '☀️';
        }
    }

});
</script>
</footer>