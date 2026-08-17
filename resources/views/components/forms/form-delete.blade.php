@props([
   'action' => '',
   'method' => 'post',
   'buttons' => '',
   'text' => 'Удаление. Вы уверены?',
])


    <div class="blockForm">
        <form class="form"
              action="{{ $action }}"
              method="{{ $method }}"
              onSubmit="return confirm('{{$text}}')"

        >
            @csrf
            {{ $slot  }}

            {{ $buttons  }}
        </form>
    </div><!--.blockForm-->
