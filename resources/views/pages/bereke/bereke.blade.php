@extends('layouts.layout')
<x-seo.meta
    title="bereke"
    description="bereke"
    keywords="bereke"
/>
@section('content')
    <main class="page_site background_f7f7f7">

        <div class="block countries height_100">
            <div class="page_site__flex height_100">
                <div class="page_site__left">
                    <div class="hbox temp_img">
                        <div class="hbox__top pad_b1">
                            {{ Breadcrumbs::render(Route::currentRouteName()) }}

                            <h1>Тестовая оплата</h1>
                        </div>

                    </div>
                    <!--bereke-->
                    <div class="form">
                        <x-forms.form

                            action="{{ route('customAmount') }}"
                            method="GET"
                        >

                            <div class="text_input">
                                <x-forms.text-input_fromLabel
                                    type="number"
                                    id="registerAmount"
                                    name="amount"
                                    placeholder="Сумма"
                                    value=""
                                    class="input amount"
                                />
                                <x-forms.error class="error_amount"/>

                            </div>
                            <div class="slotButtons slotButtons__right pad_t15">
                                <div class=" text_input w_30">
                                    <x-forms.primary-button>
                                        {{ __('Оплатить') }}
                                    </x-forms.primary-button>
                                </div>
                            </div>

                        </x-forms.form>


                    </div>
                </div>
                <div class="page_site__right">

                </div>
            </div>
        </div>
    </main>

@endsection
