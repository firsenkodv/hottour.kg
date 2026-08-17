<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date_departure')->nullable();
            $table->date('date_arrival')->nullable();
            $table->unsignedInteger('days_count')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->unsignedBigInteger('tour_price')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
