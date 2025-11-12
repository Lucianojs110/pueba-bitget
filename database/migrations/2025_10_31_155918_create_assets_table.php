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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            // Relación con el cliente
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            // Datos del vehículo
            $table->string('brand');               // Marca
            $table->string('model');               // Modelo
            $table->year('year')->nullable();      // Año
            $table->string('plate')->nullable();   // Patente
            $table->string('vin')->nullable();     // Número VIN
            $table->text('notes')->nullable();     // Notas internas
            $table->integer('last_odometer')->nullable(); // Último odómetro registrado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
