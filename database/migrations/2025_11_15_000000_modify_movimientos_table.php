<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign key, make bien_id nullable, re-create FK with SET NULL
        DB::statement('ALTER TABLE movimientos DROP FOREIGN KEY IF EXISTS movimientos_bien_id_foreign');

        // Make bien_id nullable (works on MySQL / MariaDB). If your DB is SQLite/Postgres, adjust accordingly.
        try {
            DB::statement('ALTER TABLE movimientos MODIFY bien_id BIGINT UNSIGNED NULL');
        } catch (\Throwable $e) {
            // Ignore - some DB engines or older MySQL versions may fail; schema change may be handled differently.
            report($e);
        }

        try {
            DB::statement('ALTER TABLE movimientos ADD CONSTRAINT movimientos_bien_id_foreign FOREIGN KEY (bien_id) REFERENCES bienes(id) ON DELETE SET NULL ON UPDATE CASCADE');
        } catch (\Throwable $e) {
            // Ignore if FK already exists or DB doesn't support this statement in this form
            report($e);
        }

        Schema::table('movimientos', function (Blueprint $table) {
            if (! Schema::hasColumn('movimientos', 'subject_type')) {
                $table->string('subject_type')->nullable()->after('bien_id');
            }

            if (! Schema::hasColumn('movimientos', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('subject_type');
            }
        });

        // Add index only if it doesn't already exist (prevents duplicate index error on MySQL)
        $idx = DB::select("SELECT COUNT(1) as cnt FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = 'movimientos' AND index_name = 'idx_mov_subject'");
        $count = 0;
        if (! empty($idx) && isset($idx[0]->cnt)) {
            $count = (int) $idx[0]->cnt;
        }

        if ($count === 0) {
            Schema::table('movimientos', function (Blueprint $table) {
                $table->index(['subject_type', 'subject_id'], 'idx_mov_subject');
            });
        }
    }

    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            if (Schema::hasColumn('movimientos', 'subject_type')) {
                $table->dropIndex('idx_mov_subject');
                $table->dropColumn('subject_type');
            }

            if (Schema::hasColumn('movimientos', 'subject_id')) {
                $table->dropColumn('subject_id');
            }
        });

        // Restore bien_id to NOT NULL and cascade on delete. Be careful: this will fail if there are NULL values.
        DB::statement('ALTER TABLE movimientos DROP FOREIGN KEY IF EXISTS movimientos_bien_id_foreign');
        DB::statement('ALTER TABLE movimientos MODIFY bien_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE movimientos ADD CONSTRAINT movimientos_bien_id_foreign FOREIGN KEY (bien_id) REFERENCES bienes(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }
};
