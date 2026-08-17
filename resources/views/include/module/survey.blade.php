@if($survey)
<div class="block__800 ">
    <div class="_ssurvey _ssurvey__js">
        <div class="survey__flex">
            <div class="survey__sLeft">
                <span>{{__('Оцените работу поиска')}}</span>
            </div>
            <div class="survey__sright sright">
                <div class="sright__flex">

                    <div class="sright__stars">
                     @include('include.search.bottom_form.s_stars_survey')
                    </div>

                    <div class="sright__button">
                        <div class="button button_mini button_survey__js">{{__('Отправить')}}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endif
