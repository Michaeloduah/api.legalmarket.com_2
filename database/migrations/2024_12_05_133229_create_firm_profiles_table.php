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
        Schema::create('firm_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_uuid')->unique();
            $table->string('firm_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('registration_date')->nullable();
            $table->string('expiration_date')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('office_address')->nullable();
            $table->string('practice_areas')->nullable();
            $table->string('employees')->nullable();
            $table->string('firm_size')->nullable();
            $table->string('status')->default('Pending');
            $table->string('availability')->nullable();
            $table->string('established_year')->nullable();
            $table->string('bar_association')->nullable();
            $table->string('professional_bio')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firm_profiles');
    }
};