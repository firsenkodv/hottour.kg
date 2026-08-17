<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

/*
|--------------------------------------------------------------------------
| Хлебные крошки
|--------------------------------------------------------------------------
|
| Каждая цепочка привязана к имени маршрута, поэтому в шаблонах достаточно
| Breadcrumbs::render(Route::currentRouteName(), ...аргументы).
| Вёрстка вывода — resources/views/partials/breadcrumbs.blade.php.
|
*/

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

/** Страны **/

Breadcrumbs::for('countries', function ($trail) {
    $trail->parent('home');
    $trail->push('Страны', route('countries'));
});

Breadcrumbs::for('country', function ($trail, $country) {
    $trail->parent('countries');
    $trail->push($country->title, route('country', $country->slug));
});

Breadcrumbs::for('country_category', function ($trail, $country, $hot_category) {
    $trail->parent('country', $country);
    $trail->push($hot_category->title, route('country_category', [$country->slug, $hot_category->slug]));
});

Breadcrumbs::for('country_item', function ($trail, $country, $hot_category, $item) {
    $trail->parent('country_category', $country, $hot_category);
    $trail->push($item->title, route('country_item', [$country->slug, $hot_category->slug, $item->slug]));
});

/** Туры **/

Breadcrumbs::for('tour', function ($trail, $item) {
    $trail->parent('countries');
    $trail->push($item->title, route('tour', $item->slug));
});

/** Горящие туры **/

Breadcrumbs::for('hottour_category', function ($trail, $category) {
    $trail->parent('home');
    // страницы со списком всех категорий горящих туров нет,
    // поэтому раздел идёт звеном без ссылки
    $trail->push('Горящие туры');
    $trail->push($category->title, route('hottour_category', $category->slug));
});

Breadcrumbs::for('hottour_item', function ($trail, $category, $item) {
    $trail->parent('hottour_category', $category);
    $trail->push($item->title, route('hottour_item', [$category->slug, $item->slug]));
});

/** Полезное **/

Breadcrumbs::for('dump', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->title, route('dump', $category->slug));
});

Breadcrumbs::for('dump_item', function ($trail, $category, $item) {
    $trail->parent('dump', $category);
    $trail->push($item->title, route('dump_item', [$category->slug, $item->slug]));
});

/** О нас **/

Breadcrumbs::for('about', function ($trail) {
    $trail->parent('home');
    $trail->push('О нас', route('about'));
});

Breadcrumbs::for('dump2', function ($trail, $category) {
    $trail->parent('about');
    $trail->push($category->title, route('dump2', $category->slug));
});

Breadcrumbs::for('dump2_item', function ($trail, $category, $item) {
    $trail->parent('dump2', $category);
    $trail->push($item->title, route('dump2_item', [$category->slug, $item->slug]));
});

/** Отдельные страницы **/

Breadcrumbs::for('page', function ($trail, $item) {
    $trail->parent('home');
    $trail->push($item->title, route('page', $item->slug));
});

Breadcrumbs::for('certificates', function ($trail) {
    $trail->parent('home');
    $trail->push('Сертификаты', route('certificates'));
});

Breadcrumbs::for('contacts', function ($trail) {
    $trail->parent('home');
    $trail->push('Контакты', route('contacts'));
});

Breadcrumbs::for('bereke', function ($trail) {
    $trail->parent('home');
    $trail->push('Bereke', route('bereke'));
});
