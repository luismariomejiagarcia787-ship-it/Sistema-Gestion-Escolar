<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('documento')->unique();
            $table->string('telefono')->nullable();
            $table->string('especialidad')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // Add FK for cursos.profesor_id
        Schema::table('cursos', function (Blueprint $table) {
            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['profesor_id']);
        });
        Schema::dropIfExists('profesores');
    }
};
