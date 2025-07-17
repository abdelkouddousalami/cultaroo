<?php
// Simple verification check
require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: application/json');

try {
    $users = \App\Models\User::all();
    $verificationRequests = \App\Models\VerificationRequest::with('user')->get();
    
    $response = [
        'success' => true,
        'users' => $users->map(function($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
                'role' => $user->role,
                'is_admin' => $user->isAdmin()
            ];
        }),
        'verification_requests' => $verificationRequests->map(function($request) {
            return [
                'id' => $request->id,
                'user_email' => $request->user->email,
                'user_name' => $request->user->first_name . ' ' . $request->user->last_name,
                'document_type' => $request->document_type,
                'status' => $request->status,
                'created_at' => $request->created_at->format('Y-m-d H:i:s')
            ];
        })
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
