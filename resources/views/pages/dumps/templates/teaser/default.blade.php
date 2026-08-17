{{-- Карточки материалов списком, без изображений (TeaserTemplate::Default).
     Прежний partial/publs.blade.php. --}}

@foreach($publs as $item)
    <div class="hrow__block">

    <div class="hcol">
            <a href="{{ asset($top_category.'/'. $category->slug).'/'.  $item->slug  }}">
            <h3>{{$item->title}}</h3>
            <div class="hcolImgText__smalltext colorGrey">
                {!! $item->smalltext !!}
            </div>
            </a>
    </div>
    </div>
@endforeach
{{ $publs->withQueryString()->links('pagination::default') }}
