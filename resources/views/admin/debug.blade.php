@extends('layouts.app')

@section('title', 'Admin Panel Debug')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-100 via-white to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Admin Panel Debug</h1>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-2">Verification Counts Test</h2>
                    
                    @php
                        try {
                            $pendingCount = \App\Models\VerificationRequest::where('status', 'pending')->count();
                            $approvedCount = \App\Models\VerificationRequest::where('status', 'approved')->count();
                            $rejectedCount = \App\Models\VerificationRequest::where('status', 'rejected')->count();
                            echo "<p>✅ Model access successful</p>";
                            echo "<p><strong>Pending:</strong> {$pendingCount}</p>";
                            echo "<p><strong>Approved:</strong> {$approvedCount}</p>";
                            echo "<p><strong>Rejected:</strong> {$rejectedCount}</p>";
                        } catch (Exception $e) {
                            echo "<p>❌ Error: " . $e->getMessage() . "</p>";
                        }
                    @endphp
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-2">Route Test</h2>
                    
                    @php
                        try {
                            $url = route('admin.verification-requests');
                            echo "<p>✅ Route exists: <a href='{$url}' class='text-blue-600'>{$url}</a></p>";
                        } catch (Exception $e) {
                            echo "<p>❌ Route error: " . $e->getMessage() . "</p>";
                        }
                    @endphp
                </div>
            </div>
            
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-2">Verification Requests Card Test</h2>
                
                <!-- This is the exact card from admin panel -->
                <div class="admin-card rounded-2xl p-6 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Verification Requests</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pending Verification</span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                {{ \App\Models\VerificationRequest::where('status', 'pending')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Approved</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                {{ \App\Models\VerificationRequest::where('status', 'approved')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Rejected</span>
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                {{ \App\Models\VerificationRequest::where('status', 'rejected')->count() }}
                            </span>
                        </div>
                        <div class="pt-2 border-t border-gray-200">
                            <a href="{{ route('admin.verification-requests') }}" 
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                View All Requests →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Quick Actions</h2>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.panel') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Go to Admin Panel
                    </a>
                    <a href="{{ route('admin.verification-requests') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Go to Verification Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
