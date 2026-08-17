<?php

namespace App\View\Composers;



use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CityComposer
{
    public function compose(View $view): void
    {
        // получить данные из сессии:
        $session_sity = session('sity');

        $view->with([
            'session_sity' => $session_sity,
        ]);

    }

}
