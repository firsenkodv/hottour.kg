<?php

namespace App\Http\Controllers\Auth;

use App\Crm\Api;
use App\Events\CreateUserEvent;
use App\Events\MessageAdminCreateUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use App\Models\User;
use App\Models\UserPromo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;


class SignUpController extends Controller
{

    public function page()
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request): RedirectResponse
    {


        if(auth()->check())
        {
            $u_id = auth()->user()->id;
        } else {
            $u_id = 0;
        }

        $b = config('vars.vars.b'); // сумма баллов
        $cashback = config('vars.vars.cashback'); // сумма кешбэка
        $promo = ($request->promo)?:''; // введенный промокод

        settype($isset_promocode, 'array');
        if ($promo)
        {
            $isset_promocode = UserPromo::query()->where('code', $promo)->first();
            if($isset_promocode) {
                $user_winning = User::query()->where('id', $isset_promocode->user_id)->first(); /** user который подарил промо **/

                if(is_null($user_winning->ball)) {
                    $user_winning->ball =  $b;
                } else {
                    $user_winning->ball  = $user_winning->ball + $b;
                }

                $user_winning->save();

                UserPromo::query()->where('code', $promo)->delete(); // удалим эту запись

            }
        }


        $user = User::query()->create([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,

            'user_role_id' => ($request->manager == 'manager')?1:null, /** 1 - это менеджер  */
            'user_id' => ($request->id)?:manager_reserve()->id, /** закрепляем за менеджером  */
            'senior_id' => ($request->senior == $u_id)?$request->senior:null, /** закрепляем в команду РОП  */

            'cashback' => ($isset_promocode)?$cashback:null,
            'password' => bcrypt($request->password),

            'inn' => $request->inn,
            'passport' => $request->passport,
            'passport_issued_at' => $request->passport_issued_at,
            'passport_issued_by' => $request->passport_issued_by,

        ]);


        $api = new Api();
        $api->SendNewRegigisterUserCRM($request); /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */

       // event(new Registered($user)); // события
        /**
         * Событие отправка сообщения новому пользователю
         */
        CreateUserEvent::dispatch($request);

        /**
         * Событие отправка сообщения админу
         */

       MessageAdminCreateUserEvent::dispatch($request);

        ////////////////////////
        if($request->redirect_for_route_page_users == 1) {

            if($request->manager == 'manager') {

                flash()->info(config('message_flash.info.manager_add')); // менеджер создан
                return redirect()->back();
            }

            flash()->info(config('message_flash.info.user_add')); // пользователь создан
            return redirect()->back();
        }
        ///////////////////////////

        auth()->login($user); // залогинили

        return redirect()->route('cabinet');

    }

    public function handleManager(SignUpFormRequest $request): RedirectResponse
    {

        $user = User::query()->create([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_id' => ($request->id)?:'',
            'password' => bcrypt($request->password)

        ]);

        // event(new Registered($user)); // события
        /**
         * Событие отправка сообщения новому пользователю
         */

        CreateUserEvent::dispatch($request);

        /**
         * Событие отправка сообщения админу
         */

        MessageAdminCreateUserEvent::dispatch($request);

        if($request->redirect_for_route_page_users == 1) {
            flash()->info(config('message_flash.info.user_add'));
            return redirect()->back();
        }
        auth()->login($user); // залогинили

        return redirect()->route('cabinet');

    }



}
