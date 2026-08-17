@auth()
    @props([
     'redirect' => '',
     'action' => '',
     'method' => 'POST',
     'id' => '',
     'delete' => 'Удалить',
     'text' => 'Удаление Статьи. Вы уверены?',
])
    <form class="delete_survey_form"
        action="{{ $action }}"
        method="{{ $method }}"
        onSubmit="return confirm('{{$text}}') "
    >
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="redirect" value="{{$redirect}}">
        <button class="delete_survey_form__button" type="submit" >{{ $delete }}</button>
    </form>

@endauth
