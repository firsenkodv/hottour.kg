<div class="__li {{ active_linkMenu(route('home')) }}"><a href="{{ route('home') }}">{{__('Главная')}}</a></div>
<div class="__li {{ active_linkMenu(asset(config('links.link.search')) , 'find') }} {{ active_linkMenu(asset(config('links.link.search_new')) , 'find') }} {{ active_linkMenu(asset(config('links.link.hotels')) , 'find') }}"><a href="{{ route('search_tours') }}">{{__('Поиск тура')}}</a></div>

<div class="__li m_click__js {{ active_linkMenu(asset(config('links.link.countries')), 'find') }}">
    <span class="aa">{{ __('Страны') }}</span> <span class="parent__st_after mactive @if(active_linkMenu(asset(config('links.link.countries')), 'find')) up @endif"></span>
</div>
<div class="__toggle m_down__js @if(active_linkMenu(asset(config('links.link.countries')), 'find')) display_block @else display_none @endif">
    @foreach($top_menu__left as $k => $menu)

        <div class="__li isset_flag {{ active_linkMenu(route('country', ['slug' => $menu['slug']]), 'find') }}">
            <img src="{{ Storage::url($menu['imgflag'])}}" width="28" height="18" alt="{{ $menu['title']  }}">
            <a href="{{ route('country', ['slug' => $menu['slug']]) }}" >{{ $menu['title']  }}</a></div>
    @endforeach

        @foreach($top_menu__right as $k => $menu)
        <div class="__li isset_flag {{ active_linkMenu(route('country', ['slug' => $menu['slug']]), 'find') }}">
            <img src="{{ Storage::url($menu['imgflag'])}}" width="28" height="18" alt="{{ $menu['title']  }}">
            <a href="{{ route('country', ['slug' => $menu['slug']]) }}" >{{ $menu['title']  }}</a></div>
    @endforeach
       <div class="__li __li_red"><a href="{{  route('countries') }}">{{ __('Смотреть все страны') }}</a></div>
</div>


<div class="__li m_click__js {{ active_linkMenu(asset(config('links.link.hottour')), 'find') }}">
    <div class="hot"></div>
    <span class="aa">
        {{ __('Горящие туры') }}</span> <span class="parent__st_after mactive @if(active_linkMenu(asset(config('links.link.hottour')), 'find')) up @endif"></span>
</div>

<div class="__toggle m_down__js @if(active_linkMenu(asset(config('links.link.hottour')), 'find')) display_block @else display_none @endif">
    @foreach($top_menuhottour as $k => $menu)
        <div class="__li  {{ active_linkMenu(route('hottour_category', ['slug_category' => $menu['slug']]), 'find') }}">
            <a href="{{ route('hottour_category', ['slug_category' => $menu['slug']]) }}" >{{ $menu['title']  }}</a></div>
@endforeach
</div>

<div class="__li m_click__js {{ active_linkMenu(asset(config('links.link.tours')), 'find') }}">
    <span class="aa">{{ __('Туры') }}</span> <span class="parent__st_after mactive @if(active_linkMenu(asset(config('links.link.tours')), 'find')) up @endif"></span>
</div>

<div class="__toggle m_down__js @if(active_linkMenu(asset(config('links.link.tours')), 'find')) display_block @else display_none @endif">
    @foreach($top_menutours as $k => $menu)
        <div class="__li  {{ active_linkMenu(route('tour', ['slug' => $menu['slug']]), 'find') }}">
            <a href="{{ route('tour', ['slug' => $menu['slug']]) }}" >{{ $menu['title']  }}</a></div>
    @endforeach
</div>

<div class="__li {{ active_linkMenu(asset('/cruises')) }}">
    <a  class=" {{ active_linkMenu(asset('/cruises')) }}"  href="{{asset('/cruises')}}">{{ __('Круизы') }}</a>
</div>

<div class="__li {{ active_linkMenu(route('certificates')) }}">
    <a href="{{ route('certificates') }}">{{ __('Сертификаты') }}</a>
</div>


<div class="__li m_click__js {{ active_linkMenu(asset(config('links.link.dump')), 'find') }}">
    <span class="aa">{{ __('Полезное') }}</span> <span class="parent__st_after mactive @if(active_linkMenu(asset(config('links.link.dump')), 'find')) up @endif"></span>
</div>

<div class="__toggle m_down__js @if(active_linkMenu(asset(config('links.link.dump')), 'find')) display_block @else display_none @endif">
    @foreach($top_menudumps as $k => $menu)
        <div class="__li  {{ active_linkMenu(route('dump', ['slug' => $menu['slug']]), 'find') }}">
            <a href="{{ route('dump', ['slug' => $menu['slug']]) }}" >{{ $menu['title']  }}</a></div>
    @endforeach
</div>


{{-- заголовок раздела — ссылка на /o-nas, подменю раскрывается стрелкой справа
     (клик по ссылке подменю не трогает, см. обработчик .m_click__js в mobile.js) --}}
<div class="__li m_click__js {{ active_linkMenu(asset(config('links.link.dump2')), 'find') }}">
    <a class="aa" href="{{ route('about') }}">{{ __('О нас') }}</a> <span class="parent__st_after mactive @if(active_linkMenu(asset(config('links.link.dump2')), 'find')) up @endif"></span>
</div>

<div class="__toggle m_down__js @if(active_linkMenu(asset(config('links.link.dump2')), 'find')) display_block @else display_none @endif">
    @foreach($top_menudump2s as $k => $menu)
        <div class="__li  {{ active_linkMenu(route('dump2', ['slug' => $menu['slug']]), 'find') }}">
            <a href="{{ route('dump2', ['slug' => $menu['slug']]) }}" >{{ $menu['title']  }}</a></div>
    @endforeach
</div>


<div class="__li {{ active_linkMenu(route('contacts')) }}">
    <a  href="{{route('contacts') }}">
        {{ __('Контакты') }}
    </a>
</div>


