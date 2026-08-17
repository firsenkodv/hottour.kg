{{-- Вывод хлебных крошек (diglactic/laravel-breadcrumbs).
     Разметка та же, что была у прежнего компонента x-breadcrumb.breadcrumb:
     ссылками идут все звенья кроме последнего, последнее — текстом.
     Цепочки описаны в routes/breadcrumbs.php --}}
<div class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
        @if (! is_null($breadcrumb->url) && ! $loop->last)
            <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
        @else
            <li><span>{{ $breadcrumb->title }}</span></li>
        @endif
    @endforeach
</div>
