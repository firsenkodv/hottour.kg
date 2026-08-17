<?php

namespace App\Http\Controllers\Dashboard;

use App\Crm\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Requests\UpdatePasswordFormRequest;
use App\Models\User;

use App\Models\UserCertificate;
use App\Models\UserFavorite;
use App\Models\UserImportant;
use Domain\Hotel\ViewModels\HotelViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Метод входа в лк, получение туров и документов
     */
    public function page()
    {

        $user   = auth()->user();
        $session_user = session()->get('user');
        $tours = [];

            return view('dashboard.cabinet',
                [
                    'user' => $user,
                    'tours' => $tours
                ]);

    }

    /**
     * copy потом удалить!!!!
     */
    public function page__copy()
    {

        $user   = auth()->user();
        $session_user = session()->get('user');

        $crm = new Api();
        $tours = [];

         $tours = $crm->CRM($user->email);
            return view('dashboard.cabinet',
                [
                    'user' => $user,
                    'tours' => $tours
                ]);

    }

    /**
     * copy потом удалить!!!!
     */

    /////////////////////

    /**
     * Метод страницы настройки
     */
    public function setting() {
        $user   = auth()->user();

        /**
         *  запустим сессию для проверки этого юзера в settingHandel
         */
        session(['user' => $user->id]); // запустим сессию

        return view('dashboard.setting',
            [
                'user' => $user
            ]);

    }
    /**
     * Метод изменения пароля
     */
    public function settingPasswordHandel(UpdatePasswordFormRequest $request) {

        $session_user = $request->session()->get('user');

        /**
         *  Проверка совпадения сессии и $request->id
         */
        $user = auth()->user();
/*        dump($session_user);
        dump($request->id);
        dd($user->id);*/
        if($session_user == $request->id) { /** сессия совпадает с id пользователя которого изменяем **/

            $user = auth()->user();

            $q = false;
            $regenerate = false;

            if (role($user->id) == "admin") {
                $q = true; // если админ. редактировать можно
            }

            if (role($user->id) == "manager") {

                /**
                 * Проверим, закреплен ли пользователь?
                 */
                $u = User::find($request->id);
                if ($u->user_id == $user->id) {
                    $q = true; // закреплен. редактировать можно
                }

            }

            if($user->id == $request->id) {
                $q = true; // если это сам пользователь редактирует себя
                $regenerate = true; // если это сам пользователь редактирует себя, то можно regenerate

            }

            if($q) {

              User::query()
                    ->where('id', $request->id)
                    ->update([
                        'password' => bcrypt($request->password)
                    ]);
            }


        }

        if($regenerate) {

            $request->session()->regenerate();
            flash()->info(config('message_flash.info.success_password'));
            return redirect()->back();


        }

        flash()->info(config('message_flash.info.m_success_password'));
        return redirect()->back();

    }
    /**
     * Метод загрузки аватара
     * НЕ ИСПОЛЬЗУЕМ, загрузка ajax
     */
    public function settingHandel(UpdateFormRequest $request) {

        if ($request->hasFile('import_file')) {

            /**
             *  НЕ ИСПОЛЬЗУЕМ, загрузка ajax
             */

            $file = $request->file('import_file');

            $destinationPath = 'users/'. auth()->user()->id;
            $newFileName = $file->getClientOriginalName();
            $file->storeAs($destinationPath, $newFileName);

            $avatar = "users/". auth()->user()->id ."/$newFileName";

            /**
             *  НЕ ИСПОЛЬЗУЕМ, загрузка ajax
             */

        }


        $session_user = $request->session()->get('user');

        /**
         *  Проверка совпадения сессии и $request->id
         */
        if($session_user == $request->id) {
            $user = User::query()
                ->where('id', auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'birthdate' => ($request->birthdate) ?: auth()->user()->birthdate,
                    'inn' => $request->inn,
                    'passport' => $request->passport,
                    'passport_issued_at' => $request->passport_issued_at,
                    'passport_issued_by' => $request->passport_issued_by,
                ]);
        }
        return redirect()->intended(route('setting'));

    }


    /**
     * Метод страница "Важное"
     */
    public function important() {

        $user   = auth()->user();
        $items = UserImportant::query()->orderBy('id', 'desc')->get();

        return view('dashboard.important',
            [
                'user' => $user,
                'items' => $items
            ]);

    }
    /**
     * Метод страница "Важное" - полная страница
     */
    public function fullImportant($id) {

        $user   = auth()->user();
        $item = UserImportant::query()->where('id', $id)->first();

        return view('dashboard.important_full',
            [
                'user' => $user,
                'item' => $item
            ]);

    }


    /**
     * Метод страница "Сертификата"
     */
    public function certificate() {

        $user   = auth()->user();
        $items = UserCertificate::query()->where('user_id', $user->id)->orderBy('date', 'asc')->get();

        return view('dashboard.certificate',
            [
                'user' => $user,
                'items' => $items
            ]);

    }


    /**
     * Метод страница "Избранное"
     */
    public function favoritesUser() {




        $user   = auth()->user();
        $items = UserFavorite::query()->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);

        settype($data, "array");
        if (count($items)) {

            $hotels = [];
            $new_hotels = [];
            foreach ($items as $k=>$h) {
                $hotel_ids[$h->hotelid] = $h->hotelid;
            }
            $hotels = HotelViewModel::make()->Hotels($hotel_ids); // array c ключами из slug

            foreach ($items as $k=>$h) {

                $p = $h->params;
                foreach ($p as $params) {
                    $params->favorite_id = $h->favorite_id;
                    $params->site_hotel = (object)$hotels[$params->hotel];
                    $data[$k] = $params;
                }

            }

        }



        return view('dashboard.favorites_user',
            [
                'items' => $items,
                'user' => $user,
                'tour_data' => $data,

            ]);

    }


    // blocked


    public function blocked()
    {
        /**
         *   заблдоктрованный  пользователь
         */

        $user = auth()->user();

        return view('dashboard.cabinet_blocked',
            [
                'user' => $user,
            ]);
    }





}
