
<div class="cli_hot_user_Flex">
    <div class="cli_hot_user_left">
        <x-forms.form-multipart
            action="{{ route('uploadAvatarAdminUser') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            <div class="image-upload__cabinet ">

            <label for="upload_admin-user_ava">
                <div class="site_avatar" style="background-image: url('@if(isset($item->avatar)) {{ Storage::disk('user')->url($item->avatar) }} @else {{ asset('images/inline/dashboard-left-bar-avatar-1.svg') }} @endif '); width: 100px; height: 100px"></div>
            </label>
            <input type="file" name="upload_f" id="upload_admin-user_ava" class="upload_f_admin_to_user" />
            <input type="hidden" name="id" value="{{$item->id}}" />
            </div>
        </x-forms.form-multipart>
    </div><!--.cli_hot_user_left-->
    <div class="cli_hot_user_right">
        <div class="hot_user_username" data-user="{{ $item->id }}">{{ $item->name }}</div>
        <div class="hot_user_email">{{ $item->email }}</div>
        <div class="hot_user_phone">{{ ($item->phone)?format_phone($item->phone):'-' }}</div>
    </div><!--.cli_hot_user_right-->
</div>
