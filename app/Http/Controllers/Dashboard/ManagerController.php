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
use Domain\Payment\ViewModels\PaymentViewModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManagerController extends Controller
{

    /** **
     * Списко пользователей закрепленных за менеджером
     */
    public function manager_Users()
    {

        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $user = auth()->user();
        $users = User::query()
            ->where('user_id', $user->id)
            ->paginate(20);

        return view('dashboard.zone_manager.users',
            [
                'user' => $user,
                'users' => $users,
            ]);


    }

    /** **
     * Поиск  пользователей закрепленных за менеджером
     */
    public function manager_UsersSearch(UserSearchRequest $request)
    {

        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         * для менеджера с id  $request->id
         */

        //  dd($request->id);

        $user = auth()->user();
        if($request->id == $user->id) { /** Провекрка  */


            $search = $request->search;
            $users = User::where("user_id", $request->id)
                ->where(function ($query) use ($search) {
                    $query->where("name", "like", "%" . $search . "%");
                    $query->orWhere("email", "like", "%" . $search . "%");
                })
                ->paginate(20);


            return view('dashboard.zone_manager.users',
                [
                    'user' => $user,
                    'users' => $users,
                    'search' => $search,
                ]);


        } // if $request->id == $user->id

        return redirect()->back();

    }

    /** **
     * Пользователь закрепленный за менеджером
     */
    public function manager_UsersPageUser($id)
    {
        /**
         * Вход в editor для manager
         * проверка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = User::query()->where('id', $id)->first();
 /*        dump(role($item->id));
           dd($id);*/
        if (role($user->id) == 'manager') {
            /** если это менеджер, то ему нельзя смотреть других менеджеров и admin - ов **/

            if (role($item->id) != 'user') {
                flash()->alert(config('message_flash.alert.user_role'));
                return redirect()->back();
            }
       }
        if (role($user->id) == 'senior') {

            if (role($item->id) == 'admin') {
                flash()->alert(config('message_flash.alert.user_role'));
                return redirect()->back();
            }

        }
            /** это РОП ему можно смотреть **/


        session(['user' => $item->id]); // запустим сессию для изменения пароля нужного пользователя

        return view('dashboard.zone_manager.user',
            [
                'user' => $user,
                'item' => $item,
            ]);

    }

    /** **
     * Пользователь закрепленный за менеджером-это его платежи
     */
    public function manager_UsersPagePayment($id)
    {
        $user = auth()->user();
        $item = User::query()->where('id', $id)->first();
        if(!$item) {
            abort(404);
        }
        $payments = PaymentViewModel::make()->userPayments($item->id, true);


        return view('dashboard.zone_manager.payment',
            [
                'user' => $user,
                'item' => $item,
                'payments' => $payments,

            ]);

    }


    /** **
     * Страница создания пользователя
     */
    public function manager_UsersAddUser()
    {
        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();

        return view('dashboard.zone_manager.user_add',
            [
                'user' => $user,
            ]);


    }

    /** **
     * Страница сертификата пользователя
     */
    public function manager_UsersCertificaresUser($id)
    {


        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $user = auth()->user();
        $q = false;
        if (role($user->id) == "manager" or role($user->id) == "senior") {

            /**
             * Проверим, закреплен ли пользователь?
             */
            $u = User::find($id);
            if ($u->user_id == $user->id) {
                $q = true; // закреплен. редактировать можно
            }

            $his_manager_id = $u->user_id;
            $his_manager = User::find($his_manager_id);
            if(isset($his_manager->senior_id)) {
                if ($his_manager->senior_id == $user->id) {
                    /** это РОП, редактирует пользователя, который принадлежит менеджеру его команды */
                    $q = true; // редактировать можно

                }
            }


        }
        if($q) {
            $item = User::find($id);
            $certificates = UserCertificate::query()->where('user_id', $id)->orderBy('date', 'asc')->get();

            return view('dashboard.zone_manager.user_certificate',
                [
                    'item' => $item,
                    'user' => $user,
                    'certificates' => $certificates
                ]);
        }

        flash()->alert(config('message_flash.alert.certificate_error'));
        return back();


    }

    /** **
     * Страница туров  пользователя
     */
    public function manager_UsersToursUser($id)
    {


        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $user = auth()->user();
        $q = false;

        $u = User::find($id);
        if ($u->user_id == $user->id) {
            $q = true; // закреплен. редактировать можно
        }

        $his_manager_id = $u->user_id;
        $his_manager = User::find($his_manager_id);
        if(isset($his_manager->senior_id)) {
            if ($his_manager->senior_id == $user->id) {
                /** это РОП, редактирует пользователя, который принадлежит менеджеру его команды */
                $q = true; // редактировать можно

            }
        }

        if($q) {
            $item = User::query()->where('id', $id)->first();

            $crm = new Api();
            $tours = [];

            $tours = $crm->CRM($item->email);

            return view('dashboard.zone_manager.user_tours',
                [
                    'user' => $user,
                    'item' => $item,
                    'tours' => $tours,
                ]);
        }
        flash()->alert(config('message_flash.alert.tours_error'));
        return back();


    }



    /** **
     * Страница добавления сертификата РОП-ом в роль менеджера
     */
    public function manager_UsersCertificaresUserAdd($id)
    {
        /**
         * Вход в editor для manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();
        $item = User::find($id);


        return view('dashboard.zone_manager.user_certificateadd',
            [
                'user' => $user,
                'item' => $item,

            ]);


    }

    /** **
     * Страница редактирования сертификата РОП-ом в роль менеджера
     */
    public function manager_UsersCertificaresUserUpdate($id, $certificate_id)
    {


        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $user = auth()->user();
        $item = User::find($id);
        $certificate = UserCertificate::query()->where('id', $certificate_id)->first();
        $users = User::query()->get();

        return view('dashboard.zone_manager.user_certificateupdate',            [
                'user' => $user,
                'users' => $users,
                'item' => $item,
                'certificate' => $certificate,
            ]);



    }






}
