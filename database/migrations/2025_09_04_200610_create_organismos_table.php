<?php

// database/migrations/2025_09_04_000001_create_organismos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organismos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organismos');
    }
};
