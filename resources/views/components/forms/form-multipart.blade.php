    @props([

   'action' => '',
   'method' => 'post',
   'buttons' => '',
   'enctype' => ''
])


    <div class="blockForm">

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
    </div><!--.blockForm-->
