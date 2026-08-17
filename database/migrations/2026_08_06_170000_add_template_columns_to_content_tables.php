<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Выбор шаблона вывода: у материалов — шаблон детальной страницы,
 * у категорий — шаблон страницы списка и вид карточек в нём.
 *
 * Значения — строки из App\Enums (ItemTemplate / ListTemplate / TeaserTemplate).
 */
return new class extends Migration
{
    /** Материалы: шаблон детальной страницы. */
    private const ITEM_TABLES = [
        'publs',        // «Полезное»
        'companies',    // «О нас»
        'travelitems',  // горящие туры
        'excursions',
        'resorts',
        'infos',
        'hotels',
        'pages',        // статические страницы
        'tours',
    ];

    /** Категории: шаблон списка + вид карточек. */
    private const CATEGORY_TABLES = [
        'dumps',
        'dump2s',
        'travelcategories',
    ];

    public function up(): void
    {
        foreach (self::ITEM_TABLES as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->string('template', 30)->default('default');
            });
        }

        foreach (self::CATEGORY_TABLES as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->string('list_template', 30)->default('default');
                $table->string('teaser_template', 30)->default('default');
            });
        }

        // hot_categories — одна таблица и для стран, и для курортов внутри них:
        // страна выводится как самостоятельная страница (template) и как список
        // вложенных материалов (list_template / teaser_template).
        Schema::table('hot_categories', function (Blueprint $table): void {
            $table->string('template', 30)->default('default');
            $table->string('list_template', 30)->default('default');
            $table->string('teaser_template', 30)->default('default');
        });

        // Переносим прежний переключатель «Шаблон с изображением» (temp)
        // в новое поле — иначе разделы потеряют выбранный вид карточек.
        foreach (['dumps', 'dump2s'] as $table) {
            if (Schema::hasColumn($table, 'temp')) {
                DB::table($table)->where('temp', 1)->update(['teaser_template' => 'img']);
            }
        }
    }

    public function down(): void
    {
        foreach (self::ITEM_TABLES as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn('template');
            });
        }

        foreach (self::CATEGORY_TABLES as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn(['list_template', 'teaser_template']);
            });
        }

        Schema::table('hot_categories', function (Blueprint $table): void {
            $table->dropColumn(['template', 'list_template', 'teaser_template']);
        });
    }
};
