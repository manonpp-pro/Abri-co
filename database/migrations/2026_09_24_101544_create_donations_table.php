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
        // Les deux types de don partagent une table, car leur suivi et leur confirmation sont identiques.
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_type');
            $table->string('donation_type');
            $table->string('name');
            $table->string('email');
            $table->string('organization')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
