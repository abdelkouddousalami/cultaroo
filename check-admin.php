<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Admin User Check ===\n";

$user = \App\Models\User::where('email', 'tran2@gmail.com')->first();
if ($user) {
    echo "Email: " . $user->email . "\n";
    echo "Role: " . ($user->role ?? 'none') . "\n";
    echo "Is Admin: " . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
} else {
    echo "Admin user not found!\n";
}

echo "\n=== Verification Requests Check ===\n";
$requests = \App\Models\VerificationRequest::count();
echo "Total verification requests: $requests\n";

$pending = \App\Models\VerificationRequest::where('status', 'pending')->count();
echo "Pending requests: $pending\n";

if ($pending > 0) {
    $sample = \App\Models\VerificationRequest::where('status', 'pending')->with('user')->first();
    echo "Sample request ID: " . $sample->id . "\n";
    echo "User: " . $sample->user->full_name . "\n";
    echo "Document: " . $sample->document_path . "\n";
}
?>
