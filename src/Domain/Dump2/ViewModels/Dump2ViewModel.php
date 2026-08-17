<?php
namespace Domain\Dump2\ViewModels;
use App\Models\Dump2;
use App\Models\Setting;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class Dump2ViewModel
{
    use Makeable;
    use MemoryCache;

    /**
     * Содержимое заглавной страницы раздела «О нас»: заголовок, описание
     * и метатеги. Своей модели у этой страницы нет — данные лежат в settings,
     * редактируются страницей «О нас» в админке (App\MoonShine\Pages\AboutPage).
     */
    public function getPageData(): Fluent
    {
        return $this->cache(fn () => new Fluent(Setting::getGroup('about')->data ?? []));
    }

    public function listDump2s()
    {
        return $this->cache(function () {

            return Dump2::query()
                ->get_dump2s()
                ->get();
        });

    }

    public function OneDump2($slug)
    {
        $one_dump2 = $this->listDump2s()->firstWhere('slug', $slug);
        return $one_dump2;
    }

    public function OneDump2ForId($id)
    {
        $one_dump2 = $this->listDump2s()->firstWhere('id', $id);
        return $one_dump2;
    }


}


