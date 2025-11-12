<?php

// database/migrations/2025_09_04_000003_create_dependencias_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dependencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_administradora_id')
                ->constrained('unidades_administradoras')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->string('codigo', 50);
            $table->string('nombre', 150);
            $table->timestamps();

            $table->unique(['unidad_administradora_id', 'codigo'], 'uq_dep_ua_codigo');
            $table->index('unidad_administradora_id', 'idx_dep_ua');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dependencias');
    }
};
