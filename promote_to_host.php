<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\User;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get user email from command line argument
if ($argc < 2) {
    echo "Usage: php promote_to_host.php <email>\n";
    echo "Example: php promote_to_host.php user@example.com\n";
    exit(1);
}

$email = $argv[1];

// Find user by email
$user = User::where('email', $email)->first();

if (!$user) {
    echo "User with email '{$email}' not found.\n";
    exit(1);
}

// Promote to host
$user->update(['role' => 'host']);

echo "Successfully promoted {$user->first_name} {$user->last_name} ({$email}) to host role!\n";
echo "They can now create hosting announcements.\n";
