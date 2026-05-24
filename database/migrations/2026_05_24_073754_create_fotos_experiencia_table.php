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
        Schema::create('fotos_experiencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_experiencia')->constrained('experiencias')->onDelete('cascade');
            $table->string('nombre_archivo', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_experiencia');
    }
};
