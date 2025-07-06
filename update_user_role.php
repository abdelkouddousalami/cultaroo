<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "Updating user role to host...\n";

$user = User::where('email', 'aymane655@gmail.com')->first();

if (!$user) {
    echo "User not found!\n";
    exit;
}

echo "User found: " . $user->email . "\n";
echo "Current role: " . $user->role . "\n";

$user->role = 'host';
$user->save();

echo "✅ User role updated to: " . $user->role . "\n";
