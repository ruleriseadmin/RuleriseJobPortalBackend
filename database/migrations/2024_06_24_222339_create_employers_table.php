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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('company_name');
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('industry')->nullable();
            $table->string('number_of_employees')->nullable();
            $table->string('founded_at')->nullable();
            $table->string('state_city')->nullable();
            $table->string('address')->nullable();
            $table->text('profile_summary')->nullable();
            $table->json('benefit_offered')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
