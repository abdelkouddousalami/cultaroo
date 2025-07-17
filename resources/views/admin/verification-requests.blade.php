@extends('layouts.app')

@section('title', 'Verification Requests')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-100 via-white to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Verification Requests</h1>
                    <p class="text-gray-600 mt-1">Review and manage user identity verification requests</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                        <span class="font-semibold">Total: {{ $requests->total() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Filter -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex flex-wrap gap-4">
                <button onclick="filterByStatus('all')" class="filter-btn active px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    All Requests
                </button>
                <button onclick="filterByStatus('pending')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-yellow-100 text-yellow-700 hover:bg-yellow-200">
                    Pending
                </button>
                <button onclick="filterByStatus('approved')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-green-100 text-green-700 hover:bg-green-200">
                    Approved
                </button>
                <button onclick="filterByStatus('rejected')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-red-100 text-red-700 hover:bg-red-200">
                    Rejected
                </button>
            </div>
        </div>

        <!-- Verification Requests List -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewed By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($requests as $request)
                                <tr class="verification-row" data-status="{{ $request->status }}">
                                    <!-- User Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-400 to-blue-500 flex items-center justify-center text-white font-semibold">
                                                    {{ substr($request->user->full_name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $request->user->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $request->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Document Type -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($request->document_type === 'carte_nationale') bg-blue-100 text-blue-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ $request->document_type_display }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>

                                    <!-- Submitted Date -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $request->created_at->format('M d, Y') }}
                                        <div class="text-xs text-gray-400">{{ $request->created_at->format('H:i') }}</div>
                                    </td>

                                    <!-- Reviewed By -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($request->reviewer)
                                            <div>{{ $request->reviewer->full_name }}</div>
                                            <div class="text-xs text-gray-400">{{ $request->reviewed_at?->format('M d, Y') }}</div>
                                        @else
                                            <span class="text-gray-400">Not reviewed</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button type="button" onclick="viewDocument('{{ asset('storage/' . $request->document_path) }}')" 
                                                class="text-blue-600 hover:text-blue-900 transition-colors duration-200 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-md">
                                                View Document
                                            </button>
                                            @if($request->status === 'pending')
                                                <button type="button" onclick="showReviewModal({{ $request->id }}, '{{ addslashes($request->user->full_name) }}')"
                                                    class="text-green-600 hover:text-green-900 transition-colors duration-200 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md">
                                                    Review
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No verification requests</h3>
                    <p class="mt-1 text-sm text-gray-500">No users have submitted verification requests yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
    <div class="relative top-10 mx-auto p-0 border-0 w-full max-w-lg shadow-2xl rounded-2xl bg-white my-8">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold">Review Verification Request</h3>
                    <p class="text-blue-100 text-sm mt-1">Make a decision on user verification</p>
                </div>
                <button onclick="closeReviewModal()" class="text-blue-100 hover:text-white transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form id="reviewForm" class="space-y-6">
                <input type="hidden" id="requestId" name="request_id">
                
                <!-- User Information -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        User:
                    </label>
                    <p id="userName" class="text-gray-900 font-medium text-lg"></p>
                </div>

                <!-- Decision Section -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Decision:
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:border-green-300 hover:bg-green-50 transition-all duration-200 cursor-pointer">
                            <input type="radio" name="status" value="approved" class="w-4 h-4 text-green-600 focus:ring-green-500 focus:ring-2">
                            <div class="ml-3 flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Approve</div>
                                    <div class="text-sm text-gray-500">Grant verification status</div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl hover:border-red-300 hover:bg-red-50 transition-all duration-200 cursor-pointer">
                            <input type="radio" name="status" value="rejected" class="w-4 h-4 text-red-600 focus:ring-red-500 focus:ring-2">
                            <div class="ml-3 flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Reject</div>
                                    <div class="text-sm text-gray-500">Deny verification request</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Admin Notes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-3">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Admin Notes (optional):
                    </label>
                    <div class="relative">
                        <textarea name="admin_notes" rows="4" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="Add any notes about this decision..."></textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                            Optional
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeReviewModal()" 
                        class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200 border border-gray-300">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div id="documentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Document Preview</h3>
            <button onclick="closeDocumentModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="text-center">
            <div id="documentContent" class="max-h-96 overflow-auto"></div>
        </div>
    </div>
</div>

<style>
/* Modal animations */
#reviewModal .relative {
    transform: scale(0.9);
    opacity: 0;
    transition: all 0.3s ease-out;
}

#reviewModal:not(.hidden) .relative {
    transform: scale(1);
    opacity: 1;
}

/* Radio button enhanced styling */
input[type="radio"]:checked + div {
    background-color: #f8fafc;
}

input[type="radio"][value="approved"]:checked + div {
    background-color: #f0fdf4 !important;
    border-color: #22c55e !important;
}

input[type="radio"][value="rejected"]:checked + div {
    background-color: #fef2f2 !important;
    border-color: #ef4444 !important;
}

/* Button ripple effect */
.btn-ripple {
    position: relative;
    overflow: hidden;
}

.btn-ripple::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transition: width 0.3s, height 0.3s;
    transform: translate(-50%, -50%);
}

.btn-ripple:active::before {
    width: 300px;
    height: 300px;
}
</style>

    <!-- JavaScript -->
    <script>
        // Debug console logging
        console.log('Verification requests page loaded');
        console.log('CSRF token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));

        // Global error handler
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
        });

        function filterByStatus(status) {
            console.log('Filtering by status:', status);
            const rows = document.querySelectorAll('.verification-row');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update button states
            buttons.forEach(btn => btn.classList.remove('active', 'bg-blue-100', 'text-blue-700'));
            event.target.classList.add('active', 'bg-blue-100', 'text-blue-700');
            
            // Filter rows
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function showReviewModal(requestId, userName) {
            console.log('Opening review modal for:', requestId, userName);
            try {
                document.getElementById('requestId').value = requestId;
                document.getElementById('userName').textContent = userName;
                
                // Reset form state
                const form = document.getElementById('reviewForm');
                form.reset();
                
                // Remove any existing selection highlights
                const radioLabels = form.querySelectorAll('label[for*="status"]');
                radioLabels.forEach(label => {
                    label.classList.remove('border-green-300', 'bg-green-50', 'border-red-300', 'bg-red-50');
                    label.classList.add('border-gray-200');
                });
                
                // Show modal with animation
                const modal = document.getElementById('reviewModal');
                modal.classList.remove('hidden');
                
                // Add smooth entrance animation
                setTimeout(() => {
                    const modalContent = modal.querySelector('.relative');
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                }, 10);
                
                console.log('Review modal opened successfully');
            } catch (error) {
                console.error('Error opening review modal:', error);
                alert('Error opening review modal: ' + error.message);
            }
        }

        function closeReviewModal() {
            console.log('Closing review modal');
            try {
                document.getElementById('reviewModal').classList.add('hidden');
                document.getElementById('reviewForm').reset();
                console.log('Review modal closed successfully');
            } catch (error) {
                console.error('Error closing review modal:', error);
            }
        }

        function viewDocument(documentUrl) {
            console.log('Attempting to view document:', documentUrl);
            
            try {
                const modal = document.getElementById('documentModal');
                const content = document.getElementById('documentContent');
                
                // Check if the document URL is valid
                if (!documentUrl || documentUrl === '') {
                    console.error('Document URL is empty');
                    showAlert('Document URL is not available', 'error');
                    return;
                }
                
                // Check if it's a PDF or image
                if (documentUrl.toLowerCase().includes('.pdf')) {
                    console.log('Loading PDF document');
                    content.innerHTML = `
                        <div class="text-center">
                            <embed src="${documentUrl}" type="application/pdf" width="100%" height="400px" style="min-height: 400px;" />
                            <p class="mt-2 text-sm text-gray-600">
                                <a href="${documentUrl}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                    Open in new tab if preview doesn't work
                                </a>
                            </p>
                        </div>
                    `;
                } else {
                    console.log('Loading image document');
                    content.innerHTML = `
                        <div class="text-center">
                            <img src="${documentUrl}" 
                                 alt="Document" 
                                 class="max-w-full h-auto mx-auto rounded-lg shadow-lg"
                                 onload="console.log('Image loaded successfully')"
                                 onerror="console.error('Image failed to load'); this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';" />
                            <div style="display: none;" class="text-red-600 p-4 border border-red-300 rounded-lg bg-red-50">
                                <p class="font-medium">Unable to load image</p>
                                <p class="text-sm mt-1">
                                    <a href="${documentUrl}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                        Click here to view document directly
                                    </a>
                                </p>
                            </div>
                        </div>
                    `;
                }
                
                modal.classList.remove('hidden');
                console.log('Document modal opened successfully');
            } catch (error) {
                console.error('Error in viewDocument:', error);
                alert('Error opening document: ' + error.message);
            }
        }

        function closeDocumentModal() {
            console.log('Closing document modal');
            try {
                document.getElementById('documentModal').classList.add('hidden');
                console.log('Document modal closed successfully');
            } catch (error) {
                console.error('Error closing document modal:', error);
            }
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
            }`;
            alertDiv.textContent = message;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Handle review form submission
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced radio button interactions
            const radioButtons = document.querySelectorAll('input[name="status"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove previous styling from all labels
                    radioButtons.forEach(r => {
                        const label = r.closest('label');
                        label.classList.remove('border-green-300', 'bg-green-50', 'border-red-300', 'bg-red-50', 'ring-2', 'ring-green-200', 'ring-red-200');
                        label.classList.add('border-gray-200');
                    });
                    
                    // Add styling to selected label
                    const selectedLabel = this.closest('label');
                    if (this.value === 'approved') {
                        selectedLabel.classList.remove('border-gray-200');
                        selectedLabel.classList.add('border-green-300', 'bg-green-50', 'ring-2', 'ring-green-200');
                    } else if (this.value === 'rejected') {
                        selectedLabel.classList.remove('border-gray-200');
                        selectedLabel.classList.add('border-red-300', 'bg-red-50', 'ring-2', 'ring-red-200');
                    }
                });
            });

            // Add ripple effect to submit button
            const submitBtn = document.querySelector('#reviewForm button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('btn-ripple');
            }

            const reviewForm = document.getElementById('reviewForm');
            if (reviewForm) {
                reviewForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    console.log('Review form submitted');
                    
                    const formData = new FormData(this);
                    const requestId = document.getElementById('requestId').value;
                    const submitBtn = e.target.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    
                    // Get form values
                    const status = formData.get('status');
                    const adminNotes = formData.get('admin_notes');
                    
                    console.log(`Form data - Status: ${status}, Notes: ${adminNotes}`);
                    
                    submitBtn.textContent = 'Processing...';
                    submitBtn.disabled = true;
                    
                    try {
                        const requestData = {
                            status: status,
                            admin_notes: adminNotes,
                            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        };
                        
                        console.log(`Sending PUT request to: /admin/verification-requests/${requestId}`);
                        
                        const response = await fetch(`/admin/verification-requests/${requestId}`, {
                            method: 'PUT',
                            body: JSON.stringify(requestData),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        
                        console.log(`Response status: ${response.status}`);
                        
                        const data = await response.json();
                        console.log('Response data:', data);
                        
                        if (response.ok && data.success) {
                            showAlert('Verification request updated successfully!', 'success');
                            closeReviewModal();
                            // Reload page to show updated status
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showAlert(data.message || 'An error occurred', 'error');
                            console.error('Response error:', data);
                        }
                    } catch (error) {
                        showAlert('An error occurred while updating the request', 'error');
                        console.error('Fetch error:', error);
                    } finally {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }
        });
    </script>
</div>

@endsection
