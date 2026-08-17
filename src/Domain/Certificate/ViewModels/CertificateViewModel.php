<?php

namespace Domain\Certificate\ViewModels;

use App\Models\Setting;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class CertificateViewModel
{
    use Makeable;
    use MemoryCache;

    /**
     * Содержимое страницы «Сертификаты»: заголовок, описание и метатеги.
     * Своей модели у страницы нет — данные лежат группой `certificates`
     * в таблице settings, редактируются в админке
     * (App\MoonShine\Pages\CertificatesPage).
     */
    public function getPageData(): Fluent
    {
        return $this->cache(fn () => new Fluent(Setting::getGroup('certificates')->data ?? []));
    }
}
