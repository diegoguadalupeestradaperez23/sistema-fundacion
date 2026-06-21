<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiario_id')->constrained('beneficiarios')->onDelete('cascade');
            $table->date('fecha');
            $table->string('evento')->default('General');
            $table->boolean('presente')->default(true);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['beneficiario_id', 'fecha', 'evento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
