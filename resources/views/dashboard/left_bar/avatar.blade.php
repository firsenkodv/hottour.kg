    <x-forms.form-multipart

        action="{{ route('uploadAvatar') }}"
        method="POST"
        enctype="multipart/form-data"
    >
    <div class="image-upload__cabinet image-upload__flex">
        <label for="upload_user_ava">
            <div class="site_avatar" style="background-image: url('@if($user->avatar) {{ Storage::disk('user')->url($user->avatar) }} @else {{ asset('images/inline/dashboard-left-bar-avatar-1.svg') }} @endif '); width: 100px; height: 100px"></div>
            </label>
        <input type="file" name="upload_f" id="upload_user_ava" class="upload_f">
    </div>
    </x-forms.form-multipart>

<div id="result">
    <!-- Результат из upload.php -->
</div>





