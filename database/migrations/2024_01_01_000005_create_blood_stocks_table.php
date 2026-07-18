<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blood_group_id')->unique()->constrained('blood_groups')->restrictOnDelete();
            $table->unsignedInteger('units')->default(0);
            $table->enum('status', ['Sufficient', 'Low', 'Critical'])->default('Sufficient');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_stocks');
    }
};
