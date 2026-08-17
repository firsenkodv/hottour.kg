@props([
   'title' => '',
   'subtitle' => '',
   'action' => '',
   'method' => 'post',
   'buttons' => '',
])


        <form class="form"
              action="{{ $action }}"
              method="{{ $method }}"
        >
            @csrf
            {{ $slot  }}

            {{ $buttons  }}
        </form>
