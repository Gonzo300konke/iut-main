<?php

// database/migrations/2025_09_04_000004_create_tipos_responsables_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_responsables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_responsables');
    }
};
