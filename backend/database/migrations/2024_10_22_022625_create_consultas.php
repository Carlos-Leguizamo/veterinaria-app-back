<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historias_clinicas_id')->constrained()->onDelete('cascade');
            $table->foreignId('mascotas_id')->constrained()->onDelete('cascade');
            $table->foreignId('veterinarios_id')->constrained()->onDelete('cascade');
            $table->foreignId('amos_id')->constrained()->onDelete('cascade');
            $table->date('fecha_consulta');
            $table->text('detalles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
