<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('donor_id')->nullable()->constrained('donors')->nullOnDelete();
            $table->foreignId('blood_group_id')->constrained('blood_groups')->restrictOnDelete();

            $table->unsignedTinyInteger('units_required');
            $table->enum('emergency_level', ['Low', 'Medium', 'High', 'Critical']);
            $table->text('reason');
            $table->string('hospital_name')->nullable();
            $table->date('required_date')->nullable();
            $table->text('additional_notes')->nullable();

            $table->enum('status', ['Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled'])
                ->default('Pending');

            $table->timestamps();

            $table->index(['status', 'blood_group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
