{{-- Карточки горящих туров плиткой с изображениями.
     $items — пагинированный список Travelitem, $category — их категория --}}

<div class="hrow">
    @foreach($items as $item)

        <div class="hcol hcol_category2 ">
            <div class="pc_category2 pc_category">
                <a href="{{ asset(config('links.link.hottour').'/'.$category->slug.'/'. $item->slug) }}">
                    <img class="pc_category_img" width="430" height="230" loading="lazy"
                         src="{{ asset(intervention('430x230', $item->img, 'travels')) }}"
                         alt="{{$item->title}}">
                </a>
                <div class="pc_category2__desc">
                    <h2>{{$item->title}}</h2>
                    <div class="pc_c2__desc">
                        {!!  $item->smalltext !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{ $items->withQueryString()->links('pagination::default') }}


</div>
