<?php $__env->startSection('content'); ?>
<div class="text-center mt-12 mb-20">
    <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Cek Siapa yang Menelponmu</h2>
    <p class="text-gray-600 mb-10 text-lg">Lindungi diri Anda dari penipuan dengan database publik kami.</p>
    
    <form action="<?php echo e(route('search')); ?>" method="GET" class="flex items-center w-full max-w-lg mx-auto bg-white rounded-full shadow-lg border border-gray-200 overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition-all">
        <input type="text" name="phone" placeholder="Contoh: 081234567890" required class="flex-grow px-6 py-4 outline-none text-gray-800 placeholder-gray-400 font-medium text-lg" />
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 transition-colors">
            Cari Nomor
        </button>
    </form>
    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-red-500 text-sm mt-3"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/directory/index.blade.php ENDPATH**/ ?>