<?php

namespace App\View\Composers;



use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FilterManagersComposer
{
    public function compose(View $view): void
    {
        $managers = User::query()->where('user_role_id', 1) // 1 это менеджеры
        ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc') // я гений
            ->get();

        $view->with([
            'managers' => $managers,
        ]);

    }

}
