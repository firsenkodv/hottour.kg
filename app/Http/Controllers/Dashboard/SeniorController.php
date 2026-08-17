<?php

namespace App\Http\Controllers\Dashboard;

use App\Crm\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddImportantRequest;
use App\Http\Requests\AddCertivicateRequest;
use App\Http\Requests\UpdateAdminUserFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Requests\UpdatePasswordFormRequest;
use App\Http\Requests\UserSearchRequest;
use App\Models\User;

use App\Models\UserCertificate;
use App\Models\UserConnection;
use App\Models\UserImportant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeniorController extends Controller
{
    /**
     * Метод вывода всех менеджеров
     */

    public  function senior_Managers() {

        $user = auth()->user();
        if($user->senior) {
            $managers = User::query()
                ->where('senior_id', $user->id)
                ->with('users')
                ->withCount('users')
                ->orderBy('users_count', 'desc') // я гений  //
                ->get();


            return view('dashboard.zone_senior.managers',
                [
                    'user' => $user,
                    'managers' => $managers,

                ]);
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return back();
    }

    /**
     * Метод вывода одного менеджера
     */
    public  function senior_Manager($id)
    {

        $user = auth()->user();
        if ($user->senior) {
            $managers = User::query()
                ->where('senior_id', $user->id)
                ->with('users')
                ->withCount('users')
                ->orderBy('users_count', 'desc') // я гений  //
                ->get();


            $item = User::find($id);
            $subusers = User::query()->where('user_id', $id)->paginate(20);



            return view('dashboard.zone_senior.manager',
                [
                    'user' => $user,
                    'managers' => $managers,
                    'item' => $item,
                    'subusers' => $subusers,

                ]);
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return back();
    }





    public function subuserSearch(UserSearchRequest $request) {
        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         * для менеджера с id  $request->id
         */

        //  dd($request->id);
        $user = auth()->user();
        $item = User::query()->where('id', $request->id)->first();
        $subusers_all = User::query()->where('user_id', $request->id)->paginate(20);
        $s = $request->search;
        $subusers = User::where("user_id", $request->id)
            ->where(function ($query) use ($s) {
                $query->where("name", "like", "%" . $s . "%");
                $query->orWhere("email", "like", "%" . $s . "%");
            })
            ->paginate(20);


        $managers = User::query()->where('user_role_id', 1) // 1 это менеджеры
        ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();


        return view('dashboard.zone_senior.manager',
            [
                'user' => $user,
                'managers' => $managers,
                'item' => $item,
                'subusers' => $subusers,

            ]);

    }




    /**
     * Метод страница добавленния менеджера в свою команду
     */
    public  function senior_addManager()
    {

        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();

        return view('dashboard.zone_senior.manager_add',
            [
                'user' => $user,
            ]);
    }


}
