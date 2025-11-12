<?php

// database/migrations/2025_09_04_000005_create_responsables_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_id')->constrained('tipos_responsables')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->string('cedula', 20)->unique();
            $table->string('nombre', 150);
            $table->string('correo', 150)->nullable();
            $table->string('telefono', 50)->nullable();
            // sin timestamps; agrega si los necesitas
            $table->index('tipo_id', 'idx_responsable_tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responsables');
    }
};
