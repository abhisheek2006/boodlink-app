<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('donor_id')->constrained('donors')->cascadeOnDelete();
            $table->foreignId('blood_request_id')->unique()->constrained('blood_requests')->cascadeOnDelete();

            $table->dateTime('started_at');
            $table->dateTime('expires_at');
            $table->dateTime('ended_at')->nullable();

            $table->enum('status', ['Pending', 'Active', 'Completed', 'Expired', 'Cancelled'])
                ->default('Active');

            $table->boolean('contact_shared')->default(false);
            $table->unsignedInteger('session_duration')->nullable()->comment('in seconds, set on completion/end');

            $table->timestamps();

            $table->index(['donor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_sessions');
    }
};
