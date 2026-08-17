{{-- Стандартный набор карточек внутри курортного направления.
     Каждый тип материала выводится своим партиалом — они лежат
     в pages/countries/partial/.

     $resorts / $excursions / $hotels / $infos — списки материалов --}}

@if(count($resorts))
    @include('pages.countries.partial.resorts')
@endif

@if(count($excursions))
    @include('pages.countries.partial.excursions')
@endif

@if(count($hotels))
    @include('pages.countries.partial.hotels')
@endif

@if(count($infos))
    @include('pages.countries.partial.infos')
@endif
