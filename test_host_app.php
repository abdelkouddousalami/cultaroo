<?php

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\HostApplication;

echo "Testing host application creation...\n";

$user = User::where('email', 'aymane655@gmail.com')->first();

if (!$user) {
    echo "User not found!\n";
    exit;
}

echo "User found: " . $user->email . "\n";

// Check if user already has an application
$existingApp = $user->hostApplication;
if ($existingApp) {
    echo "User already has an application with ID: " . $existingApp->id . "\n";
    exit;
}

// Create test application
try {
    $app = HostApplication::create([
        'user_id' => $user->id,
        'national_id_document' => 'test/national-id.jpg',
        'city' => 'Marrakech',
        'languages' => ['Arabic', 'French'],
        'family_members_count' => 4,
        'house_ownership_document' => 'test/ownership.pdf',
        'motivation' => 'I want to share authentic Moroccan culture with travelers from around the world. My family has been hosting guests for generations and we take pride in providing warm hospitality and genuine cultural experiences.',
        'amenities' => ['WiFi', 'Traditional Decor', 'Kitchen Access'],
        'status' => 'pending'
    ]);
    
    echo "✅ Test application created successfully with ID: " . $app->id . "\n";
    echo "Application details:\n";
    echo "- City: " . $app->city . "\n";
    echo "- Languages: " . implode(', ', $app->languages) . "\n";
    echo "- Family size: " . $app->family_members_count . "\n";
    echo "- Status: " . $app->status . "\n";
} catch (Exception $e) {
    echo "❌ Error creating application: " . $e->getMessage() . "\n";
}

echo "\nTotal applications in database: " . HostApplication::count() . "\n";
