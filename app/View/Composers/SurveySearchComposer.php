<?php

namespace App\View\Composers;



use App\Models\Survey;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SurveySearchComposer
{
    public function compose(View $view): void
    {
        $user = auth()->user();

        $survey = true;

        $result = Survey::query()->where('ip', getIp())->first();
            if($result) {
                $survey = null;
            }

        if($user) {
            $result = Survey::query()->where('user_id', $user->id)->first();

            if (isset($result->id)) {
                $survey = null;
            }
        }


        $view->with([
            'survey' => $survey,
        ]);

    }

}
