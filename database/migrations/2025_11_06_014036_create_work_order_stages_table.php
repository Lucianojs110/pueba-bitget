<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('stage_template_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pendiente');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->unique(['work_order_id', 'stage_template_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_stages');
    }
};
