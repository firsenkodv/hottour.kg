@props([
   'title' => '',
   'subtitle' => '',
   'action' => '',
   'method' => 'post',
   'buttons' => '',
   'enctype' => ''
])

        <form class="form"
              action="{{ $action }}"
              method="{{ $method }}"
              {{ ($enctype)?'enctype='.$enctype : '' }}
        >
            @csrf
            @honeypot
            {{ $slot  }}

            {{ $buttons  }}
        </form>

