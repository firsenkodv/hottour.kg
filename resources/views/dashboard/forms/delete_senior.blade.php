  <div class="a_user__delete">
      <x-forms.form-delete
        action="{{ route('delete.senior') }}"
        method="POST"
        text="Снятите с поста РОП. Сам пользователь не удаляется! Вы уверены?"

      >
          <input type="hidden" class="" name="id" value="{{ $user->id }}" />
          <input type="submit" class="delete_user" value="x" />

    </x-forms.form-delete>
  </div>
