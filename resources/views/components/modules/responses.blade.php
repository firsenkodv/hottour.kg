{{-- Слайдер отзывов туристов (блок r_sw).
     Используется на главной и на лендинге «О нас» — данные подтягивает
     App\View\Composers\OtzMainComposer (отзывы = Company из категории
     Dump2 id=1), см. ViewServiceProvider.

     Тизер карточки (дата поездки, туристы, оценка) — поля trip_date /
     adults / rating модели Company, редактируются в админке:
     «Отзывы, О нас» → «Тизер отзыва». Пустые поля не выводятся. --}}

<div class="r_sw">
    <div class="r_sw__flex">

        <div class="r_sw__left">
            <div class="h2">{{__('Отзывы наших туристов')}}</div>
        </div>
        <div class="r_sw__right">
            <div class="r_sw__all">
                <a href="{{ asset(config('links.link.about').'/'.$main_category->slug) }}"><span class="posm">{{__('Посмотреть')}}</span> <span class="vse">{{__('все')}}</span> <span class="Nummm">{{ count($main_category->companies) }}</span></a>
            </div>
            <div class="r_nav">
                <button type="button" class="swiper-prev swiper-button-prev-swiper_responce click_slider_p__js"><span>‹</span></button>
                <button type="button" class="swiper-next swiper-button-next-swiper_responce click_slider_n__js"><span>›</span></button>
            </div>
        </div>

    </div>

    <div class="swiper swiper_responce">
    <div class="swiper-wrapper">
        @foreach($main_otz as $item)
            <div class="swiper-slide">
                <div class="responce_item">
                    <a href="{{ asset(config('links.link.about').'/'.$main_category->slug.'/'.$item->slug) }}" class="responce_item__link">
                        <div class="white_circle responce_item__circle">
                            <span class="white_circle__redplay"></span>
                        </div>


                        <img class="responce_item__img" alt="{{ $item->title }}" loading="lazy" src="{{ asset(intervention('290x200', $item->img, 'dumps')) }}" width="290" height="200">

                        @if($item->rating)
                            <span class="responce_item__rating">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#EF533F"><path d="M12 2l2.9 6.6 7.1.7-5.4 4.8 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.3l7.1-.7L12 2z"/></svg>
                                {{ number_format((float) $item->rating, 1) }}
                            </span>
                        @endif

                        <div class="responce_item__title">{{ $item->title }}</div>

                        @if($item->trip_date || $item->adults)
                            <div class="responce_item__meta">
                                @if($item->trip_date)
                                    <span class="responce_item__meta-row">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EF533F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                        {{ \Illuminate\Support\Str::ucfirst($item->trip_date->translatedFormat('F Y')) }}
                                    </span>
                                @endif
                                @if($item->adults)
                                    <span class="responce_item__meta-row">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EF533F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        {{ $item->adults }} {{ trans_choice('{1} взрослый|[2,*] взрослых', $item->adults) }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="responce_item__desc">{!!  $item->smalltext !!} </div>
                    </a>

                </div>

            </div>
        @endforeach


    </div>
</div>
</div>
