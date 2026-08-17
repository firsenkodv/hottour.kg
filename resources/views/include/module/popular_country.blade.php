<div class="pc_vid">
    <div class="pc_vid__block">
        <h3>{{__('Популярные страны')}}</h3>
        <div class="pc_vid__desc">
            <p>
                Мы подобрали свыше 30-ти наиболее посещаемых стран, курортов, на которые вам стоит обратить своё
                внимание и, может быть, вы решите поехать в одну из них. На ваш выбор есть множество различных
                направлений путевок: экскурсионные, лечебные, горнолыжные, а также спокойные для отдыха с семьей, либо в
                уединении для молодоженов.
            </p>
        </div>

    </div>

    <div class="pc_vid__wrapper">
        <div class="pc_items">
            @foreach($main_countries as $country)
            <div class="pc_item">
                <div class="pc_item__flex">

                    <div class="pc_item__left">
                        <a href="{{ asset(config('links.link.countries').'/'.$country->slug) }}">
                            <img class="pc_category_img" width="422" height="262"
                                 src="{{ asset('storage/'. $country->img)}}"
                                 alt="{{$country->title}}">
                            <img class="pc_category_flag"
                                 src="{{ asset('storage/'. $country->imgflag)}}" width="30"
                                 height="20" loading="lazy" alt="{{__('Flag')}}">
                            <h4>{{$country->title}}</h4>
                        </a>
                    </div>

                    <div class="pc_item__right pc_super_flexDirection">

                        <div class="pc_super_flexDirection__top">
                            <div class="pc_links flex">

                                {{-- child уже загружена с сортировкой в HotCategoryQueryBuilder::get_countries_for_main() --}}
                                @foreach($country->child as $subcategory )

                                <div class="sub_m_index sub_m1">
                                    <a href="{{ asset(config('links.link.countries').'/'.$country->slug) . '/'.$subcategory->slug }}"><span>{{ $subcategory->title_for_menu  }}</span></a>
                                </div>
                                @endforeach
                            </div>
                            <div class="w_100 desc pc_category__desc">
                            {!!  $country->smalltext!!}
                            </div>
                        </div><!--.pc_super_flexDirection__top-->
                        <div class="pc_super_flexDirection__bottom">
                            <div class="w_100 flex pc_c pc_category__buttons">
                                <div class="pc_c__left">
                                    <a href="#pick_tour" data-country="{{ $country->title }}" data-fancybox class="pick_tour_button_js button button_normal">{{ __('Подобрать тур') }}</a>
                                </div>
                                <div class="pc_c__right">
                                    <a href="{{ asset(config('links.link.countries').'/'.$country->slug) }}">{{ __('Подробнее') }} <span>→</span></a>

                                </div>

                            </div>
                        </div><!--.pc_super_flexDirection__botom-->

                    </div><!--.pc_item__right-->
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
