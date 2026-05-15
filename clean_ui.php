<?php
$dir = 'c:/laragon/www/maganglaravel/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach($iterator as $file) {
    if($file->isFile() && $file->getExtension() == 'php') {
        $content = file_get_contents($file->getPathname());
        $orig = $content;
        
        // 1. Clean up options like <option value="">-- Pilih Desa --</option>
        $content = preg_replace('/>--\s*(?:Pilih\s*)?(.*?)\s*--</i', '>Pilih $1<', $content);
        
        // 2. Clean up month format
        $content = str_replace('{{ $num }} - {{ $name }}', '{{ $name }}', $content);
        
        if($content !== $orig) {
            file_put_contents($file->getPathname(), $content);
            echo "Cleaned UI in: " . $file->getPathname() . "\n";
        }
    }
}
