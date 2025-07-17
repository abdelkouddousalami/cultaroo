<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\VerificationRequest;

echo "=== Testing VerificationController data ===\n";

// Simulate what the controller would do
$requests = VerificationRequest::with('user')->get();

echo "Total verification requests: " . $requests->count() . "\n\n";

foreach ($requests as $request) {
    echo "Request Details:\n";
    echo "  ID: {$request->id}\n";
    echo "  User: {$request->user->name} ({$request->user->email})\n";
    echo "  Status: {$request->status}\n";
    echo "  Type: {$request->document_type}\n";
    echo "  Document Path: {$request->document_path}\n";
    echo "  Created: {$request->created_at}\n";
    echo "  Updated: {$request->updated_at}\n";
    echo "---\n";
}

echo "\n=== Status Counts ===\n";
echo "Pending: " . VerificationRequest::where('status', 'pending')->count() . "\n";
echo "Approved: " . VerificationRequest::where('status', 'approved')->count() . "\n";
echo "Rejected: " . VerificationRequest::where('status', 'rejected')->count() . "\n";

echo "\n=== Done ===\n";
