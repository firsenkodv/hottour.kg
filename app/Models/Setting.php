<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Настройки страницы, у которой нет собственной модели.
 *
 * Одна запись — одна страница («группа»), всё её содержимое лежит
 * в json-колонке data. Редактируется страницей MoonShine
 * (см. App\MoonShine\Pages\Pages), читается на фронте через ViewModel.
 */
class Setting extends Model
{
    protected $fillable = ['group', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Группа всегда существует: при первом обращении создаём пустую,
     * чтобы страница в админке открывалась без предварительной настройки.
     */
    public static function getGroup(string $group): self
    {
        return static::firstOrCreate(['group' => $group], ['data' => []]);
    }

    public function getValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->data, $key, $default);
    }
}
