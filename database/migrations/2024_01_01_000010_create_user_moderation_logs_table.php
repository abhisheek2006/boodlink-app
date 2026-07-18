<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_moderation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();

            $table->enum('action', [
                'Activated', 'Deactivated', 'Suspended', 'Unsuspended',
                'Banned', 'Unbanned', 'Deleted', 'Password Reset',
            ]);
            $table->text('reason')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_moderation_logs');
    }
};
