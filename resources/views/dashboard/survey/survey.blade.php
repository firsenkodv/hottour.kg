<div class="c__title_subtitle">
    <h3 class="F_h1">{{ __('Оценки') }}</h3>
    <div class="F_h2 pad_t5">
        <span>{{__('Оценки поиска туров и личного кабинета пользователями.')}}</span></div>
</div>


<div class="c__flex">
    <div class="c__flex_50 c__flex_50_left">

        <div class="text_input">
            <div class="c_title"><span>Поиск</span></div>

            <div class="starscrin">
                @foreach($survey['stars'] as $k => $star)
                    <div class="starscrin_li">
                        <div class="starscrin_li_stars">
                            <div class="s_stars_s">
                                <div class="rating-area_survey" id="">
                                    <input type="radio" @if($k == 5) checked @endif value="5">
                                    <label></label>
                                    <input type="radio" @if($k == 4) checked @endif value="4">
                                    <label></label>
                                    <input type="radio" @if($k == 3) checked @endif value="3">
                                    <label></label>
                                    <input type="radio" @if($k == 2) checked @endif value="2">
                                    <label></label>
                                    <input type="radio"  @if($k == 1) checked @endif  value="1">
                                    <label></label>
                                </div>
                            </div>

                        </div>
                        <div class="starscrin_li_responce">{{ $star }}</div>
                    </div>
                @endforeach



            </div>

            <div class="morescrin">

                @if(config('surveys.survey'))

                    @foreach(config('surveys.survey') as $k => $v)
                        <div class="morescrin_li">
                            <div class="morescrin_li_text">{{ $v }}</div>
                            <div class="morescrin_li_score">{{ $survey['scors'][$k]  }}</div>
                        </div>

                    @endforeach
                @endif


            </div>

        </div>

    </div><!--.c__flex_50_left-->
    <div class="c__flex_50 c__flex_50_right">

        <div class="text_input">
            <div class="c_title"><span>Личный кабинет</span></div>
            <div class="starscrin">

                @foreach($survey_user['stars'] as $k => $star)

                <div class="starscrin_li">
                    <div class="starscrin_li_stars">
                        <div class="s_stars_s">
                            <div class="rating-area_survey" id="">
                                <input type="radio"  @if($k == 5) checked @endif  value="5">
                                <label></label>
                                <input type="radio"  @if($k == 4) checked @endif  value="4">
                                <label></label>
                                <input type="radio"  @if($k == 3) checked @endif  value="3">
                                <label></label>
                                <input type="radio"  @if($k == 2) checked @endif  value="2">
                                <label></label>
                                <input type="radio"  @if($k == 1) checked @endif  value="1">
                                <label></label>
                            </div>
                        </div>

                    </div>
                    <div class="starscrin_li_responce">{{ $star }}</div>
                </div>
                @endforeach

            </div>

            <div class="morescrin">

                @if(config('surveys.survey_user'))

                    @foreach(config('surveys.survey_user') as $k => $v)
                        <div class="morescrin_li">
                            <div class="morescrin_li_text">{{ $v }}</div>
                            <div class="morescrin_li_score">{{ $survey_user['scors'][$k]  }}</div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>

    </div><!--.c__flex_50_right-->
</div><!--.c__flex-->
