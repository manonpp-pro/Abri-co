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
        // Une contrainte unique empêche un même utilisateur de réserver deux fois le même créneau.
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('service_key');
            $table->string('service_name');
            $table->date('slot_date');
            $table->string('slot_time', 20);
            $table->string('status')->default('reserved');
            $table->unique(['user_id', 'service_key', 'slot_date', 'slot_time']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
