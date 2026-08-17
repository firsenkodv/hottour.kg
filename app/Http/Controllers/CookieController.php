<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * всплывает подписка на горящие туры: все кроме user, кабинет, страница поиска туров find-tour
     */

    public function get_cookie(Request $request)
    {

        $error =  false;
        $result =  false;
        if($request->url == a_url(config('links.link.search'))) {
            $error = true;
        }
        if($request->url == a_url(config('links.link.search_new'))) {
            $error = true;
        }
        $str = parse_url($request->url, PHP_URL_PATH);
        $array  = explode('/', $str);
        $cabinet = array_search('cabinet', $array);
        if($cabinet) {
            $error = true;
        }
        $user = auth()->user();
        if($user) {
            $error = true;
        }

        $r  = request()->cookie('subscription_form2');
        if(!$r) {
            $result = true;

        }

        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'result' => $result,
            'error' => $error,
            'getcookie' => request()->cookie('subscription_form2'),
        ]);

    }

    public function set_cookie(Request $request)
    {
           $value = 'сутки (subscription_form2)';
           $minutes = 1440; // 1440 - сутки
           Cookie::queue('subscription_form2', $value, $minutes);
        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'setcookie' => 'method set_cookie()',
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * всплывает подписка на стрнаице поиск: страница поиска туров find-tour, кроме user,
     */

    public function get_cookie_findtour(Request $request)
    {

        $error =  false;
        $result =  false;
        if($request->url != a_url('find-tour')) {
            $error =  true;
        }

        $user = auth()->user();
        if($user) {
            $error = true;
        }

        $r  = request()->cookie('mini_form');
        if(!$r) {
            $result = true;

        }

        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'result' => $result,
            'error' => $error,
            'getcookie' => request()->cookie('mini_form'),
        ]);

    }

    public function set_cookie_findtour(Request $request)
    {
           $value = 'сутки (mini_form)';
           $minutes = 1440; // 1440 - сутки
           Cookie::queue('mini_form', $value, $minutes);
        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'setcookie' => 'method set_cookie_findtour()',
        ]);

    }


}
