<?php

use App\Models\Indikator;
use App\Models\Program;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Starting synchronization...\n";

$count = 0;
foreach (Indikator::all() as $i) {
    $p = Program::find($i->id_program);
    if ($p) {
        $i->id_klaster = $p->id_klaster;
        $i->save();
        $count++;
    }
}

echo "Done! Synchronized $count indicators.\n";
