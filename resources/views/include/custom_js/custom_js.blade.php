@if(isset($jss))
    @foreach($jss as $js)

        {!! $js->js !!}

    @endforeach

@endif
