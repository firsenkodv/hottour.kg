<?php

namespace App\View\Composers;



use App\Models\CustomJsScript;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CustomJsScriprComposer
{
    public function compose(View $view): void
    {
        $jss = CustomJsScript::query()->where('published', 1)
            ->orderBy('sorting')
            ->get();

        $view->with([
            'jss' => $jss,
        ]);

    }

}
