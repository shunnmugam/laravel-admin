@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Laravel Cms'}}
        @endcomponent
    @endslot
    {{-- Body --}}
    {{$message}}
    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : 'Laravel Cms'}}.
        @endcomponent
    @endslot
@endcomponent