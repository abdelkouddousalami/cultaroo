<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get all users and their roles
echo "=== USER STATUS DEBUG ===\n\n";

$users = User::all();
foreach ($users as $user) {
    echo "User ID: {$user->id}\n";
    echo "Name: {$user->first_name} {$user->last_name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "User Type: {$user->user_type}\n";
    echo "Is Host: " . ($user->isHost() ? 'YES' : 'NO') . "\n";
    echo "Has Host Application: " . ($user->hasHostApplication() ? 'YES' : 'NO') . "\n";
    
    if ($user->hasHostApplication()) {
        $app = $user->hostApplication;
        echo "Host Application Status: {$app->status}\n";
    }
    
    echo "---\n";
}

// Check for any recent host application submissions
echo "\n=== HOST APPLICATIONS ===\n";
$applications = DB::table('host_applications')->get();
foreach ($applications as $app) {
    echo "Application ID: {$app->id}\n";
    echo "User ID: {$app->user_id}\n";
    echo "Status: {$app->status}\n";
    echo "City: {$app->city}\n";
    echo "Created: {$app->created_at}\n";
    echo "---\n";
}

echo "\nDone!\n";
