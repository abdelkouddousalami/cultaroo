<?php
// Test the exact code used in admin panel
require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/html');

echo "<h1>Admin Panel Verification Test</h1>";
echo "<p>Testing the exact code used in admin panel...</p>";

try {
    echo "<h2>Raw Counts:</h2>";
    
    // Test the exact code from admin panel
    $pendingCount = \App\Models\VerificationRequest::where('status', 'pending')->count();
    $approvedCount = \App\Models\VerificationRequest::where('status', 'approved')->count();
    $rejectedCount = \App\Models\VerificationRequest::where('status', 'rejected')->count();
    
    echo "<p><strong>Pending:</strong> {$pendingCount}</p>";
    echo "<p><strong>Approved:</strong> {$approvedCount}</p>";
    echo "<p><strong>Rejected:</strong> {$rejectedCount}</p>";
    
    echo "<h2>Route Test:</h2>";
    // Test if the route exists
    try {
        $url = route('admin.verification-requests');
        echo "<p><strong>Verification Requests URL:</strong> <a href='{$url}'>{$url}</a></p>";
    } catch (Exception $e) {
        echo "<p><strong>Route Error:</strong> {$e->getMessage()}</p>";
    }
    
    echo "<h2>All Verification Requests:</h2>";
    $requests = \App\Models\VerificationRequest::with('user')->get();
    
    if ($requests->count() > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>User</th><th>Email</th><th>Status</th><th>Document Type</th><th>Created</th></tr>";
        
        foreach ($requests as $request) {
            echo "<tr>";
            echo "<td>{$request->id}</td>";
            echo "<td>{$request->user->first_name} {$request->user->last_name}</td>";
            echo "<td>{$request->user->email}</td>";
            echo "<td>{$request->status}</td>";
            echo "<td>{$request->document_type}</td>";
            echo "<td>{$request->created_at}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No verification requests found.</p>";
    }
    
} catch (Exception $e) {
    echo "<p><strong>Error:</strong> {$e->getMessage()}</p>";
    echo "<p><strong>Trace:</strong> {$e->getTraceAsString()}</p>";
}

echo "<hr>";
echo "<h2>Quick Links:</h2>";
echo "<p><a href='/admin'>Admin Dashboard</a></p>";
echo "<p><a href='/admin/verification-requests'>Verification Requests</a></p>";
?>
