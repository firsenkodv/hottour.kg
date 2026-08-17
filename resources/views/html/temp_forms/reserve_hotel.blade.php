<div class="F_form  F_form_pick_tour" style="display: none" id="reserve_hotel" data-token="{{ csrf_token() }}" data-country="">
<x-forms.loader class="br_12"/>
    @include('html.modals.responce.responce')

    <div class="F_form__pick F_form__pick_reserve flex">
        <div class="F_form__pick_left__noImg w_50">
            <div class="F_form__body new__temp">
            <div class="new__temp_top">
                <div class="F_form__flex">
                    <div class="F_form__left hotel_name_js ">
                        <div class="F_country"></div>
                        <div class="F_h1 flex"><div class="m__hotel_name"></div><div class="m__hotel_stars"></div></div>
                        <div class="F_h2"><strong></strong></div>
                        <div class="F_scroll-block">
                        <div class="m__hotel_sity m__hotel_option">{{ __('Город вылета:') }} <strong></strong></div>
                        <div class="m__hotel_from m__hotel_option">{{ __('Дата вылета:') }} <strong></strong></div>
                        <div class="m__hotel_to m__hotel_option">{{ __('Дата прилета:') }} <strong></strong></div>
                        <div class="m__hotel_nights m__hotel_option">{{ __('Количество ночей:') }} <strong></strong></div>
                        <div class="m__hotel_adults m__hotel_option">{{ __('Взрослых:') }} <strong></strong></div>
                        <div class="m__hotel_childs m__hotel_option"><span></span> <strong></strong></div>
                        <div class="m__hotel_room m__hotel_option"><span></span> <strong></strong></div>
                            <div class="m__hotel_tourname m__hotel_option"><span></span> <strong></strong></div>
                            <div class="m__hotel_hotelregionname m__hotel_option"><span></span> <strong></strong></div>
                        </div>
                    </div>
                </div><!--.F_form__flex-->
            </div><!--.new__temp_top-->
            </div><!--.F_form__body new__temp-->
        </div>
        <div class="F_form__pick_right  w_50">
            <div class="F_form__body new__temp">

                <div class="new__temp_top">
                    <div class="F_form__flex">
                        <div class="F_form__left">
                            <div class="F_h1"><span>{{__('Забронировать тур')}}</span></div>
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

                        <x-forms.text-input
                            type="hidden"
                            name="crm"
                            value="crm"
                        />
                        <div class="text_input r_right">

                            <div class="m__hotel_price m__hotel_option"><strong></strong> <span class="__currency"></span></div>
                        </div>
                        <div class="text_input r_right">

                            <x-forms.trick-button class="button_normal send_order_tour_js">
                                {{__('Отправить заявку')}}
                            </x-forms.trick-button>
                        </div>
                    </div><!--.alax_inputs-->


                </div><!--.new__temp_middle-->
            </div><!--.F_form__body-->

        </div>

    </div>
</div><!--.F_form-->


