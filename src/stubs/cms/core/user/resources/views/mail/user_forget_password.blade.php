@component('layout::mail.master')
    @slot('message')
        Hi {{$data->username}},
        <br>

        Please Verify your account For Password Change
        <br>
        @component('mail::button', ['url' => route('verify_forget_password_from_mail',$data->remember_token)])
            Click Here To Verify
        @endcomponent
    @endslot
@endcomponent