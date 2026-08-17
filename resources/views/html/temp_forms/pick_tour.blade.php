<div class="F_form  F_form_pick_tour" style="display: none" id="pick_tour" data-token="{{ csrf_token() }}" data-country="">
<x-forms.loader class="br_12"/>
    @include('html.modals.responce.responce')

    <div class="F_form__pick flex">
        <div class="F_form__pick_left w_53">

        </div>
        <div class="F_form__pick_right  w_47">
            <div class="F_form__body new__temp">

                <div class="new__temp_top">
                    <div class="F_form__flex">
                        <div class="F_form__left">
                            <div class="F_h1"><span>{{__('Подобрать тур')}}</span></div>
                            <div class="F_h2"><span>{{__('Оставьте заявку и мы Вам перезвоним')}}</span></div>
                        </div>
                    </div><!--.F_form__flex-->
                </div><!--.new__temp_top-->


                <div class="new__temp_middle">
                    <div class="alax_inputs">
                        <div class="text_input">
                            <x-forms.text-input_fromLabel
                                type="text"
                                name="name"
                                placeholder="Имя"
                                value="{{ old('name')?:'' }}"
                                required="true"
                                class="input name"
                            />
                            <x-forms.error class="error_name"/>


                        </div>

                        <div class="text_input">
                            <x-forms.text-input_fromLabel
                                type="text"
                                name="phone"
                                placeholder="Телефон"
                                value="{{ old('phone')?:'' }}"
                                required="true"
                                class="input phone"
                            />
                            <x-forms.error class="error_phone"/>

                        </div>

                        <div class="text_input">
                            <x-forms.text-input_fromLabel
                                type="text"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email')?:'' }}"
                                required="true"
                                class="input email"
                            />
                            <x-forms.error class="error_email"/>

                        </div>
                        {{-- город вылета: тот же chosen, что в форме поиска.
                             value — ключ из config/selects/data_sity, его
                             разворачивает в название хелпер sity() при отправке письма --}}
                        <div class="text_input form_select">
                            <select class="js-chosen-form sity" name="sity" data-placeholder="{{ __('Выбрать город вылета') }}">
                                <option value=""></option>
                                @foreach(config('selects.data_sity') as $key => $city)
                                    <option value="{{ $key }}" @selected(old('sity') === $key)>{{ $city['text'] }}</option>
                                @endforeach
                            </select>
                            <x-forms.error class="error_sity"/>
                        </div>

                        {{-- страна: список стран сайта (CountryMenuComposer),
                             в заявку уходит название --}}
                        <div class="text_input form_select">
                            <select class="js-chosen-form country" name="country" data-placeholder="{{ __('Выбрать страну') }}">
                                <option value=""></option>
                                @foreach($country_menu as $country)
                                    <option value="{{ $country->title }}" @selected(old('country') === $country->title)>{{ $country->title }}</option>
                                @endforeach
                            </select>
                            <x-forms.error class="error_country"/>
                        </div>

                        {{-- даты вылета: тот же календарь-диапазон, что в форме
                             поиска (компонент x-forms.datepicker, js/datepicker.js).
                             Крестик очистки появляется, когда даты выбраны --}}
                        <x-forms.datepicker
                            name="date"
                            mode="range"
                            floating
                            placeholder="Удобные даты вылета"
                            value="{{ old('date')?:'' }}"
                            container=".F_form"
                        />
                        <x-forms.text-input
                            type="hidden"
                            name="crm"
                            value="crm"
                        />

                        <div class="text_input r_right">

                            <x-forms.trick-button class="button_normal pick_tour_js">
                                {{__('Отправить заявку')}}
                            </x-forms.trick-button>
                        </div>
                    </div><!--.alax_inputs-->


                </div><!--.new__temp_middle-->
            </div><!--.F_form__body-->

        </div>

    </div>
</div><!--.F_form-->


