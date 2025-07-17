<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('verification_requests', function (Blueprint $table) {
            // Add user_id column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('id');
            }
            
            // Add document_type column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'document_type')) {
                $table->enum('document_type', ['carte_nationale', 'passport'])->after('user_id');
            }
            
            // Add document_path column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'document_path')) {
                $table->string('document_path')->after('document_type');
            }
            
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('document_path');
            }
            
            // Add admin_notes column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
            
            // Add reviewed_by column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null')->after('admin_notes');
            }
            
            // Add reviewed_at column if it doesn't exist
            if (!Schema::hasColumn('verification_requests', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verification_requests', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'document_type', 'document_path', 'status', 'admin_notes', 'reviewed_by', 'reviewed_at']);
        });
    }
};
