<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sistem Peminjaman Alat / Inventaris'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100:'#dbeafe', 500:'#3b82f6', 600:'#2563eb', 700:'#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>
    <style>body{font-family:'Poppins',sans-serif;}</style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
        <div class="hidden md:flex flex-col items-center justify-center bg-gradient-to-br from-blue-600 to-blue-800 text-white p-10 text-center">
            <div class="bg-white/10 rounded-2xl p-6 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0121 17.11 12.083 12.083 0 0112 21a12.083 12.083 0 01-9-3.89 12.083 12.083 0 013.16-9.532L12 14z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold leading-snug mb-2">SISTEM PEMINJAMAN<br>ALAT / INVENTARIS</h1>
            <p class="text-blue-100 text-sm">SMK Negeri 5 Surakarta</p>
        </div>
        <div class="p-8 sm:p-10 flex flex-col justify-center">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
<?php echo $__env->make('partials.toggle-password', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\resources\views/layouts/guest.blade.php ENDPATH**/ ?>