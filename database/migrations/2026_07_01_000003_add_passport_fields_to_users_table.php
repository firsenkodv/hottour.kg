<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('inn')->nullable();
            $table->string('passport')->nullable();
            $table->string('passport_issued_at')->nullable();
            $table->string('passport_issued_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['inn', 'passport', 'passport_issued_at', 'passport_issued_by']);
        });
    }
};
