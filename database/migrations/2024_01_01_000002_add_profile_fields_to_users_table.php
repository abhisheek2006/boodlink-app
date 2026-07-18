<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['Admin', 'Donor', 'Patient'])->default('Patient')->after('id');
            $table->string('phone', 20)->nullable()->after('email');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('phone');
            $table->date('dob')->nullable()->after('gender');
            $table->string('profile_photo')->nullable()->after('dob');

            $table->enum('status', ['Active', 'Inactive', 'Suspended', 'Banned'])
                ->default('Active')
                ->after('profile_photo');

            $table->dateTime('suspended_until')->nullable()->after('status');
            $table->text('suspension_reason')->nullable()->after('suspended_until');

            $table->dateTime('banned_at')->nullable()->after('suspension_reason');
            $table->text('ban_reason')->nullable()->after('banned_at');
            $table->foreignId('banned_by')->nullable()->after('ban_reason')
                ->constrained('users')->nullOnDelete();

            $table->dateTime('last_login_at')->nullable()->after('banned_by');

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('banned_by');
            $table->dropColumn([
                'role', 'phone', 'gender', 'dob', 'profile_photo',
                'status', 'suspended_until', 'suspension_reason',
                'banned_at', 'ban_reason', 'last_login_at',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
