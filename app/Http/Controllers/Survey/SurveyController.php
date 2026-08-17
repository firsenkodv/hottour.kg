<?php
namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\UserSurvey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{

    public function createSurvey(Request $request) {


        if(isset($request->star)) {
            $user = auth()->user();

            $result = Survey::query()->create([

                'star' => $request->star,
                'params' => ($request->params)?:'',
                'user_id' => (isset($user))? $user->id : null,
                'ip' => getIp(),

            ]);

            return response()->json([
                'responce' => $request->all(),
                'result' => $result
            ]);
        }

       // dd($request->all());

        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'error' => $request->all()
        ]);


    }

    public function createSurveyUser(Request $request) {


        if(isset($request->star)) {
            $user = auth()->user();

            $result = UserSurvey::query()->create([

                'star' => $request->star,
                'params' => ($request->params)?:'',
                'user_id' => (isset($user))? $user->id : null,
                'ip' => getIp(),

            ]);

            return response()->json([
                'responce' => $request->all(),
                'result' => $result
            ]);
        }



        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'error' => $request->all()
        ]);


    }

}
