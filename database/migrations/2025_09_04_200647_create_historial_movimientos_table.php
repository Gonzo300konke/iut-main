<?php

// database/migrations/2025_09_04_000010_create_historial_movimientos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movimiento_id')->constrained('movimientos')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('fecha')->useCurrent();
            $table->text('detalle');
            $table->index('movimiento_id', 'idx_hist_mov');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_movimientos');
    }
};
