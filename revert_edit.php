<?php
$files = [
    'resources/views/klaster/edit.blade.php' => 'klaster',
    'resources/views/program/edit.blade.php' => 'program',
    'resources/views/indikator/edit.blade.php' => 'indikator',
    'resources/views/desa/edit.blade.php' => 'desa',
    'resources/views/user/edit.blade.php' => 'user',
];

foreach ($files as $path => $var) {
    $fullPath = 'c:/laragon/www/maganglaravel/' . $path;
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        
        $newOptions = "<option value=\"1\" {{ $" . $var . "->status == 1 ? 'selected' : '' }}>Aktif</option>\n                            <option value=\"0\" {{ $" . $var . "->status == 0 ? 'selected' : '' }}>Non-Aktif</option>";
        
        // replace lines between <select name="status" ...> and </select> with newOptions
        $content = preg_replace('/(<select name="status"[^>]*>)(.*?)(<\/select>)/s', "$1\n                            $newOptions\n                        $3", $content);
        
        file_put_contents($fullPath, $content);
        echo "Reverted options in $fullPath\n";
    }
}
