<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Тизер карточки отзыва (модель Company, категория «Отзывы»):
 * дата поездки, количество туристов и оценка — выводятся в блоке
 * отзывов x-modules.responses (макет docs/figma/about/desktop/7.png).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->date('trip_date')->nullable()->after('smalltext');
            $table->unsignedTinyInteger('adults')->nullable()->after('trip_date');
            $table->decimal('rating', 2, 1)->nullable()->after('adults');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['trip_date', 'adults', 'rating']);
        });
    }
};
