<div class="right_menu">
    <div class="MH3"><span>Страны</span></div>
    <ul class="nav menu mod-list">

    @foreach($country_menu as $country)
        <li class="{{ active_linkMenu(asset(route('countries') .'/'. $country['slug']), 'find') }} eee__2021  deeper parent parent__st">
            <a class="find__a" href="{{ asset(route('countries') .'/'. $country['slug'])  }}">
                <img src="{{ asset('storage/'.$country->imgflag) }}" width="28" height="18" loading="lazy" alt="{{ $country->title  }}">
                <span class="image-title">{{$country->title}}</span>
            </a>
            <ul class="nav-child nav_child_st unstyled small">
            @foreach($country->child as $country_child)
                <li class="{{ active_linkMenu(asset(route('countries') .'/'. $country['slug'].'/'.$country_child->slug)) }}  eee__2021_a item-{{$country_child->id}}">
                    <a href="{{ asset(route('countries') .'/'. $country['slug'].'/'.$country_child->slug)  }}">{{ $country_child->title }}</a>
                </li>
            @endforeach
            </ul>
            <span class="parent__st_after"></span>
        </li>
    @endforeach
    </ul>
</div>
