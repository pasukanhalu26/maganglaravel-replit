<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Telepon Publik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-3xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600"><a href="<?php echo e(route('home')); ?>">GetNum</a></h1>
        </div>
    </header>

    <!-- [1] SLOT ADSENSE: Di Bawah Header (Leaderboard) -->
    <div class="max-w-3xl mx-auto w-full px-4 mt-6">
        <div class="w-full h-24 bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-500 text-sm">
            [ KODE ADSENSE HEADER ]
        </div>
    </div>

    <main class="flex-grow max-w-3xl mx-auto w-full px-4 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- [2] SLOT ADSENSE: Di Atas Footer -->
    <div class="max-w-3xl mx-auto w-full px-4 mb-6">
        <div class="w-full h-24 bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-500 text-sm">
            [ KODE ADSENSE FOOTER ]
        </div>
    </div>

    <footer class="bg-white border-t py-6 text-center text-gray-500 text-sm">
        &copy; <?php echo e(date('Y')); ?> Direktori Telepon. All rights reserved.
    </footer>
</body>
</html>
<?php /**PATH C:\laragon\www\maganglaravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>