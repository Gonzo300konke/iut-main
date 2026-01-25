<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bienes', function (Blueprint $table) {
            if (! Schema::hasColumn('bienes', 'tipo_bien')) {
                $table->string('tipo_bien', 50)->default('OTROS')->after('estado');
                $table->index('tipo_bien', 'idx_bien_tipo_bien');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bienes', function (Blueprint $table) {
            if (Schema::hasColumn('bienes', 'tipo_bien')) {
                $table->dropIndex('idx_bien_tipo_bien');
                $table->dropColumn('tipo_bien');
            }
        });
    }
};
