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
        // Поля Обьекта внедрения
        Schema::create('web__forms', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('short_name');
            $table->string('locality');
            $table->string('municipal_district')->nullable();
            $table->string('region');
            $table->string('inn');
            $table->string('ogrn');
            $table->string('email');
            $table->string('phone');
            
        
            // Поля представителей
            for ($i = 1; $i <= 10; $i++) {
                $table->string("representative_{$i}_accord")->nullable();
                $table->string("representative_{$i}_name")->nullable();
                $table->string("representative_{$i}_position")->nullable();
                $table->string("representative_{$i}_phone")->nullable();
                $table->string("representative_{$i}_snils")->nullable();
                $table->string("representative_{$i}_email")->nullable();
    }

    $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web__forms');
    }
};