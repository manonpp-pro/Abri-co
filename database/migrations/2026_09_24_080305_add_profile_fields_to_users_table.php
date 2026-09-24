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
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_type')->default('beneficiary')->after('name');
            $table->string('first_name')->nullable()->after('account_type');
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('school')->nullable();
            $table->string('organization')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('manager_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'account_type',
                'first_name',
                'phone',
                'gender',
                'birth_date',
                'city',
                'postal_code',
                'school',
                'organization',
                'registration_number',
                'website',
                'address',
                'manager_name',
            ]);
        });
    }
};
