<?php

namespace App\Http\Controllers\Dashboard;

use App\Crm\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddImportantRequest;
use App\Http\Requests\AddCertivicateRequest;
use App\Http\Requests\UpdateAdminUserFormRequest;
use App\Http\Requests\UpdateBallRequest;
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

class AdminController extends Controller
{

    /**
     * Метод входа в лк, для создания "важного"
     */
    public function pageImportant()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();


        return view('dashboard.zone_admin_important',
            [
                'user' => $user,
            ]);

    }

    public function pageEdit()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        return redirect(route('page.important'));

    }

    /**
     * Метод входа в лк, для создания "важного"
     */
    public function pageUpdateImportant($id)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = UserImportant::query()->where('id', $id)->first();


        return view('dashboard.zone_admin_importantupdate',
            [
                'user' => $user,
                'item' => $item,
            ]);

    }

    /**
     * Метод добавки материала "Важное"
     */
    public function addImportant(AddImportantRequest $request)
    {

        /**
         * Вход  для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $slug = createSlug($request->title, UserImportant::class); //  по факту не исполоьзуется!!!

        $user_importants = UserImportant::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'subtitle' => ($request->subtitle) ?: '',
                'text' => ($request->text) ?: '',
                'short_desc' => ($request->short_desc) ?: '',
                'slug' => $slug,
            ]);

        flash()->info(config('message_flash.info.important_add'));

        return redirect()->intended(route('page.important')); // intended - назад или route


    }


    /**
     * Метод обновления материала "Важное"
     */
    public function updateImportant(AddImportantRequest $request)
    {

        /**
         * Вход  для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user_importants = UserImportant::query()
            ->where('id', $request->id)
            ->update([
                'title' => $request->title,
                'subtitle' => ($request->subtitle) ?: '',
                'text' => ($request->text) ?: '',
                'short_desc' => ($request->short_desc) ?: '',
            ]);

        flash()->info(config('message_flash.info.important_update'));

        return redirect()->intended(route('important')); // intended - назад или route


    }


    /**
     * Метод удаления статьи
     */
    public function delImportant(Request $request)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        /**
         * Удаляем опрос
         */
        if (role(auth()->user()->id) == 'admin') {

            UserImportant::destroy($request->id);

            flash()->info(config('message_flash.info.important_del'));

            if ($request->redirect) {
                return redirect($request->redirect);
            }

            return redirect()->intended(route('important')); // intended - назад или route
        }
        flash()->alert(__('У вас не достаточно прав для удаления'));
        return back();


    }

    /**
     * Метод входа в лк, для создания "сертификата"
     */
    public function pageCertificate()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $users = User::query()->get();

        return view('dashboard.zone_admin_certificate',
            [
                'user' => $user,
                'users' => $users,
            ]);

    }

    /**
     * Метод входа в лк, для создания "сертификата"
     */
    public function pageUpdateCertificate($id)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = UserCertificate::query()->where('id', $id)->first();
        $users = User::query()->get();

        return view('dashboard.zone_admin_certificateupdate',
            [
                'user' => $user,
                'users' => $users,
                'item' => $item,
            ]);

    }

    /**
     * Метод добавки материала "сертификата"
     */
    public function addCertificate(AddCertivicateRequest $request)
    {

        /**
         * Вход  для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        if ($request->user == 0) {
            flash()->alert(config('message_flash.alert.certificate_add'));
            return redirect()->intended(route('page.certificate')); // intended - назад или route
        }

        $user_certificate = UserCertificate::create(
            [
                'title' => $request->title,
                'country_from' => ($request->country_from) ?: '',
                'country_to' => ($request->country_to) ?: '',
                'price' => ($request->price) ?: '',
                'date' => ($request->date) ?: '',
                'user_id' => ($request->user) ?: '',
            ]);

        flash()->info(config('message_flash.info.certificate_add'));
        return redirect()->back();


    }


    /**
     * Метод обновления материала "сертификата"
     */
    public function updateCertificate(AddCertivicateRequest $request)
    {

        /**
         * Вход  для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user_cert = UserCertificate::query()
            ->where('id', $request->certificate_id)
            ->update([
                'title' => $request->title,
                'country_from' => ($request->country_from) ?: '',
                'country_to' => ($request->country_to) ?: '',
                'price' => ($request->price) ?: '',
                'date' => ($request->date) ?: '',
                'user_id' => ($request->user) ?: '',
            ]);

        if ($user_cert) {
            flash()->info(config('message_flash.info.certificate_update'));
            return redirect()->back(); // назад
        }
        flash()->info(config('message_flash.alert.certificate_update'));
        return redirect()->back(); // назад
    }


    /**
     * Метод удаления сертификата
     */
    public function delCertificate(Request $request)
    {

        /**
         * Вход в editor для admin и manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        /**
         * Удаляем сертификат
         */
        $user = auth()->user();

        if (role($user->id) == 'admin' or role($user->id) == 'senior') {

            UserCertificate::destroy($request->id);

            flash()->info(config('message_flash.info.certificate_del'));

            if ($request->redirect) {
                return redirect($request->redirect);
            }

            return redirect()->back(); // назад
        }
        flash()->alert(__('У вас не достаточно прав для удаления'));
        return back();


    }


    public function certificaresUser($id)
    {

        $item = User::find($id);
        $certificates = UserCertificate::query()->where('user_id', $id)->orderBy('date', 'asc')->get();
        $user = auth()->user();

        return view('dashboard.zone_admin_usercertificate',
            [
                'item' => $item,
                'user' => $user,
                'certificates' => $certificates
            ]);

    }

    public function pageAddCertificaresUser($id)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();
        $item = User::find($id);


        return view('dashboard.zone_admin_usercertificateadd',
            [
                'user' => $user,
                'item' => $item,

            ]);


    }

    public function pageUpdateCertificaresUser($id, $certificate_id)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $user = auth()->user();
        $item = User::find($id);
        $certificate = UserCertificate::query()->where('id', $certificate_id)->first();
        $users = User::query()->get();

        return view('dashboard.zone_admin_usercertificateupdate',
            [
                'user' => $user,
                'users' => $users,
                'item' => $item,
                'certificate' => $certificate,
            ]);


    }


    /**
     * Метод вывода всех пользователей
     */
    public function users()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $users = User::query()->paginate(20);

        return view('dashboard.zone_admin_users',
            [
                'user' => $user,
                'users' => $users,
            ]);

    }

    /**
     * Метод вывода всех пользователей
     */
    public function userSearch(UserSearchRequest $request)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $users = User::query()
            ->where("name", "like", "%" . $request->search . "%")
            ->orWhere("email", "like", "%" . $request->search . "%")
            ->paginate(20);

        return view('dashboard.zone_admin_users',
            [
                'user' => $user,
                'users' => $users,
                'search' => $request->search,
            ]);

    }

    /**
     * Метод потска  пользователей для определенного менеджера
     */
    public function subuserSearch(UserSearchRequest $request)
    {

        /**
         * Вход в editor для admin
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


        return view('dashboard.zone_admin_managerupdate',
            [
                'user' => $user,
                'item' => $item,
                'subusers' => $subusers,
                'subusers_all' => $subusers_all,
                'search' => $request->search,
                'managers' => $managers,
            ]);

    }

    /**
     * Метод массивого закрепления пользователей за менеджером
     */
    public function filterManagerForUser(Request $request)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        // dd(role($request->fix));


        /**
         * проверка менеджера, 0 - не выбран!
         */
        if ($request->fix == 0) {

            flash()->alert(config('message_flash.alert.filter_user_for_manager'));
            return redirect()->back();
        }
        /**
         * проверка менеджера. Взлом? если порльзователь или админ - это не менеджер
         */
        if (role($request->fix) == 'user' or role($request->fix) == 'admin' ) {
            flash()->alert(config('message_flash.alert.filter_user_for_manager3'));
            return redirect()->back();
        }
        /**
         * проверка пользователей, null - не отмечен!
         */
        if (is_null($request->ids)) {

            flash()->alert(config('message_flash.alert.filter_user_for_manager2'));
            return redirect()->back();
        }

        $ids = explode(",", $request->ids);
        $result = User::whereIn("id", $ids)
            ->update([
                'user_id' => $request->fix
            ]);

        if ($result) {
            $u = User::find($request->fix);
            $filter_user_for_manager = str_replace("{manager}", $u->name, config('message_flash.info.filter_user_for_manager'));
            flash()->info($filter_user_for_manager);
            return redirect()->back();
        }
        flash()->alert(config('message_flash.alert.filter_user_for_manager4'));
        return redirect()->back();
    }


    public function pageUser($id)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();

        $item = User::query()->where('id', $id)->first();
        session(['user' => $item->id]); // запустим сессию для изменения пароля нужного пользователя

        return view('dashboard.zone_admin_userupdate',
            [
                'user' => $user,
                'item' => $item,
            ]);
    }


    public function updateUser(UpdateAdminUserFormRequest $request)
    {
        /**
         * Вход в editor для admin, manager
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $q = false;

        if (role($user->id) == "admin") {
            $q = true; // если админ. редактировать можно
        }

        if (role($user->id) == "manager" or role($user->id) == "senior") {


            /**
             * Проверим, закреплен ли пользователь?
             */
            $u = User::find($request->id);
            if ($u->user_id == $user->id) {
                $q = true; // закреплен. редактировать можно
            }

            $his_manager_id = $u->user_id;
            $his_manager = User::find($his_manager_id);
            if (isset($his_manager->senior_id)) {
                if ($his_manager->senior_id == $user->id) {
                    /** это РОП, редактирует пользователя, который принадлежит менеджеру его команды */
                    $q = true; // редактировать можно

                }
            }

        }


        if ($q) {
            $result = User::query()
                ->where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'birthdate' => $request->birthdate,
                ]);

            if (!$result) {

                flash()->alert(config('message_flash.alert.user_update'));
                return back();
            }
            flash()->info(config('message_flash.info.user_update'));
            return back();
        }

        flash()->alert(config('message_flash.alert.user_update'));
        return back();

    }


    /**
     * туры пользователя
     */
    public function toursUser($id)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = User::query()->where('id', $id)->first();
        $crm = new Api();
        $tours = [];

        $tours = $crm->CRM($item->email);



        return view('dashboard.zone_admin_usertours',
            [
                'user' => $user,
                'item' => $item,
                'tours' => $tours,
            ]);
    }


    /**
     * закремпленный менеджер за пользователем
     */
    public function managerForUser($id)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = User::query()->where('id', $id)->first();
        $managers = User::query()->where('user_role_id', 1)->get(); // 1 - это менеджер
        /**
         *  запустим сессию для проверки этого юзера в updateManagerForUser
         */
        session(['user_for_manager' => $item->id]); // запустим сессию
        return view('dashboard.zone_admin_usermanager',
            [
                'user' => $user,
                'item' => $item,
                'managers' => $managers,

            ]);
    }


    /**
     * закремпленный менеджер за пользователем
     */
    public function updateManagerForUser(Request $request)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $session_user = $request->session()->get('user_for_manager');

        /**
         *  Проверка совпадения сессии и $request->id
         */
        if ($session_user == $request->id) {
            $result = User::query()
                ->where('id', $request->id)
                ->update([
                    'user_id' => $request->manager,
                ]);
            $manager = User::query()->where('id', $request->manager)->first();
        }
        if (!$result) {

            flash()->alert(config('message_flash.alert.user_for_manager'));
            return back();
        }
        // $request->session()->regenerate();
        $text__user_for_manager = str_replace("{manager}", $manager->name, config('message_flash.info.user_for_manager'));
        flash()->info($text__user_for_manager);
        return back();

    }


    /**
     * Метод вывода всех менеджеров
     */
    public function managers()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $users = User::query()->where('user_role_id', 1) // 1 это менеджеры
        ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc') // я гений
            ->paginate(20);

        return view('dashboard.zone_admin_managers',
            [
                'user' => $user,
                'users' => $users,
            ]);

    }


    /**
     * Метод страница менеджера
     */
    public function pageManager($id)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = User::query()->where('id', $id)->first();

        $subusers = User::query()->where('user_id', $id)->paginate(20);
        $managers = User::query()->where('user_role_id', 1) // 1 это менеджеры
        ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        return view('dashboard.zone_admin_managerupdate',
            [
                'user' => $user,
                'item' => $item,
                'subusers' => $subusers,
                'managers' => $managers,
            ]);
    }


    /**
     * Метод редактирование менеджера
     */
    public function updateManager(Request $request)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */

        $connect = UserConnection::query()
            ->where('user_id', $request->id)->first();

      // $user =  User::query()->where('id', $request->id);

        //dd($connect);
        if ($connect) {
            $result = UserConnection::query()->updateOrCreate([
                'user_id' => $request->id
            ],
                [
                    'user_id' => $request->id,
                    'title' => ($request->title)?:'',
                    'phone' => (phone($request->phone))?:'',
                    'email' => ($request->email)?:'',
                    'whatsapp' => ($request->whatsapp)?:'',
                    'telegram' => ($request->telegram)?:'',
                ]);

        } else {

            $result = UserConnection::query()->create([
                'user_id' => $request->id,
                'title' => ($request->title) ?: '',
                'phone' => ($request->phone) ? phone($request->phone): '',
                'email' => ($request->email) ?: '',
                'whatsapp' => ($request->whatsapp) ?: '',
                'telegram' => ($request->telegram) ?: '',
            ]);
        }

        User::query()
            ->where('id', $request->id)
            ->update([
                'user_connection_id' => $result->id
            ]);


        if (!$result) {

            flash()->alert(config('message_flash.alert.user_update'));
            return back();
        }

        flash()->info(config('message_flash.info.user_update'));
        return back();

    }


    /**
     * Метод сизменение менеджера по умолчанию
     */
    public function updateManagerReserve(Request $request)
    {


        $user = User::query()->where('id', $request->manager)->first();
        if (role($user->id) == 'manager') {

            $reserve = User::query()->where('id', manager_reserve()->id)->first();
            if ($reserve) {
                User::where('id', manager_reserve()->id)->update(['manager_reserve' => NULL]);
                // dump('success');
            }
            User::where('id', $request->manager)->update(['manager_reserve' => $request->manager]);

            return back();

            /*  dump($request->manager);
              dd($user);*/

        }
        return back();

    }


    /**
     * Метод сдобавить user-а
     */
    public function addUser()
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();

        return view('dashboard.zone_admin_useradd',
            [
                'user' => $user,
            ]);

    }

    /**
     * Метод сдобавить user-а
     */
    public function addManager()
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();

        return view('dashboard.zone_admin_manageradd',
            [
                'user' => $user,
            ]);

    }

    /**
     * Метод удалить user-а
     */
    public function deleteUser(Request $request)
    {
        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        $user = auth()->user();
        if ($user->id == $request->id) {
            flash()->alert(config('message_flash.alert.self_delete')); //удаление себя - нельзя
            return redirect()->back();
        }

        /**
         * если admin
         */
        if (role($request->id) == 'admin') {

            flash()->alert(config('message_flash.alert.admin_delete')); //удалить админа нельзя, только из админ панели
            return redirect()->back();

        }

        /**
         * если user
         */
        if (role($request->id) == 'user') {
            /**
             * подготовим к удалению
             */
            $remove = User::find($request->id);

        }

        /**
         * если manager
         */
        if (role($request->id) == 'manager') {


            /**
             * делаем другого любого первого попавшего  manager-ом по умолчанию
             */

            if ($request->id == manager_reserve()->id) {
                // !!! удаляется менеджер по умолчанию
                $rand_manager = User::query()
                    ->where('user_role_id', 1)
                    ->where('id', '!=', $request->id)
                    ->first(); // 1 это менеджеры

                User::where('id', $rand_manager->id)->update(['manager_reserve' => $rand_manager->id]);

            }

            /**
             * заскрепляем пользователей удаляемого менеджера,
             * за другим менеджером по умолчанию, которого только-что сменили
             */

            $users = User::query()
                ->select('id')
                ->where('user_id', $request->id)->get()->toArray();

            if ($users) {
                foreach ($users as $u) {
                    $ids[] = $u['id'];

                }

                User::whereIn("id", $ids)
                    ->update([
                        'user_id' => manager_reserve()->id
                    ]);
            }
            /**
             * подготовим к удалению
             */

            $remove = User::find($request->id);

        }


        /**
         * если senior
         */
        if (role($request->id) == 'senior') {

            /**
             * если  это  РОП (senior)
             * делаем другого любого первого попавшего  manager-ом по умолчанию
             */

            if ($request->id == manager_reserve()->id) {

                // !!! удаляется менеджер по умолчанию
                $rand_manager = User::query()
                    ->where('user_role_id', 1)
                    ->where('id', '!=', $request->id)
                    ->first(); // 1 это менеджеры

                User::where('id', $rand_manager->id)->update(['manager_reserve' => $rand_manager->id]);
            }

            /**
             * заскрепляем пользователей удаляемого менеджера,
             * за другим менеджером по умолчанию, которого только-что сменили
             */

            $users = User::query()
                ->select('id')
                ->where('user_id', $request->id)->get()->toArray();

            if ($users) {
                foreach ($users as $u) {
                    $ids[] = $u['id'];
                }

                User::whereIn("id", $ids)
                    ->update([
                        'user_id' => manager_reserve()->id
                    ]);
            }

            User::query()->where('senior_id', $request->id)
                ->update([
                    'senior_id' => null
                ]);


            $remove = User::find($request->id);


        }


        $remove->delete();
        flash()->info(config('message_flash.info.user_delete'));
        return redirect()->back();

    }


    /**
     * Метод вывода всех РОП ов
     */
    public function seniors()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $managers = User::query()
            ->where('user_role_id', 1) // 1 это менеджеры   //
            ->whereNotNull('senior')
            ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc') // я гений  //
            ->paginate(20);

        return view('dashboard.zone_admin_seniors',
            [
                'user' => $user,
                'managers' => $managers,
            ]);

    }

    /**
     * Метод страница для  создание РОП
     */
    public function pageAddSenior()
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $managers = User::query()
            ->where('user_role_id', 1) // 1 это менеджеры   //
            ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc') // я гений  //
            ->paginate(20);

        return view('dashboard.zone_admin_senior_add',
            [
                'user' => $user,
                'managers' => $managers,
            ]);

    }

    /**
     * Метод  создание РОП
     */
    public function addSenior(Request $request)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */


        /** На всякий случай проверим, что закрепляет admin   */
        $user = auth()->user();
        if (role($user->id) == "admin") {

            /**
             * проверка пользователей, null - не отмечен!
             */
            if (is_null($request->ids)) {

                flash()->alert(config('message_flash.alert.senior_plus'));
                return redirect()->back();
            }

            $ids = explode(",", $request->ids);
            foreach ($ids as $senior) {
                $u = User::find($senior);
                $u->senior = $senior;
                $u->save();

            }

            flash()->info(config('message_flash.info.senior_plus'));
            return redirect()->back();


        }

        flash()->alert(config('message_flash.alert.role_error'));
        return redirect()->back();


    }


    /**
     * Метод вывода одного  РОП и удаление из своей команды
     */
    public function addManagerFromSeniorMinus($id)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = User::query()
            ->where('senior', $id)
            ->with('users')
            ->withCount('users')
            ->first();

        $managers = User::query()
            ->with('fixed_manager')
            ->where(function ($query) use ($id) {
                $query->where('user_role_id', 1);
                $query->whereNull('senior');

            })
            ->whereNull('senior')
            ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();


        return view('dashboard.zone_admin_senior_minus',
            [
                'user' => $user,
                'item' => $item,
                'managers' => $managers,
            ]);

    }


    /**
     * Метод вывода одного  РОП и добавления в команду
     */
    public function addManagerFromSeniorPlus($id)
    {

        /**
         * Вход в editor для admin
         * провекрка в app/Http/Middleware/RoleMiddleware.php
         */
        $user = auth()->user();
        $item = User::query()
            ->where('senior', $id)
            ->with('users')
            ->withCount('users')
            ->first();

        $managers = User::query()
            ->with('fixed_manager')
            ->where(function ($query) use ($id) {
                $query->where('user_role_id', 1);
                $query->whereNull('senior');

            })
            ->whereNull('senior')
            ->with('users')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();


        return view('dashboard.zone_admin_senior_plus',
            [
                'user' => $user,
                'item' => $item,
                'managers' => $managers,
            ]);

    }


    /**
     * Метод удаление одного  РОП
     */
    public function deleteSenior(Request $request)
    {

        $u = User::find($request->id);
        $u->senior = null;
        $u->save();

        $senior_delete = str_replace("{senior}", $u->name, config('message_flash.info.senior_delete'));
        flash()->info($senior_delete);
        return redirect()->back();

    }


    /**
     * Метод закрепления менеджера за РОП
     */
    public function updateSeniorComandsPlus(Request $request)
    {

        /** На всякий случай проверим, что закрепляет admin   */
        $user = auth()->user();
        if (role($user->id) == "admin") {

            /**
             * проверка пользователей, null - не отмечен!
             */
            if (is_null($request->ids)) {

                flash()->alert(config('message_flash.alert.managers_plus'));
                return redirect()->back();
            }

            $ids = explode(",", $request->ids);
            $result = User::whereIn("id", $ids)
                ->update([
                    'senior_id' => $request->id
                ]);
            if ($result) {

                flash()->info(config('message_flash.info.managers_plus'));
                return redirect()->back();
            }

        }
        flash()->alert(config('message_flash.alert.role_error'));
        return redirect()->back();


    }


    /**
     * Метод открепленичя менеджера за РОП
     */
    public function updateSeniorComandsMinus(Request $request)
    {

        /** На всякий случай проверим, что закрепляет admin   */
        $user = auth()->user();
        if (role($user->id) == "admin") {

            /**
             * проверка пользователей, null - не отмечен!
             */
            if (is_null($request->ids)) {

                flash()->alert(config('message_flash.alert.managers_minus'));
                return redirect()->back();
            }

            $ids = explode(",", $request->ids);
            $result = User::whereIn("id", $ids)
                ->update([
                    'senior_id' => null
                ]);
            if ($result) {

                flash()->info(config('message_flash.info.managers_minus'));
                return redirect()->back();
            }

        }
        flash()->alert(config('message_flash.alert.role_error'));
        return redirect()->back();


    }

    /**
     * страница баллов и кешбэка User -a
     */
    public function pageBallForUser($id)
    {
        $user = auth()->user();
        $q = false;
        /** На всякий случай проверим, что это  admin */
        if (role($user->id) == "admin") {
           $q = true;
        }
        /** РОП тоже может */
        if (role($user->id) == "senior") {

            $item = User::find($id);

            /*** сложная проверка */
            /*** переходим снаяало на менеджера, потом на РОП этого менеджера и проверяем id */
            /*** переходим на менеджера пользователя и проверяем id */

            if(!is_null($item->manager->fixed_manager)) {
                if (($item->manager->fixed_manager->id == $user->id) or ($item->manager->id == $user->id)) {
                    $q = true;
                }
            }

        }

        if ($q) {

            $item = User::find($id);
            $managers = User::query()->where('user_role_id', 1)->get(); // 1 - это менеджер
        }
        return view('dashboard.zone_admin_userball',
            [
                'user' => $user,
                'item' => $item,
                'managers' => $managers,

            ]);


    }


    /**
     * Метод обновления кешбэка
     */
    public function updateBallForUser(UpdateBallRequest $request)
    {
        $user = auth()->user();
        $q = false;
        /** На всякий случай проверим, что это  admin */
        if (role($user->id) == "admin") {
            $q = true;

        }
        /** РОП тоже может */
        if (role($user->id) == "senior") {

            $item = User::find($request->id);

            /*** сложная проверка */
            /*** переходим снаяало на менеджера, потом на РОП этого менеджера и проверяем id */
            /*** переходим на менеджера пользователя и проверяем id */

            if(!is_null($item->manager->fixed_manager)) {
                if (($item->manager->fixed_manager->id == $user->id) or ($item->manager->id == $user->id)) {
                    $q = true;
                }
            }
        }


        if($q) {
            $u = User::find($request->id);

            if (is_null($u->ball)) {
                $ball = ($request->ball) ?: null;
            } else {
                if (!is_null($request->ball)) {
                    $ball = $request->ball;
                } else {
                    $ball = $u->ball;
                }
            }

            if (is_null($u->cashback)) {
                $cashback = ($request->cashback) ?: null;
            } else {
                if (!is_null($request->cashback)) {
                    $cashback = $request->cashback;
                } else {
                    $cashback = $u->cashback;
                }
            }


            User::query()
                ->where('id', $request->id)
                ->update([
                    'ball' => $ball,
                    'cashback' => $cashback,
                ]);

            flash()->info(config('message_flash.info.ball_ok'));
            return redirect()->back();
        }

        flash()->alert(config('message_flash.alert.role_error'));
        return redirect()->back();

    }

}
