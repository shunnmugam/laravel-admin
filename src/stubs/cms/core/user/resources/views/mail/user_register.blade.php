@component('layout::mail.master')
    @slot('message')
        Hi {{$data->username}},
        <br>
        Welcome to {{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Laravel Cms'}}
        <br>
        Please Verify your account
        <br>
        @component('mail::button', ['url' => route('user_activate_from_mail',$data->remember_token)])
            Click Here To Verify
        @endcomponent
    @endslot
@endcomponent