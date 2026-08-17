<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_room_id')->nullable()->after('hotel_custom');
            $table->unsignedBigInteger('contract_food_id')->nullable()->after('contract_room_id');
            $table->json('people')->nullable()->after('contract_food_id');
            $table->enum('transfer', ['yes', 'no'])->nullable()->after('people');
            $table->enum('excursion_program', ['yes', 'no'])->nullable()->after('transfer');
            $table->enum('russian_speaking_guide', ['yes', 'no'])->nullable()->after('excursion_program');
            $table->enum('visa_support', ['yes', 'no'])->nullable()->after('russian_speaking_guide');
            $table->enum('medical_support', ['yes', 'no'])->nullable()->after('visa_support');

            $table->foreign('contract_room_id')->references('id')->on('contract_rooms')->onDelete('set null');
            $table->foreign('contract_food_id')->references('id')->on('contract_foods')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['contract_room_id']);
            $table->dropForeign(['contract_food_id']);

            $table->dropColumn([
                'contract_room_id',
                'contract_food_id',
                'people',
                'transfer',
                'excursion_program',
                'russian_speaking_guide',
                'visa_support',
                'medical_support',
            ]);
        });
    }
};
