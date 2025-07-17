<?php
// Test admin verification access
require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Start session and authentication
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<h2>Admin Verification Test</h2>";

// Check if admin user exists
try {
    $adminUser = \App\Models\User::where('email', 'tran2@gmail.com')->first();
    if ($adminUser) {
        echo "<p style='color: green;'>✅ Admin user found: {$adminUser->email}</p>";
        echo "<p>Role: {$adminUser->role}</p>";
        echo "<p>Is Admin: " . ($adminUser->isAdmin() ? 'Yes' : 'No') . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Admin user not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error checking admin user: " . $e->getMessage() . "</p>";
}

// Check verification requests
echo "<h3>Verification Requests</h3>";
try {
    $requests = \App\Models\VerificationRequest::with(['user', 'reviewer'])->get();
    echo "<p>Total requests: " . $requests->count() . "</p>";
    
    foreach ($requests as $request) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
        echo "<p><strong>ID:</strong> {$request->id}</p>";
        echo "<p><strong>User:</strong> {$request->user->full_name} ({$request->user->email})</p>";
        echo "<p><strong>Status:</strong> {$request->status}</p>";
        echo "<p><strong>Document:</strong> {$request->document_path}</p>";
        
        $fullPath = '../storage/app/public/' . $request->document_path;
        $publicUrl = '/storage/' . $request->document_path;
        echo "<p><strong>File exists:</strong> " . (file_exists($fullPath) ? '✅ Yes' : '❌ No') . "</p>";
        echo "<p><strong>Public URL:</strong> <a href='{$publicUrl}' target='_blank'>{$publicUrl}</a></p>";
        
        // Test buttons
        echo "<button onclick=\"testViewDocument('{$publicUrl}')\">Test View Document</button> ";
        echo "<button onclick=\"testReview({$request->id}, '{$request->user->full_name}')\">Test Review</button>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error fetching verification requests: " . $e->getMessage() . "</p>";
}

// Test route access
echo "<h3>Route Testing</h3>";
try {
    $verificationRoute = '/admin/verification-requests';
    echo "<p>Verification route: <a href='{$verificationRoute}' target='_blank'>{$verificationRoute}</a></p>";
    
    // Create a mock request to test the route
    $request = Illuminate\Http\Request::create($verificationRoute, 'GET');
    
    // Set up authentication for the mock request
    if ($adminUser) {
        \Illuminate\Support\Facades\Auth::login($adminUser);
        echo "<p style='color: green;'>✅ Logged in as admin for testing</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error testing route: " . $e->getMessage() . "</p>";
}

// Test document access
echo "<h3>Document Access Test</h3>";
$documentsPath = '../storage/app/public/verification_documents';
if (is_dir($documentsPath)) {
    $files = scandir($documentsPath);
    $documentFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..']);
    });
    
    echo "<p>Documents directory exists with " . count($documentFiles) . " files:</p>";
    foreach ($documentFiles as $file) {
        $publicUrl = "/storage/verification_documents/{$file}";
        echo "<p>- <a href='{$publicUrl}' target='_blank'>{$file}</a></p>";
    }
} else {
    echo "<p style='color: red;'>❌ Documents directory does not exist</p>";
}

?>

<script>
function testViewDocument(url) {
    console.log('Testing document view:', url);
    window.open(url, '_blank');
}

function testReview(id, userName) {
    console.log('Testing review for:', id, userName);
    alert(`Testing review for ${userName} (ID: ${id})`);
}
</script>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
div { margin: 10px 0; }
button { padding: 5px 10px; margin: 2px; cursor: pointer; }
</style>
