<?php

namespace App\View\Composers;



use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class UserRoleComposer
{
    public function compose(View $view): void
    {
        $user = auth()->user();

        $view->with([
            'user' => $user,
        ]);

    }

}
