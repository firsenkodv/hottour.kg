{{-- Карточки материалов плиткой с изображениями (TeaserTemplate::Img).
     Прежний partial/publs_img.blade.php. --}}

<div class="hrow">
@foreach($publs as $item)
    <div class="hcol">
        <div class="pc_tree">
            <a href="{{ asset($top_category.'/'. $category->slug).'/'.  $item->slug  }}">
               @if($item->img)
                <img class="pc_category_img" width="280" height="200"
                     src="{{ asset(intervention('280x200', $item->img, 'dumps')) }}"
                     alt="{{$item->title}}">
                @else
                    <div
                        style="
                            width: 280px;
                            height: 200px;
                            background-size: 70%;
                            background-color: #EF533F;
                            background-position: 38px 30px;
                            border-radius: 12px;
                            background-repeat: no-repeat;
                            background-image: url('{{ asset('images/inline/html-modals-gr-1.svg') }}');"
                         ></div>
                @endif
            <h3>{{$item->title}}</h3>
            <div class="hcolNoImg__smalltext colorGrey">
                {!! $item->smalltext !!}
            </div>
            </a>
        </div>
    </div>
@endforeach
{{ $publs->withQueryString()->links('pagination::default') }}
</div>
