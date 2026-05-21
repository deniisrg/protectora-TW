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
        Schema::table('solicitudes_adopcion', function (Blueprint $table) {
            // Datos personales
            $table->string('apellidos', 150)->nullable()->after('id_usuario');
            $table->date('fecha_nacimiento')->nullable()->after('apellidos');
            $table->string('direccion', 255)->nullable()->after('fecha_nacimiento');
            $table->string('ciudad', 100)->nullable()->after('direccion');
            $table->string('provincia', 100)->nullable()->after('ciudad');
            $table->string('codigo_postal', 10)->nullable()->after('provincia');
            // Cuestionario
            $table->text('familia_miembros')->nullable()->after('mensaje');
            $table->text('donde_vivira')->nullable()->after('familia_miembros');
            $table->text('razones_adoptar')->nullable()->after('donde_vivira');
            $table->text('mascotas_anteriores')->nullable()->after('razones_adoptar');
            $table->text('mascotas_actuales')->nullable()->after('mascotas_anteriores');
            $table->text('opinion_esterilizacion')->nullable()->after('mascotas_actuales');
            $table->text('gasto_veterinario')->nullable()->after('opinion_esterilizacion');
            $table->boolean('acepta_visitas')->nullable()->after('gasto_veterinario');
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes_adopcion', function (Blueprint $table) {
            $table->dropColumn([
                'apellidos', 'fecha_nacimiento', 'direccion', 'ciudad', 'provincia', 'codigo_postal',
                'familia_miembros', 'donde_vivira', 'razones_adoptar', 'mascotas_anteriores',
                'mascotas_actuales', 'opinion_esterilizacion', 'gasto_veterinario', 'acepta_visitas',
            ]);
        });
    }
};
