@component('layout::mail.master')
    @slot('message')
       You have subscribed to <a href="{{url('/')}}"><b>{!! isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' !!}</b></a>
        <br>If you don't want to receive our latest news,unsubscribe below
        @component('mail::button', ['url' => url('/remove-subscriber?address='.md5($mail[0]['address'])),'color'=>'red'])
            Un subscribe
        @endcomponent
    @endslot
@endcomponent