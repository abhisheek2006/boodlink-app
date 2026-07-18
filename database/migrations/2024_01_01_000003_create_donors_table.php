<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('blood_group_id')->constrained('blood_groups')->restrictOnDelete();

            $table->decimal('weight', 5, 2);
            $table->text('medical_history')->nullable();

            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);

            $table->enum('availability', ['Available', 'Busy', 'Waiting'])->default('Available');
            $table->unsignedInteger('total_donations')->default(0);
            $table->string('current_badge')->nullable();
            $table->unsignedInteger('current_rank')->nullable();

            $table->date('last_donation_date')->nullable();
            $table->date('next_eligible_date')->nullable();

            $table->enum('donation_status', ['Idle', 'In Session', 'Cooldown'])->default('Idle');

            $table->timestamps();

            $table->index(['blood_group_id', 'city', 'state', 'availability']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
