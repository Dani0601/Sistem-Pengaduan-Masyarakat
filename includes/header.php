<head>
<meta charset="UTF-8">
<title>Sistem Pengaduan Masyarakat</title>

<!-- 🔥 DARK MODE FIX (WAJIB PALING ATAS BANGET) -->
<script>
(function() {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();
</script>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Tailwind Config -->
<script>
tailwind.config = {
  darkMode: 'class'
}
</script>

<!-- Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/style.css">

<!-- 🔥 STYLE UTAMA -->
<style>

/* ANIMASI */
.fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s ease forwards;
}

.fade-in-delay {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1.2s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* 🔥 FIX DARK MODE (SATU KALI SAJA, HAPUS DUPLIKAT) */
.dark .bg-gray-300 {
    background-color: #334155 !important;
}

.dark .text-gray-300 {
    color: #475569 !important;
}

/* 🔥 STEPPER STYLE */
.step-line {
    height: 4px;
    background: linear-gradient(90deg, #22c55e, #3b82f6);
    background-size: 200% 100%;
    animation: moveLine 2s linear infinite;
}

@keyframes moveLine {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ACTIVE STEP */
.step-active {
    box-shadow: 0 0 10px rgba(59,130,246,0.7),
                0 0 20px rgba(59,130,246,0.5);
}

/* DONE STEP */
.step-done {
    box-shadow: 0 0 8px rgba(34,197,94,0.7);
}

/* SMOOTH TRANSITION */
.transition-step {
    transition: all 0.3s ease;
}

</style>

</head>
<body class="bg-white dark:bg-[#0F172A] transition-colors duration-300">