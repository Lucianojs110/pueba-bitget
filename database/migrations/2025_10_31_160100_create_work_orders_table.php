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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');

            // Datos de la orden
            $table->text('service_summary')->nullable(); // resumen general del servicio
            $table->integer('odometer_at_service')->nullable(); // lectura del odómetro

            // Fechas clave
            $table->date('admission_date')->nullable(); // ingreso del vehículo
            $table->date('promise_date')->nullable();   // fecha prometida
            $table->date('delivery_date')->nullable();  // entrega efectiva

            // Estado de la orden
            $table->enum('status', ['pending', 'in_progress', 'delivered'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
