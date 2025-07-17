<!DOCTYPE html>
<html>
<head>
    <title>Direct Test - Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin: 15px 0; }
        input { padding: 10px; width: 250px; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
        .result { margin: 20px 0; padding: 10px; border: 1px solid #ddd; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Admin Direct Login Test</h1>
    
    <div class="form-group">
        <h3>Step 1: Login as Admin</h3>
        <form action="/login" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Email:</label><br>
                <input type="email" name="email" value="tran2@gmail.com" required>
            </div>
            <div class="form-group">
                <label>Password:</label><br>
                <input type="password" name="password" value="admin123" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <div class="form-group">
        <h3>Step 2: Direct Links</h3>
        <p><a href="/admin" target="_blank">Admin Panel</a></p>
        <p><a href="/admin/verification-requests" target="_blank">Verification Requests</a></p>
        <p><a href="/test-verification-system.php" target="_blank">Verification System Test</a></p>
        <p><a href="/js-test.html" target="_blank">JavaScript Test</a></p>
    </div>

    <div class="form-group">
        <h3>Current Status</h3>
        @auth
            <div class="result success">
                <p>✅ Logged in as: {{ Auth::user()->email }}</p>
                <p>Role: {{ Auth::user()->role }}</p>
                @if(Auth::user()->isAdmin())
                    <p>✅ Admin access confirmed</p>
                    <p><strong>You can now access:</strong></p>
                    <ul>
                        <li><a href="/admin/verification-requests">Verification Requests</a></li>
                        <li><a href="/admin">Admin Panel</a></li>
                    </ul>
                @else
                    <p>❌ Not an admin user</p>
                @endif
            </div>
        @else
            <div class="result error">
                <p>❌ Not logged in</p>
            </div>
        @endauth
    </div>

    <div class="form-group">
        <h3>Test Data</h3>
        @php
            $verificationCount = \App\Models\VerificationRequest::count();
            $pendingCount = \App\Models\VerificationRequest::where('status', 'pending')->count();
        @endphp
        <div class="result">
            <p>Total verification requests: {{ $verificationCount }}</p>
            <p>Pending requests: {{ $pendingCount }}</p>
            @if($pendingCount > 0)
                @php $sample = \App\Models\VerificationRequest::where('status', 'pending')->with('user')->first(); @endphp
                <p>Sample request for user: {{ $sample->user->full_name }}</p>
                <p>Document: <a href="{{ asset('storage/' . $sample->document_path) }}" target="_blank">{{ $sample->document_path }}</a></p>
            @endif
        </div>
    </div>
</body>
</html>
