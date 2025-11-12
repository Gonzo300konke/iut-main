<?php

// database/migrations/2025_09_04_000009_create_movimientos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_id')->constrained('bienes')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('tipo', 80);
            $table->timestamp('fecha')->useCurrent();
            $table->text('observaciones')->nullable();
            $table->foreignId('usuario_id')->nullable()
                ->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();

            $table->index('bien_id', 'idx_mov_bien');
            $table->index('fecha', 'idx_mov_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
