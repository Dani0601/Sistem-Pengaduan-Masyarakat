<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}



include 'config/koneksi.php';
?>

<div class="min-h-screen 
    bg-gradient-to-br from-blue-50 via-white to-blue-100 
    dark:from-[#0F172A] dark:via-[#1E293B] dark:to-[#0F172A] 
    flex items-center justify-center px-4 
    text-gray-800 dark:text-[#E2E8F0]">

    <div class="w-full max-w-2xl">

        <!-- CARD -->
        <div class="bg-white/80 dark:bg-[#1E293B]/80 backdrop-blur-md 
            border border-gray-200 dark:border-[#334155] 
            p-6 rounded-2xl shadow-xl">

            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
                📝 Buat Pengaduan
            </h2>

            <form action="proses/kirim_pengaduan.php" method="POST" enctype="multipart/form-data" class="space-y-5">

                <!-- JUDUL -->
                <div>
                    <label class="text-sm text-gray-600 dark:text-[#CBD5E1]">
                        Judul Pengaduan
                    </label>

                    <input type="text" name="judul"
                        class="w-full mt-1 border border-gray-300 dark:border-[#334155] 
                        bg-white dark:bg-[#0F172A] 
                        text-gray-800 dark:text-white
                        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Contoh: Jalan rusak di desa..." required>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="text-sm text-gray-600 dark:text-[#CBD5E1]">
                        Kategori
                    </label>

                    <select name="kategori"
                        class="w-full mt-1 border border-gray-300 dark:border-[#334155] 
                        bg-white dark:bg-[#0F172A] 
                        text-gray-800 dark:text-white
                        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>

                        <option value="">-- Pilih Kategori --</option>
                        <option value="Infrastruktur">Infrastruktur</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Keamanan">Keamanan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- KECAMATAN -->
                <div>
                    <label class="text-sm text-gray-600 dark:text-[#CBD5E1]">
                        Kecamatan
                    </label>

                    <select name="kecamatan" id="kecamatan"
                        class="w-full mt-1 border border-gray-300 dark:border-[#334155] 
                        bg-white dark:bg-[#0F172A] 
                        text-gray-800 dark:text-white
                        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>

                        <option value="">-- Pilih Kecamatan --</option>

                        <?php
                        $kec = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY nama ASC");
                        while($k = mysqli_fetch_assoc($kec)){
                            echo "<option value='{$k['id']}'>{$k['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- DESA -->
                <div>
                    <label class="text-sm text-gray-600 dark:text-[#CBD5E1]">
                        Desa
                    </label>

                    <select name="desa" id="desa"
                        class="w-full mt-1 border border-gray-300 dark:border-[#334155] 
                        bg-white dark:bg-[#0F172A] 
                        text-gray-800 dark:text-white
                        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>

                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>

                <!-- ISI -->
                <div>
                    <label class="text-sm text-gray-600 dark:text-[#CBD5E1]">
                        Isi Pengaduan
                    </label>

                    <textarea name="isi" rows="4"
                        class="w-full mt-1 border border-gray-300 dark:border-[#334155] 
                        bg-white dark:bg-[#0F172A] 
                        text-gray-800 dark:text-white
                        p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Tuliskan detail pengaduan anda..." required></textarea>
                </div>

                <!-- FILE + PREVIEW -->
                <div>
                    <label class="text-sm text-gray-600 dark:text-[#CBD5E1]">
                        Upload Bukti (Opsional)
                    </label>

                    <input type="file" name="bukti" id="bukti"
                        accept="image/*"
                        class="w-full mt-1 border border-gray-300 dark:border-[#334155] 
                        bg-white dark:bg-[#0F172A] 
                        text-gray-800 dark:text-white
                        p-2 rounded-lg">

                    <!-- PREVIEW -->
                    <div class="mt-3 hidden" id="previewContainer">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            Preview Gambar:
                        </p>

                        <img id="previewImage"
                            class="w-full max-h-64 object-contain rounded-lg border 
                            border-gray-300 dark:border-[#334155] shadow">
                    </div>
                </div>

                <!-- BUTTON -->
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg 
                    hover:bg-blue-700 hover:shadow-lg transition duration-300">
                    🚀 Kirim Pengaduan
                </button>

            </form>

        </div>

    </div>

</div>

<!-- SCRIPT DESA DINAMIS -->
<script>
document.getElementById('kecamatan').addEventListener('change', function(){
    let kecamatan_id = this.value;

    fetch('pages/get_desa.php?kecamatan_id=' + kecamatan_id)
    .then(response => response.text())
    .then(data => {
        document.getElementById('desa').innerHTML = data;
    });
});
</script>

<!-- SCRIPT PREVIEW GAMBAR -->
<script>
document.getElementById('bukti').addEventListener('change', function(event){
    const file = event.target.files[0];

    if(file){
        const reader = new FileReader();

        reader.onload = function(e){
            const preview = document.getElementById('previewImage');
            preview.src = e.target.result;

            document.getElementById('previewContainer').classList.remove('hidden');
        }

        reader.readAsDataURL(file);
    }
});
</script>