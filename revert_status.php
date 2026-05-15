<?php

$dirs = ['app/Http/Controllers', 'resources/views', 'routes'];
foreach($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('c:/laragon/www/maganglaravel/' . $dir));
    foreach($iterator as $file) {
        if($file->isFile() && $file->getExtension() == 'php') {
            $content = file_get_contents($file->getPathname());
            $origContent = $content;
            
            // Revert where('status', 0) to where('status', 1)
            $content = str_replace("where('status', 0)", "where('status', 1)", $content);
            $content = str_replace('where("status", 0)', 'where("status", 1)', $content);
            
            // Revert toggling
            // status == 0 ? 1 : 0 to status == 1 ? 0 : 1
            $content = preg_replace('/status == 0 \? 1 : 0/', 'status == 1 ? 0 : 1', $content);
            $content = preg_replace('/status == 0 \? \'([^\']+aktifkan[^\']*)\' : \'([^\']+nonaktifkan[^\']*)\'/i', 'status == 1 ? \'$1\' : \'$2\'', $content);

            // Revert in views: status == 0 to status == 1
            $content = preg_replace('/status == 0 \? \'Aktif\' : \'Non-Aktif\'/', 'status == 1 ? \'Aktif\' : \'Non-Aktif\'', $content);
            $content = preg_replace('/status == 0 \? \'bg-success\' : \'bg-danger\'/', 'status == 1 ? \'bg-success\' : \'bg-danger\'', $content);
            
            // Revert Delete confirmation titles
            $content = preg_replace('/status == 0 \? \'Nonaktifkan (.*?)\?\' : \'Aktifkan (.*?)\?\'/', 'status == 1 ? \'Nonaktifkan $1?\' : \'Aktifkan $2?\'', $content);
            $content = preg_replace('/status == 0 \? \'([^\']+tidak akan[^\']*)\' : \'([^\']+aktif kembali[^\']*)\'/i', 'status == 1 ? \'$1\' : \'$2\'', $content);
            $content = preg_replace('/status == 0 \? \'#dc3545\' : \'#28A745\'/', 'status == 1 ? \'#dc3545\' : \'#28A745\'', $content);
            $content = preg_replace('/status == 0 \? \'Ya, nonaktifkan\' : \'Ya, aktifkan\'/', 'status == 1 ? \'Ya, nonaktifkan\' : \'Ya, aktifkan\'', $content);
            $content = preg_replace('/status == 0 \? \'btn-action-delete\' : \'btn-action-restore\'/', 'status == 1 ? \'btn-action-delete\' : \'btn-action-restore\'', $content);
            $content = preg_replace('/status == 0 \? \'Nonaktifkan\' : \'Aktifkan\'/', 'status == 1 ? \'Nonaktifkan\' : \'Aktifkan\'', $content);
            $content = preg_replace('/status == 0 \? \'fa-ban\' : \'fa-check\'/', 'status == 1 ? \'fa-ban\' : \'fa-check\'', $content);

            // Revert Default values
            $content = str_replace('status ?? 0', 'status ?? 1', $content);
            $content = str_replace("'status'    => 0", "'status'    => 1", $content);
            $content = str_replace("'status' => 0", "'status' => 1", $content);
            
            // Revert Create/Edit form selects
            $content = str_replace('<option value="0">Aktif (0)</option>', '<option value="1">Aktif (1)</option>', $content);
            $content = str_replace('<option value="1">Tidak Aktif (1)</option>', '<option value="0">Tidak Aktif (0)</option>', $content);
            
            if($content !== $origContent) {
                file_put_contents($file->getPathname(), $content);
                echo "Reverted: " . $file->getPathname() . "\n";
            }
        }
    }
}
