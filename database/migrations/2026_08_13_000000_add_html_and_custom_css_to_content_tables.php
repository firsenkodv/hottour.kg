<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Поля страницы, редактируемые в админке:
 *  - html       — произвольный HTML-блок в контенте записи (мимо TinyMCE),
 *  - custom_css — CSS только для этой страницы, выводится в <style> в <head>.
 *
 * Оба поля необязательные, поэтому просто nullable text — без отдельной
 * таблицы и полиморфных связей.
 */
return new class extends Migration
{
    /** Таблицы моделей, у которых есть своя страница на сайте и метатеги в админке. */
    private array $tables = [
        'companies',
        'dumps',
        'dump2s',
        'excursions',
        'hot_categories',
        'hotels',
        'infos',
        'pages',
        'publs',
        'resorts',
        'rooms',
        'tours',
        'travelcategories',
        'travelitems',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table): void {
                if (! Schema::hasColumn($table, 'html')) {
                    $blueprint->text('html')->nullable();
                }

                if (! Schema::hasColumn($table, 'custom_css')) {
                    $blueprint->text('custom_css')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table): void {
                if (Schema::hasColumn($table, 'html')) {
                    $blueprint->dropColumn('html');
                }

                if (Schema::hasColumn($table, 'custom_css')) {
                    $blueprint->dropColumn('custom_css');
                }
            });
        }
    }
};
