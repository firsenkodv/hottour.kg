<?php

namespace App\View\Composers;


use App\Models\Survey;
use App\Models\UserSurvey;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SurveyResultComposer
{
    public function compose(View $view): void
    {

        /**
         *
         * количество голосований пользователей. Вопросы по поиску
         *
         */
        $surveys = Survey::query()->get();
        $stars = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
        $scors = [];
        foreach (config('surveys.survey') as $k => $item) {
            $scors[$k] = 0;
        }

        $survey = $this->helper($surveys, $stars, $scors);



        /**
         *
         * количество голосований пользователей. Вопросы по личному кабинету
         *
         */
        $user_surveys = UserSurvey::query()->get();
        foreach (config('surveys.survey_user') as $k => $item) {
            $scors[$k] = 0;
        }
        $survey_user = $this->helper($user_surveys, $stars, $scors);


        $view->with([
            'survey' => $survey,
            'survey_user' => $survey_user,
        ]);

    }

    public function helper($model, $stars, $scors):array
    {

        foreach ($model as $survey) {

            switch ($survey->star) {
                case 1:
                    $stars[1] += 1;
                    break;
                case 2:
                    $stars[2] += 1;
                    break;
                case 3:
                    $stars[3] += 1;
                    break;
                case 4:
                    $stars[4] += 1;
                    break;
                case 5:
                    $stars[5] += 1;
                    break;
            }

            ///////////////////////


            foreach ($survey->params as $scr) {

                if($scr){
                    $scors[(int)$scr] += 1;
                }

            }
        }

        return array('stars' => $stars, 'scors' => $scors);

    }

}
