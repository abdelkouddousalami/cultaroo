<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\VerificationRequest;

echo "=== All Users ===\n";

$users = User::all();
echo "Total users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\n=== Verification Requests ===\n";
$requests = VerificationRequest::with('user')->get();
echo "Total verification requests: " . $requests->count() . "\n";

foreach ($requests as $request) {
    echo "ID: {$request->id}, User: {$request->user->email}, Status: {$request->status}, Type: {$request->document_type}\n";
}

echo "\n=== Done ===\n";
