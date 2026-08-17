<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Механизм SEO-записей убран: метатеги задаются у самих материалов,
 * а у страниц без своей модели — через settings (страницы MoonShine).
 *
 * Единственная запись таблицы (/strany) перенесена в группу `countries`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('seos');
    }

    /**
     * Возвращает структуру, но не содержимое — данные перенесены в settings.
     */
    public function down(): void
    {
        Schema::create('seos', function (Blueprint $table): void {
            $table->id();
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->string('metatitle')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('params')->nullable();
            $table->text('seotext')->nullable();
            $table->integer('sorting')->default(999);
            $table->timestamps();
        });
    }
};
