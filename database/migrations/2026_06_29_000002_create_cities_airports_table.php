<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities_airports', function (Blueprint $table) {
            $table->id();
            $table->string('city_ru');
            $table->string('city_en');
            $table->string('country_ru');
            $table->char('country_code', 2)->index();
            $table->unsignedBigInteger('population')->default(0);
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities_airports');
    }
};
