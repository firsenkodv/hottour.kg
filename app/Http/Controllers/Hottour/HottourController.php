<?php

namespace App\Http\Controllers\Hottour;


use Domain\Travelcategory\ViewModels\TravelcategoryViewModel;
use Domain\Travelitem\ViewModels\TravelitemViewModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HottourController extends Controller
{



    public function category($slug_category)
    {



        /**
         * Страница вывода материалов определенной категории (горящие туры - из алмааты (список)))
         **/
        $category = TravelcategoryViewModel::make()->OneTravelcategory($slug_category); // категория

        // без проверки несуществующий слаг давал 500 («Attempt to read
        // property travelitems on null») вместо честной 404
        abort_if($category === null, 404);

        $items =  (count($category->travelitems))?$category->travelitems()->orderBy('sorting', 'DESC')->paginate(20):[];

        return view('pages.hottours.category', [
            'category' => $category,
            'items' => $items,
            'template' => $category->listTemplate(),
            'teaser_template' => $category->teaserTemplate(),
        ]);

    }

    public function item($slug_category, $slug_item)
    {
        /**
         * Страница вывода материала  определенной категории
         **/
        $category = TravelcategoryViewModel::make()->OneTravelcategory($slug_category); // категория
        abort_if($category === null, 404);

        $items =  (count($category->travelitems))?$category->travelitems()->orderBy('sorting', 'DESC')->paginate(20):[];
        $item = TravelitemViewModel::make()->OneTravelitem($slug_item); // материал
        abort_if($item === null, 404);


        return view('pages.hottours.item', [
            'category' => $category,
            'items' => $items,
            'item' => $item,
            'template' => $item->itemTemplate(),
        ]);

    }



}
