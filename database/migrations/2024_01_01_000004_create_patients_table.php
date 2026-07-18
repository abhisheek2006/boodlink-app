<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);
            $table->string('emergency_contact', 20);

            $table->foreignId('required_blood_group_id')->nullable()
                ->constrained('blood_groups')->nullOnDelete();

            $table->timestamps();

            $table->index(['city', 'state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
