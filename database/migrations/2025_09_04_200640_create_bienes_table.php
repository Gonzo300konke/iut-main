<?php

// database/migrations/2025_09_04_000008_create_bienes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bienes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dependencia_id')->constrained('dependencias')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('responsable_id')->nullable()
                ->constrained('responsables')->nullOnDelete()->cascadeOnUpdate();

            $table->string('codigo', 50)->unique();
            $table->text('descripcion');
            $table->string('ubicacion', 255)->nullable();

            // ENUM con "Ñ": asegúrate de usar utf8mb4 en tu conexión
            $table->enum('estado', ['DAÑADO', 'ACTIVO', 'EN_REPARACION', 'EN_CAMINO', 'EXTRAVIADO'])
                ->default('ACTIVO');
            $table->timestamp('fecha_cambio_estado')->nullable();

            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamps();

            $table->index('dependencia_id', 'idx_bien_dependencia');
            $table->index('responsable_id', 'idx_bien_responsable');
            $table->index('estado', 'idx_bien_estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bienes');
    }
};
