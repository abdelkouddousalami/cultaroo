<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Admin Password Reset ===\n";

$adminUser = User::where('email', 'tran2@gmail.com')->first();

if (!$adminUser) {
    echo "Admin user not found!\n";
    exit;
}

echo "Admin user found: {$adminUser->email}\n";
echo "Current role: {$adminUser->role}\n";

// Set a simple password for testing
$newPassword = 'admin123';
$adminUser->password = Hash::make($newPassword);
$adminUser->save();

echo "✅ Password updated!\n";
echo "Email: {$adminUser->email}\n";
echo "Password: {$newPassword}\n";
echo "\nYou can now log in with these credentials to access the admin panel.\n";
echo "Go to: /admin to see the verification requests\n";

echo "\n=== Done ===\n";
