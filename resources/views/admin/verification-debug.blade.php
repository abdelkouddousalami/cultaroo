<!DOCTYPE html>
<html>
<head>
    <title>Verification Debug Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ccc; }
        .success { color: green; }
        .error { color: red; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Verification System Debug Test</h1>

    <div class="test-section">
        <h2>Authentication Check</h2>
        @auth
            <p class="success">✅ User is authenticated: {{ Auth::user()->email }}</p>
            <p>Role: {{ Auth::user()->role ?? 'No role set' }}</p>
            @if(Auth::user()->isAdmin())
                <p class="success">✅ User has admin privileges</p>
            @else
                <p class="error">❌ User does not have admin privileges</p>
            @endif
        @else
            <p class="error">❌ User is not authenticated</p>
        @endauth
    </div>

    <div class="test-section">
        <h2>Database Test</h2>
        @php
            try {
                $verificationCount = \App\Models\VerificationRequest::count();
                $pendingCount = \App\Models\VerificationRequest::where('status', 'pending')->count();
                echo "<p class='success'>✅ Database connection successful</p>";
                echo "<p>Total verification requests: {$verificationCount}</p>";
                echo "<p>Pending requests: {$pendingCount}</p>";
                
                if ($pendingCount > 0) {
                    $sample = \App\Models\VerificationRequest::where('status', 'pending')->with('user')->first();
                    if ($sample) {
                        echo "<p>Sample request ID: {$sample->id}</p>";
                        echo "<p>User: {$sample->user->full_name}</p>";
                        echo "<p>Document path: {$sample->document_path}</p>";
                        
                        $fullPath = storage_path('app/public/' . $sample->document_path);
                        $publicPath = asset('storage/' . $sample->document_path);
                        echo "<p>Full path: {$fullPath}</p>";
                        echo "<p>Public URL: <a href='{$publicPath}' target='_blank'>{$publicPath}</a></p>";
                        echo "<p>File exists: " . (file_exists($fullPath) ? '✅ Yes' : '❌ No') . "</p>";
                    }
                }
            } catch (Exception $e) {
                echo "<p class='error'>❌ Database error: " . $e->getMessage() . "</p>";
            }
        @endphp
    </div>

    <div class="test-section">
        <h2>Route Test</h2>
        @php
            try {
                $verificationRoute = route('admin.verification-requests');
                $updateRoute = route('admin.verification-requests.update', ['verificationRequest' => 1]);
                echo "<p>Verification requests route: <a href='{$verificationRoute}'>{$verificationRoute}</a></p>";
                echo "<p>Update route template: {$updateRoute}</p>";
            } catch (Exception $e) {
                echo "<p class='error'>❌ Route error: " . $e->getMessage() . "</p>";
            }
        @endphp
    </div>

    <div class="test-section">
        <h2>JavaScript Test</h2>
        <button onclick="testCsrfToken()">Test CSRF Token</button>
        <button onclick="testFetchRequest()">Test Fetch Request</button>
        <button onclick="testViewDocument()">Test View Document</button>
        <div id="test-results"></div>
    </div>

    <div class="test-section">
        <h2>Manual Test Forms</h2>
        
        @if(\App\Models\VerificationRequest::where('status', 'pending')->count() > 0)
            @php $testRequest = \App\Models\VerificationRequest::where('status', 'pending')->first(); @endphp
            
            <h3>Test Document Viewing</h3>
            <button onclick="viewDocument('{{ asset('storage/' . $testRequest->document_path) }}')">
                View Test Document
            </button>
            
            <h3>Test Review Modal</h3>
            <button onclick="showReviewModal({{ $testRequest->id }}, '{{ addslashes($testRequest->user->full_name) }}')">
                Show Review Modal
            </button>
        @else
            <p>No pending verification requests to test with.</p>
        @endif
    </div>

    <!-- Modal for document viewing -->
    <div id="documentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none;">
        <div style="position: relative; top: 50px; margin: 0 auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 800px; background: white; border-radius: 8px;">
            <div style="display: flex; justify-between; align-items: center; margin-bottom: 20px;">
                <h3>Document Preview</h3>
                <button onclick="closeDocumentModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            </div>
            <div id="documentContent" style="text-align: center; max-height: 400px; overflow: auto;"></div>
        </div>
    </div>

    <!-- Modal for review -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none;">
        <div style="position: relative; top: 100px; margin: 0 auto; padding: 20px; border: 1px solid #888; width: 400px; background: white; border-radius: 8px;">
            <h3>Review Verification Request</h3>
            <form id="reviewForm">
                <input type="hidden" id="requestId" name="request_id">
                
                <div style="margin: 10px 0;">
                    <label>User:</label>
                    <p id="userName"></p>
                </div>

                <div style="margin: 10px 0;">
                    <label>Decision:</label>
                    <select name="status" style="width: 100%; padding: 5px;">
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>

                <div style="margin: 10px 0;">
                    <label>Admin Notes (optional):</label>
                    <textarea name="admin_notes" rows="3" style="width: 100%; padding: 5px;" placeholder="Add any notes about this decision..."></textarea>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="closeReviewModal()" style="margin-right: 10px;">Cancel</button>
                    <button type="submit">Submit Review</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function testCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            const results = document.getElementById('test-results');
            
            if (token) {
                results.innerHTML = '<p class="success">✅ CSRF token found: ' + token.getAttribute('content').substring(0, 20) + '...</p>';
            } else {
                results.innerHTML = '<p class="error">❌ CSRF token not found</p>';
            }
        }

        function testFetchRequest() {
            const results = document.getElementById('test-results');
            results.innerHTML = '<p>Testing fetch request...</p>';
            
            fetch('/admin/verification-requests', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    results.innerHTML += '<p class="success">✅ GET request successful (status: ' + response.status + ')</p>';
                } else {
                    results.innerHTML += '<p class="error">❌ GET request failed (status: ' + response.status + ')</p>';
                }
            })
            .catch(error => {
                results.innerHTML += '<p class="error">❌ Fetch error: ' + error.message + '</p>';
            });
        }

        function testViewDocument() {
            const testUrl = '/storage/verification_documents/test.pdf';
            viewDocument(testUrl);
        }

        function viewDocument(documentUrl) {
            console.log('Attempting to view document:', documentUrl);
            
            const modal = document.getElementById('documentModal');
            const content = document.getElementById('documentContent');
            
            if (!documentUrl || documentUrl === '') {
                alert('Document URL is not available');
                return;
            }
            
            if (documentUrl.toLowerCase().includes('.pdf')) {
                content.innerHTML = `
                    <div>
                        <embed src="${documentUrl}" type="application/pdf" width="100%" height="400px" style="min-height: 400px;" />
                        <p style="margin-top: 10px;">
                            <a href="${documentUrl}" target="_blank" style="color: blue; text-decoration: underline;">
                                Open in new tab if preview doesn't work
                            </a>
                        </p>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div>
                        <img src="${documentUrl}" 
                             alt="Document" 
                             style="max-width: 100%; height: auto; border-radius: 8px;"
                             onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';" />
                        <div style="display: none; color: red; padding: 10px; border: 1px solid red; border-radius: 4px; background: #ffe6e6;">
                            <p><strong>Unable to load image</strong></p>
                            <p>
                                <a href="${documentUrl}" target="_blank" style="color: blue; text-decoration: underline;">
                                    Click here to view document directly
                                </a>
                            </p>
                        </div>
                    </div>
                `;
            }
            
            modal.style.display = 'block';
        }

        function closeDocumentModal() {
            document.getElementById('documentModal').style.display = 'none';
        }

        function showReviewModal(requestId, userName) {
            document.getElementById('requestId').value = requestId;
            document.getElementById('userName').textContent = userName;
            document.getElementById('reviewModal').style.display = 'block';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
        }

        // Handle review form submission
        document.getElementById('reviewForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const requestId = document.getElementById('requestId').value;
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            const status = formData.get('status');
            const adminNotes = formData.get('admin_notes');
            
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`/admin/verification-requests/${requestId}`, {
                    method: 'PUT',
                    body: JSON.stringify({
                        status: status,
                        admin_notes: adminNotes,
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    alert('Verification request updated successfully!');
                    closeReviewModal();
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'An error occurred'));
                    console.error('Response error:', data);
                }
            } catch (error) {
                alert('Error: An error occurred while updating the request');
                console.error('Fetch error:', error);
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
