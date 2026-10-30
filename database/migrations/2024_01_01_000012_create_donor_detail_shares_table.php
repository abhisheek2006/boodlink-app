<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donor_detail_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_session_id')->constrained('donation_sessions')->cascadeOnDelete();
            $table->foreignId('donor_id')->constrained('donors')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();

            $table->timestamp('shared_at');
            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();

            $table->unique('donation_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donor_detail_shares');
    }
};
