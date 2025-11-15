<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Create a temporary table with bien_id nullable, copy data, swap tables.
        Schema::create('movimientos_new', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bien_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('tipo', 80);
            $table->timestamp('fecha')->useCurrent();
            $table->text('observaciones')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->index('bien_id', 'idx_mov_bien');
            $table->index('fecha', 'idx_mov_fecha');
            $table->index(['subject_type', 'subject_id'], 'idx_mov_subject');
        });

        // Copy data from old movimientos into new table (preserve ids)
        $rows = DB::table('movimientos')->get();
        foreach ($rows as $row) {
            DB::table('movimientos_new')->insert([
                'id' => $row->id,
                'bien_id' => $row->bien_id,
                'subject_type' => $row->subject_type ?? null,
                'subject_id' => $row->subject_id ?? null,
                'tipo' => $row->tipo,
                'fecha' => $row->fecha,
                'observaciones' => $row->observaciones,
                'usuario_id' => $row->usuario_id,
            ]);
        }

        Schema::dropIfExists('movimientos');
        Schema::rename('movimientos_new', 'movimientos');
    }

    public function down(): void
    {
        // Recreate original table with bien_id NOT NULL and restore data where possible.
        Schema::create('movimientos_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_id')->constrained('bienes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('tipo', 80);
            $table->timestamp('fecha')->useCurrent();
            $table->text('observaciones')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->index('bien_id', 'idx_mov_bien');
            $table->index('fecha', 'idx_mov_fecha');
            $table->index(['subject_type', 'subject_id'], 'idx_mov_subject');
        });

        // Copy data back; for rows with null bien_id set a default 0 (will fail if FK enforced) — keep only rows with bien_id
        $rows = DB::table('movimientos')->get();
        foreach ($rows as $row) {
            if ($row->bien_id === null) {
                // skip rows without bien_id when restoring to a strict schema
                continue;
            }

            DB::table('movimientos_old')->insert([
                'id' => $row->id,
                'bien_id' => $row->bien_id,
                'subject_type' => $row->subject_type ?? null,
                'subject_id' => $row->subject_id ?? null,
                'tipo' => $row->tipo,
                'fecha' => $row->fecha,
                'observaciones' => $row->observaciones,
                'usuario_id' => $row->usuario_id,
            ]);
        }

        Schema::dropIfExists('movimientos');
        Schema::rename('movimientos_old', 'movimientos');
    }
};
