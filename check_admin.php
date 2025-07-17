<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\VerificationRequest;

echo "=== User Role Check ===\n";

$user = User::where('email', 'aymane655@gmail.com')->first();

if (!$user) {
    echo "User not found!\n";
    exit;
}

echo "User found: " . $user->email . "\n";
echo "Current role: " . $user->role . "\n";
echo "Is Admin: " . ($user->isAdmin() ? 'YES' : 'NO') . "\n";

// Update to admin if not already
if (!$user->isAdmin()) {
    echo "Updating role to admin...\n";
    $user->role = 'admin';
    $user->save();
    echo "✅ User role updated to: " . $user->role . "\n";
} else {
    echo "✅ User is already an admin\n";
}

echo "\n=== Verification Requests ===\n";
$requests = VerificationRequest::with('user')->get();
echo "Total verification requests: " . $requests->count() . "\n";

foreach ($requests as $request) {
    echo "ID: {$request->id}, User: {$request->user->email}, Status: {$request->status}, Type: {$request->document_type}\n";
}

echo "\n=== Done ===\n";
