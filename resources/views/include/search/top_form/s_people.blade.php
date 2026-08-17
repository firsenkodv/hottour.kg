<div class="s_people s_block__5">
    <div class="s_people__label s_label">{{__('Кол-во человек')}}</div>
    <div class="input_item number_people" id="adults">
        <input type="hidden" name="adults" value="{{ $adults }}" id="adults_input">
        <p>{{ __('2 взрослых') }}</p>
        <div class="number_people_drop full_people">
            <div class="adults how_people">
                <label>{{ __('Взрослые') }}</label>
                <div class="quantity adult">

                    <a href="#" data-input="adults_input" class="{{ ($adults==1)?"active":""}}">1</a>
                    <a href="#" data-input="adults_input" class="{{ ($adults==2)?"active":""}}">2</a>
                    <a href="#" data-input="adults_input" class="{{ ($adults==3)?"active":""}}">3</a>
                    <a href="#" data-input="adults_input" class="{{ ($adults==4)?"active":""}}">4</a>
                </div>
            </div>
            <div class="children how_people">
                <label>{{ __('Дети от 2-х до 14 лет') }}</label>
                <input type="hidden" id="input_child" name="child" value="{{ $child }}">
                <div class="quantity child" id="child_list">

                    <a href="#" data-input="input_child" class="{{ ($child_value[0] == 0)?"active":"" }}">0</a>
                    <a href="#" data-input="input_child" class="{{ ($child_value[0] == 1)?"active":"" }}">1</a>
                    <a href="#" data-input="input_child" class="{{ ($child_value[0] == 2)?"active":"" }}">2</a>
                    <a href="#" data-input="input_child" class="{{ ($child_value[0] == 3)?"active":"" }}">3</a>
                </div>

                @if($child_value[0]>0)
                    @for($i=0;$i < $child_value[0]; $i++)
                <div class="child_age">
                    <button type="button" class="child_age__button child_age__button-minus">-</button>
                    <input type="text" readonly="" value="{{@$child_year[$i]}}" class="child_age__input">
                    <button type="button" class="child_age__button child_age__button-plus">+</button>
                </div>
                    @endfor
                @endif
            </div>
            <div class="babies how_people">
                <label>{{ __('Дети до 2-х лет') }}</label>
                <input type="hidden" id="input_infant" name="infant" value="{{ $infant }}">
                <div class="quantity child" id="infatn_list">
                    <a href="#" data-input="input_infant" class="{{($infant==0)?"active":""}}">0</a>
                    <a href="#" data-input="input_infant" class="{{($infant==1)?"active":""}}">1</a>
                    <a href="#" data-input="input_infant" class="{{($infant==2)?"active":""}}">2</a>
                    <a href="#" data-input="input_infant" class="{{($infant==3)?"active":""}}">3</a>
                </div>
            </div>
        </div>
    </div>

</div>

