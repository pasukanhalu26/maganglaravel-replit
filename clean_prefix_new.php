<?php
$dir = 'c:/laragon/www/maganglaravel/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach($iterator as $file) {
    if($file->isFile() && $file->getExtension() == 'php') {
        $content = file_get_contents($file->getPathname());
        $orig = $content;
        
        // Match `#{{ str_pad(...) }} - {{` or `#{{ str_pad(...) }} – {{`
        // Also `&ndash;`
        $content = preg_replace('/#\{\{\s*str_pad\([^}]+\)\s*\}\}\s*(?:–|-|&ndash;)\s*\{\{/', '{{', $content);
        
        // JS replacements
        // `#${String(p.id_program).padStart(3,'0')} - ${p.nama_program}` -> `${p.nama_program}`
        $content = preg_replace('/#\$\{String\([^)]+\)\.padStart\([^)]+\)\}\s*-\s*\$\{([^}]+)\}/', '${$1}', $content);
        
        if($content !== $orig) {
            file_put_contents($file->getPathname(), $content);
            echo "Cleaned ID prefix in: " . $file->getPathname() . "\n";
        }
    }
}
