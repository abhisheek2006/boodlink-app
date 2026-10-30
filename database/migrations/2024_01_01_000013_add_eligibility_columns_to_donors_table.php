<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            if (! Schema::hasColumn('donors', 'eligible_again_at')) {
                $table->timestamp('eligible_again_at')->nullable()->after('updated_at');
            }

            if (! Schema::hasColumn('donors', 'medical_review_required')) {
                $table->boolean('medical_review_required')->default(false)->after('eligible_again_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            $columns = array_values(array_filter(
                ['eligible_again_at', 'medical_review_required'],
                fn ($c) => Schema::hasColumn('donors', $c),
            ));

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
