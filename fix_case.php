<?php
$dir = 'c:/laragon/www/maganglaravel/app/Http/Controllers';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach($iterator as $file) {
    if($file->isFile() && $file->getExtension() == 'php') {
        $content = file_get_contents($file->getPathname());
        $orig = $content;
        
        $content = str_replace('$newstatus', '$newStatus', $content);
        
        if($content !== $orig) {
            file_put_contents($file->getPathname(), $content);
            echo "Fixed: " . $file->getPathname() . "\n";
        }
    }
}
