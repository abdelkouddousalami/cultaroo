<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\VerificationRequest;
use App\Models\User;

echo "=== Testing Admin View Data ===\n";

// Simulate what the adminIndex method would do
$requests = VerificationRequest::with(['user', 'reviewer'])
    ->orderBy('created_at', 'desc')
    ->paginate(20);

echo "Total requests: " . $requests->count() . "\n";
echo "Total items: " . $requests->total() . "\n\n";

foreach ($requests as $request) {
    echo "Request ID: {$request->id}\n";
    echo "User: {$request->user->email}\n";
    
    // Check if the User model has full_name accessor
    try {
        echo "Full Name: " . $request->user->full_name . "\n";
    } catch (Exception $e) {
        echo "Full Name Error: " . $e->getMessage() . "\n";
        echo "First Name: " . ($request->user->first_name ?? 'N/A') . "\n";
        echo "Last Name: " . ($request->user->last_name ?? 'N/A') . "\n";
    }
    
    // Check if the VerificationRequest model has document_type_display accessor
    try {
        echo "Document Type Display: " . $request->document_type_display . "\n";
    } catch (Exception $e) {
        echo "Document Type Display Error: " . $e->getMessage() . "\n";
        echo "Document Type: " . $request->document_type . "\n";
    }
    
    echo "Status: {$request->status}\n";
    echo "Created: {$request->created_at}\n";
    echo "---\n";
}

echo "\n=== Done ===\n";
