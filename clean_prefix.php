<?php
$dir = 'c:/laragon/www/maganglaravel/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach($iterator as $file) {
    if($file->isFile() && $file->getExtension() == 'php') {
        $content = file_get_contents($file->getPathname());
        $orig = $content;
        
        // Match `#{{ str_pad(...) }} - {{` or `#{{ str_pad(...) }} – {{`
        // Replace with just `{{`
        $content = preg_replace('/#\{\{\s*str_pad[^\}]+\}\}\s*.\s*\{\{/', '{{', $content);
        
        // Also maybe there are some with #{{ $variable->id }} - {{ $variable->name }}
        // we can remove all `#{{.*?}}.\{\{` ? No that's too broad.
        
        if($content !== $orig) {
            file_put_contents($file->getPathname(), $content);
            echo "Cleaned ID prefix in: " . $file->getPathname() . "\n";
        }
    }
}
