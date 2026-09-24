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
        Schema::table('donations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        Schema::table('association_events', function (Blueprint $table) {
            $table->string('category')->default('collecte')->after('title');
            $table->unsignedInteger('capacity')->default(5)->after('starts_at');
            $table->string('event_type')->default('one_time')->after('capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('association_events', function (Blueprint $table) {
            $table->dropColumn(['category', 'capacity', 'event_type']);
        });
    }
};
