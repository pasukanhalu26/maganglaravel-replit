<?php
require 'c:/laragon/www/maganglaravel/vendor/autoload.php';
$app = require_once 'c:/laragon/www/maganglaravel/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\User;
$users = User::all();
foreach ($users as $user) {
    $user->status = 1; // active
    // reset password to known value for testing
    $user->password = Hash::make('admin123');
    $user->save();
    echo "Updated user {$user->email} (username: {$user->username})\n";
}
?>
