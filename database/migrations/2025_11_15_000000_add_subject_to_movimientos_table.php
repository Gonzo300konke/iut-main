<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            // Add polymorphic subject columns to allow movimientos for any model
            if (!Schema::hasColumn('movimientos', 'subject_type')) {
                $table->string('subject_type')->nullable()->after('bien_id');
            }
            if (!Schema::hasColumn('movimientos', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('subject_type');
            }
            $table->index(['subject_type', 'subject_id'], 'idx_mov_subject');
        });
    }

    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropIndex('idx_mov_subject');
            $table->dropColumn(['subject_type', 'subject_id']);
        });
    }
};
