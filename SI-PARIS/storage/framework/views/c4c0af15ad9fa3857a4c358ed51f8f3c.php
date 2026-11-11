<?php
    $isPetugas = auth()->user()->role === 'petugas';

    $warnaSidebar = $isPetugas
        ? 'bg-blue-50 border-blue-200'
        : 'bg-white border-gray-100';

    $warnaHeader = $isPetugas
        ? 'bg-blue-100 border-blue-200'
        : 'bg-white border-gray-100';

    $warnaUtama = 'text-blue-600';

    $warnaLogo = 'bg-blue-600';

    $warnaAvatar = $isPetugas
        ? 'bg-blue-200 text-blue-700'
        : 'bg-blue-100 text-blue-600';

    $warnaLogout = $isPetugas
        ? 'text-blue-600 hover:text-blue-800 hover:bg-blue-100'
        : 'text-gray-500 hover:text-red-600 hover:bg-red-50';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - Peminjaman Alat</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body
    class="<?php echo e($isPetugas ? 'bg-blue-50' : 'bg-blue-100'); ?> text-gray-800"
    x-data="{ sidebarOpen: false, confirmLogout: false, foto: null }"
>

<div class="flex min-h-screen">

    
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed z-30 inset-y-0 left-0 w-72 <?php echo e($warnaSidebar); ?> border-r transform transition-transform duration-200 md:translate-x-0 md:static flex flex-col"
    >

        
        <div class="flex items-center gap-2 px-6 py-5 border-b <?php echo e($isPetugas ? 'border-blue-200' : 'border-gray-100'); ?>">

            <div class="<?php echo e($warnaLogo); ?> text-white rounded-lg w-9 h-9 flex items-center justify-center font-bold">
                P
            </div>

            <div>
                <p class="text-sm font-bold text-gray-800 leading-tight">
                    Peminjaman Alat
                </p>

                <p class="text-[11px] text-gray-400">
                    SMK Negeri 5 Surakarta
                </p>
            </div>

        </div>

        
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-3">
            <?php echo $__env->make('partials.sidebar-'.(auth()->user()->role === 'petugas' ? 'petugas' : 'peminjam'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </nav>

        
        <div class="mt-auto p-4 border-t <?php echo e($isPetugas ? 'border-blue-200' : 'border-gray-100'); ?>">

            <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>

                <button
                    type="button"
                    @click="confirmLogout = true"
                    class="flex items-center gap-3 px-4 py-3.5 text-sm <?php echo e($warnaLogout); ?> rounded-lg w-full transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>

                    </svg>

                    Logout
                </button>
            </form>

        </div>

    </aside>


    
    <div class="flex-1 flex flex-col min-w-0">

        
        <header class="<?php echo e($warnaHeader); ?> border-b px-4 md:px-8 py-4 flex items-center justify-between sticky top-0 z-20">

            <div class="flex items-center gap-3">

                <button
                    class="md:hidden <?php echo e($warnaUtama); ?>"
                    @click="sidebarOpen = !sidebarOpen"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>

                    </svg>
                </button>

                <h1 class="text-lg font-semibold <?php echo e($isPetugas ? 'text-blue-900' : 'text-gray-800'); ?>">
                    <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                </h1>

            </div>


            
            <div class="flex items-center gap-3">

                <div class="text-right hidden sm:block">

                    <p class="text-sm font-semibold text-gray-800">
                        <?php echo e(auth()->user()->nama_lengkap); ?>

                    </p>

                    <p class="text-xs text-gray-400">
                        <?php echo e(auth()->user()->jenis_label); ?>

                    </p>

                </div>

                <div class="w-10 h-10 rounded-full <?php echo e($warnaAvatar); ?> flex items-center justify-center font-semibold">
                    <?php echo e(strtoupper(substr(auth()->user()->nama_lengkap, 0, 1))); ?>

                </div>

            </div>

        </header>


        
        <main class="p-4 md:p-8 flex-1">

            <?php if(session('success')): ?>
                <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-100">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>

        </main>

    </div>

</div>



<div
    x-show="foto"
    style="display:none"
    @keydown.escape.window="foto = null"
    @click="foto = null"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4 cursor-zoom-out"
    role="dialog"
    aria-modal="true"
>
    <img
        :src="foto"
        alt="Foto"
        class="max-h-[85vh] max-w-full rounded-lg shadow-2xl bg-white"
    >
</div>



<div
    x-show="confirmLogout"
    style="display:none"
    @keydown.escape.window="confirmLogout = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="judul-logout"
>

    <div
        @click.outside="confirmLogout = false"
        class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6"
    >

        <div class="w-11 h-11 rounded-full <?php echo e($isPetugas ? 'bg-blue-100 text-blue-600' : 'bg-red-100 text-red-600'); ?> flex items-center justify-center mb-4">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>

            </svg>

        </div>

        <h3 id="judul-logout" class="text-lg font-semibold text-gray-800">
            Apakah Anda yakin ingin logout?
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Anda perlu login lagi untuk memakai sistem.
        </p>

        <div class="flex gap-3 mt-6">

            <button
                type="button"
                @click="confirmLogout = false"
                class="flex-1 border border-gray-200 text-gray-600 font-semibold py-2.5 rounded-lg hover:bg-gray-50"
            >
                Batal
            </button>

            <button
                type="button"
                onclick="document.getElementById('logout-form').submit()"
                class="flex-1 <?php echo e($isPetugas ? 'bg-blue-600 hover:bg-blue-700' : 'bg-red-600 hover:bg-red-700'); ?> text-white font-semibold py-2.5 rounded-lg"
            >
                Ya, logout
            </button>

        </div>

    </div>

</div>

<?php echo $__env->make('partials.toggle-password', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>