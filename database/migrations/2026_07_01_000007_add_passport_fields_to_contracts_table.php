<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('passport')->nullable();
            $table->string('passport_issued_at')->nullable();
            $table->string('passport_issued_by')->nullable();
            $table->string('inn')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['passport', 'passport_issued_at', 'passport_issued_by', 'inn']);
        });
    }
};
