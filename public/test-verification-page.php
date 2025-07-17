<?php
// Test verification requests page access
require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';

// Start Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a request to the verification requests page
$request = Illuminate\Http\Request::create('/admin/verification-requests', 'GET');

try {
    // Process the request
    $response = $kernel->handle($request);
    
    echo "<h2>Verification Requests Page Test</h2>";
    echo "<p><strong>Status Code:</strong> " . $response->getStatusCode() . "</p>";
    
    if ($response->getStatusCode() === 200) {
        echo "<p style='color: green;'>✅ Page loads successfully!</p>";
        
        // Check if the response contains verification data
        $content = $response->getContent();
        if (strpos($content, 'Verification Requests') !== false) {
            echo "<p style='color: green;'>✅ Page title found</p>";
        }
        
        if (strpos($content, 'View Document') !== false) {
            echo "<p style='color: green;'>✅ View Document button found</p>";
        }
        
        if (strpos($content, 'Review') !== false) {
            echo "<p style='color: green;'>✅ Review button found</p>";
        }
        
        // Check for JavaScript functions
        if (strpos($content, 'viewDocument') !== false) {
            echo "<p style='color: green;'>✅ viewDocument function found</p>";
        }
        
        if (strpos($content, 'showReviewModal') !== false) {
            echo "<p style='color: green;'>✅ showReviewModal function found</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Page failed to load</p>";
        echo "<p><strong>Response:</strong></p>";
        echo "<pre>" . htmlspecialchars($response->getContent()) . "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
}

// Test document access
echo "<h3>Testing Document Access</h3>";

// Check if storage directory exists
$storagePath = '../storage/app/public/verification_documents';
if (is_dir($storagePath)) {
    echo "<p style='color: green;'>✅ Storage directory exists</p>";
    
    $files = scandir($storagePath);
    $documentFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..']);
    });
    
    if (count($documentFiles) > 0) {
        echo "<p style='color: green;'>✅ Found " . count($documentFiles) . " documents</p>";
        foreach ($documentFiles as $file) {
            $publicUrl = '/storage/verification_documents/' . $file;
            echo "<p>Document: <a href='{$publicUrl}' target='_blank'>{$file}</a></p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ No documents found</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Storage directory does not exist</p>";
}

// Test database verification requests
echo "<h3>Testing Database</h3>";
try {
    // Check if verification_requests table exists and has data
    $pdo = new PDO('sqlite:../database/database.sqlite');
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM verification_requests");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p style='color: green;'>✅ Database connection successful</p>";
    echo "<p><strong>Verification requests count:</strong> " . $result['count'] . "</p>";
    
    if ($result['count'] > 0) {
        $stmt = $pdo->query("SELECT id, document_type, status, document_path FROM verification_requests ORDER BY created_at DESC LIMIT 5");
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h4>Recent Verification Requests:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Document Type</th><th>Status</th><th>Document Path</th><th>File Exists</th></tr>";
        
        foreach ($requests as $request) {
            $filePath = '../storage/app/public/' . $request['document_path'];
            $fileExists = file_exists($filePath) ? '✅' : '❌';
            
            echo "<tr>";
            echo "<td>{$request['id']}</td>";
            echo "<td>{$request['document_type']}</td>";
            echo "<td>{$request['status']}</td>";
            echo "<td>{$request['document_path']}</td>";
            echo "<td>{$fileExists}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br><br><a href='/admin/verification-requests'>Go to Verification Requests Page</a>";
?>
