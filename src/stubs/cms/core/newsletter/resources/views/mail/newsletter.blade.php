@component('layout::mail.master')
    @slot('style')
        <style>
        .subscription-div
        {
            font-size: 10px;
            border-top: 1px solid #c5c5c5;
        }
        </style>
    @endslot
    @slot('message')
        {!! $data !!}
        <div class="subscription-div">
        You have subscribed to <a href="{{url('/')}}"><b>{!! isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' !!}</b></a>
            If you don't want to receive our latest news,click <a href="{{url('/remove-subscriber?address='.md5($mail[0]['address']))}}">unsubscribe</a>
        </div>
    @endslot
@endcomponent