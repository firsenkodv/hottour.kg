<?php

namespace Domain\Menu\ViewModels;

use App\Models\HotCategory;
use App\Models\Menudump;
use App\Models\Menudump2;
use App\Models\Menuhottour;
use App\Models\Menutour;
use Illuminate\Support\Facades\Storage;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class MenuViewModel
{
    use Makeable;
    use MemoryCache;

    /** Страны */
    public function top_menu()
    {
        return $this->cache(function () {
            $menu = \App\Models\Menu::query()
                ->where('published', true)
                ->with(['parent' => function ($q) {
                    return $q->where('published', true);
                }])
                ->take(100)
                ->orderBy('sorting')
                ->get();

            $tm = [];
            foreach ($menu as $m) {
                if (!is_null($m->parent)) {

                    $tm[$m->id]['id'] = $m->id;
                    $tm[$m->id]['hot_category_id'] = (isset($m->parent)) ? $m->parent->id : '';
                    $tm[$m->id]['title'] = $m->title;
                    $tm[$m->id]['slug'] = (isset($m->parent)) ? $m->parent->slug : '#';
                    $tm[$m->id]['imgflag'] = (isset($m->parent)) ? $m->parent->imgflag : '';
                }
            }
            $top_menu = array_slice($tm, 0, 10);
            $top_menu__left = collect(array_slice($top_menu, 0, 5)); // от 0 до 10
            $top_menu__right = collect(array_slice($top_menu, 5, 10)); // от 0 до 10

            $array['top_menu'] = $top_menu;
            $array['top_menu__left'] = $top_menu__left;
            $array['top_menu__right'] = $top_menu__right;
            return $array;
        });
    }

    /** Горящие туры (выпадающее - По странам, Из Алматы, Из Астаны) */
    public function top_menutravelcategories()
    {
        return $this->cache(function () {
            $menu = Menuhottour::query()
                ->where('published', true)
                ->with(['parent' => function ($q) {
                    return $q->where('published', true);
                }])
                ->take(100)
                ->orderBy('sorting')
                ->get();

            $tm = [];
            foreach ($menu as $m) {
                if (!is_null($m->parent)) {

                    $tm[$m->id]['id'] = $m->id;
                    $tm[$m->id]['tour_id'] = (isset($m->parent)) ? $m->parent->id : '';
                    $tm[$m->id]['title'] = $m->title;
                    $tm[$m->id]['slug'] = (isset($m->parent)) ? $m->parent->slug : '#';
                }
            }
            return array_slice($tm, 0, 100);
        });
    }

    /** Туры (выпадающее - материалы) */
    public function top_menutours()
    {
        return $this->cache(function () {
            $menu = Menutour::query()
                ->where('published', true)
                ->with(['parent' => function ($q) {
                    return $q->where('published', true);
                }])
                ->take(100)
                ->orderBy('sorting')
                ->get();

            $tm = [];
            foreach ($menu as $m) {
                if (!is_null($m->parent)) {

                    $tm[$m->id]['id'] = $m->id;
                    $tm[$m->id]['tour_id'] = (isset($m->parent)) ? $m->parent->id : '';
                    $tm[$m->id]['title'] = $m->title;
                    $tm[$m->id]['slug'] = (isset($m->parent)) ? $m->parent->slug : '#';
                }
            }
            return array_slice($tm, 0, 20);
        });
    }

    /** Полезное (выпадающее - раздел с категориями) */
    public function top_menudumps()
    {
        return $this->cache(function () {
            $menu = Menudump::query()
                ->where('published', true)
                ->with(['parent' => function ($q) {
                    return $q->where('published', true);
                }])
                ->take(100)
                ->orderBy('sorting')
                ->get();

            $tm = [];
            foreach ($menu as $m) {
                if (!is_null($m->parent)) {

                    $tm[$m->id]['id'] = $m->id;
                    $tm[$m->id]['tour_id'] = (isset($m->parent)) ? $m->parent->id : '';
                    $tm[$m->id]['title'] = $m->title;
                    $tm[$m->id]['slug'] = (isset($m->parent)) ? $m->parent->slug : '#';
                }
            }
            return array_slice($tm, 0, 100);
        });
    }

    /** О нас (выпадающее - раздел с категориями) */
    public function top_menudump2s()
    {
        return $this->cache(function () {
            $menu_dump2 = Menudump2::query()
                ->where('published', true)
                ->with(['parent' => function ($q) {
                    return $q->where('published', true);
                }])
                ->take(100)
                ->orderBy('sorting')
                ->get();

            $tm = [];
            foreach ($menu_dump2 as $m) {
                if (!is_null($m->parent)) {

                    $tm[$m->id]['id'] = $m->id;
                    $tm[$m->id]['tour_id'] = (isset($m->parent)) ? $m->parent->id : '';
                    $tm[$m->id]['title'] = $m->title;
                    $tm[$m->id]['slug'] = (isset($m->parent)) ? $m->parent->slug : '#';
                }
            }

            return array_slice($tm, 0, 100);
        });
    }


    public function country_menu()
    {
        return $this->cache(function () {
            return HotCategory::query()
                ->where('published', true)
                ->where('hot_category_id', null)
                ->with(['child' => function($q) {
                    $q->orderBy('sorting');
                }])
                ->take(170)
                ->orderBy('sorting')
                ->get();
        });

    }

    public function activeLink($this_route, $route = null)
    {

        if(!$route) {
            return '';
        }
        if(trim($this_route) == trim($route)) {
            return 'active';
        }
        return '';
    }

    public function render_mobile_menu($route = null):string
    {

        $top_menu = $this->top_menu();
        $top_menutravelcategories = $this->top_menutravelcategories();
        $top_menutours = $this->top_menutours();
        $top_menudumps = $this->top_menudumps();
        $top_menudump2s = $this->top_menudump2s();

        settype($m1, "string");


        $m1 = '<div class="__li '. $this->activeLink('home', $route ).'" data-route-name="home"><a href="/">Главная</a></div>';
        $m1 .= '<div class="__li '. $this->activeLink('search_tours', $route ).'" data-route-name="search_tours"><a href="'. route('search_tours') .'">Поиск тура</a></div>';


        if (isset($top_menu['top_menu__left'])) {
            $m1 .= '<div class="__li m_click__js '. $this->activeLink('countries', $route ). $this->activeLink('country', $route ).'" data-route-name="countries"><span class="aa">Страны</span> <span class="parent__st_after mactive"></span></div>';

            $m1 .= '<div class="__toggle m_down__js display_none">';
            foreach ($top_menu['top_menu__left'] as $item) {
                $m1 .= '<div class="__li isset_flag" data-route-name=""><img src="' . Storage::url($item['imgflag']) . '" width="28" height="18" alt="' . $item['title'] . '"><a href="' . route('country', ['slug' => $item['slug']]) . '">' . $item['title'] . '</a></div>';
            }
            foreach ($top_menu['top_menu__right'] as $item) {
                $m1 .= '<div class="__li isset_flag" data-route-name=""><img src="' . Storage::url($item['imgflag']) . '" width="28" height="18" alt="' . $item['title'] . '"><a href="' . route('country', ['slug' => $item['slug']]) . '">' . $item['title'] . '</a></div>';
            }
            $m1 .= '<div class="__li __li_red"><a href="'. route('countries')  .'">Смотреть все страны</a></div>';
            $m1 .= '</div>';
        }
        if(isset($top_menutravelcategories))

        $m1 .= '<div class="__li m_click__js '. $this->activeLink('hottour_category', $route ).'" data-route-name="hottour_category"><span class="aa">Горящие туры<span> <span class="parent__st_after mactive"></span></div>';
        $m1 .= '<div class="__toggle m_down__js display_none">';

        foreach ($top_menutravelcategories as $item) {
            $m1 .= '<div class="__li __li_chid" data-route-name=""><a href="' . route('hottour_category', ['slug_category' => $item['slug']]) . '">' . $item['title'] . '</a></div>';
        }
        $m1 .= '</div>';



        if(isset($top_menutours))

        $m1 .= '<div class="__li m_click__js '. $this->activeLink('tour', $route ).'" data-route-name="tour"><span class="aa">Туры<span> <span class="parent__st_after mactive"></span></div>';
        $m1 .= '<div class="__toggle m_down__js display_none">';

        foreach ($top_menutours as $item) {
            $m1 .= '<div class="__li __li_chid" data-route-name=""><a href="' . route('tour', ['slug' => $item['slug']]) . '">' . $item['title'] . '</a></div>';
        }
        $m1 .= '</div>';

        $m1 .= '<div class="__li '. $this->activeLink('page', $route ).'"><a href="/cruises">Круизы</a></div>';

        $m1 .= '<div class="__li '. $this->activeLink('certificates', $route ).'" data-route-name="certificates"><a href="'. route('certificates') .'">Сертификаты</a></div>';



        if(isset($top_menudumps))

            $m1 .= '<div class="__li m_click__js '. $this->activeLink('dump', $route ).'" data-route-name="dump"><span class="aa">Полезное<span> <span class="parent__st_after mactive"></span></div>';
        $m1 .= '<div class="__toggle m_down__js display_none">';

        foreach ($top_menudumps as $item) {
            $m1 .= '<div class="__li __li_chid" data-route-name=""><a href="' . route('dump', ['slug' => $item['slug']]) . '">' . $item['title'] . '</a></div>';
        }
        $m1 .= '</div>';


        if(isset($top_menudump2s))

            $m1 .= '<div class="__li m_click__js '. $this->activeLink('dump2', $route ).'" data-route-name="dump2"><span class="aa">О нас<span> <span class="parent__st_after mactive"></span></div>';
        $m1 .= '<div class="__toggle m_down__js display_none">';

        foreach ($top_menudump2s as $item) {
            $m1 .= '<div class="__li __li_chid" data-route-name=""><a href="' . route('dump2', ['slug' => $item['slug']]) . '">' . $item['title'] . '</a></div>';
        }
        $m1 .= '</div>';
        $m1 .= '<div class="__li '. $this->activeLink('contacts', $route ).'" data-route-name="contacts"><a href="'. route('contacts')  .'">Контакты</a></div>';


        return $m1;


    }

}
