<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplacementFormRequest;
use App\Models\Company;
use App\Models\Dump;
use App\Models\Dump2;
use App\Models\Excursion;
use App\Models\HotCategory;
use App\Models\Info;
use App\Models\Menu;
use App\Models\Menudump;
use App\Models\Menudump2;
use App\Models\Menuhottour;
use App\Models\Menutour;
use App\Models\Page;
use App\Models\Replacement;
use App\Models\Resort;
use App\Models\Tour;
use App\Models\Travelcategory;
use App\Models\Travelitem;
use Symfony\Component\HttpFoundation\Response;

final class ReplacementController extends Controller
{
    public function __invoke(ReplacementFormRequest $request): Response
    {
        $old = $request->old_text;
        $new = $request->new_text;
        $fields = array('title', 'subtitle', 'smalltext', 'text', 'text2', 'text3', 'metatitle', 'keywords', 'description');
        $lenght = array();
        $models = array(Company::class, Replacement::class,Dump::class,Dump2::class,Excursion::class,HotCategory::class,Info::class,Menu::class,Menudump::class,Menudump2::class,Menuhottour::class,Menutour::class,Page::class,Resort::class,Tour::class,Travelcategory::class,Travelitem::class);

        foreach ($models as $model) {
            $get = $model::query()->get();
            foreach ($get as $item) {
                $i = array();
                foreach ($fields as $field) {

                    if (!is_null($item->$field)) {
                        if ($item->$field = str_replace($old, $new, $item->$field, $count)) {
                            if ($count) {
                                $i[] = $count;
                            }
                        }
                    }

                }

                if (count($i)) {
                    $lenght[$item->id] = $i;
                    $item->save();
                }


            }
        }

        $sum = 0;
        if(count($lenght)) {
            foreach ($lenght as $l) {
                $sum += array_sum($l);
            }
        }

        // v2: $this->toast() из MoonShineController. В v4 — глобальный хелпер toast().
        if ($sum) {
            toast("Произведено замен - $sum", 'success');
        } else {
            toast("Совпадений не найдено", 'error');
        }

        return back();
    }
}
