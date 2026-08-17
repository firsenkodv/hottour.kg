<?php

namespace App\Providers;



use App\Models\UserRole;
use App\View\Composers\ChangeContactComposer;
use App\View\Composers\CityComposer;
use App\View\Composers\CountryMainComposer;
use App\View\Composers\CountryMenuComposer;
use App\View\Composers\CustomJsScriprComposer;
use App\View\Composers\FilterManagersComposer;
use App\View\Composers\HotelSwiperComposer;
use App\View\Composers\HotToursSwiperComposer;
use App\View\Composers\OtzMainComposer;
use App\View\Composers\PageMainComposer;
use App\View\Composers\PublMainComposer;
use App\View\Composers\SettingComposer;
use App\View\Composers\SurveyResultComposer;
use App\View\Composers\SurveySearchComposer;
use App\View\Composers\SurveyUserComposer;
use App\View\Composers\TopmenuComposer;
use App\View\Composers\Topmenudump2sComposer;
use App\View\Composers\TopmenudumpsComposer;
use App\View\Composers\TopmenutoursComposer;
use App\View\Composers\TopmenutravelcategoriesComposer;
use App\View\Composers\UserRoleComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // $session_sity нужна только в этих двух шаблонах: селектор города
        // в шапке и подсветка города на странице контактов.
        View::composer(['include.selectsity.select_sity', 'pages.contacts'], CityComposer::class);
       // View::composer('include.module.index_text', PageMainComposer::class);
        View::composer('include.module.popular_country', CountryMainComposer::class);
        View::composer('include.module.index_news', PublMainComposer::class);
        // слайдер отзывов — компонент x-modules.responses (главная + лендинг «О нас»)
        View::composer('components.modules.responses', OtzMainComposer::class);
        View::composer(['include.menu.menu', 'html.mobile._partial.mobile_menu'], TopmenuComposer::class);
        View::composer(['include.menu.menu', 'html.mobile._partial.mobile_menu'], TopmenutravelcategoriesComposer::class);
        View::composer(['include.menu.menu', 'html.mobile._partial.mobile_menu','include.footer' ], TopmenutoursComposer::class);
        View::composer(['include.menu.menu', 'html.mobile._partial.mobile_menu', 'include.footer'], TopmenudumpsComposer::class);
        View::composer(['include.menu.menu', 'html.mobile._partial.mobile_menu', 'include.footer'], Topmenudump2sComposer::class);
        View::composer(['include.module.hottours'], HotToursSwiperComposer::class);
        View::composer(['include.module.popular'], HotelSwiperComposer::class);
        // список стран сайта: боковое меню и селект «Страна» в форме подбора тура
        View::composer(['include.menu.country_menu', 'html.temp_forms.pick_tour'], CountryMenuComposer::class);
        View::composer(['dashboard.forms.filter'], FilterManagersComposer::class);
        View::composer(['include.menu.cabinet_menu'], UserRoleComposer::class);
        View::composer(['include.module.survey'], SurveySearchComposer::class);
        View::composer(['dashboard.left_bar.left'], SurveyUserComposer::class);
        View::composer(['dashboard.survey.survey'], SurveyResultComposer::class);
        View::composer(['include.custom_js.custom_js'], CustomJsScriprComposer::class);
        View::composer('*', SettingComposer::class);
        View::composer('include.connect._change_contacts', ChangeContactComposer::class);

    }
}
