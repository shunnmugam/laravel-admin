<!-- PNotify -->
{!!Cms::style('theme/vendors/pnotify/dist/pnotify.css')!!}
{!!Cms::style('theme/vendors/pnotify/dist/pnotify.buttons.css')!!}
{!! Cms::script('theme/vendors/pnotify/dist/pnotify.js') !!}
{!! Cms::script('theme/vendors/pnotify/dist/pnotify.buttons.js') !!}

<!---------NOTIFICATIONS--------->
<script>
    $('document').ready(function() {
        function notify(title,text,type,hide) {
            new PNotify({
                title: title,
                text: text,
                type: type,
                hide: hide,
                styling: 'bootstrap3'
            })
        }
        @if(Session::has("success"))
            notify('Success','{{Session::get("success")}}','success',true);
        @endif
        @if(Session::has("error"))
            notify('Error','{{Session::get("error")}}','error',true);
        @endif
        @if(Session::has("info"))
            notify('Info','{{Session::get("info")}}','info',true);
        @endif

        @if(count((array) $errors) > 0)
        @foreach ($errors->all() as $error)
            notify('Error','{{$error}}','error',true);
        @endforeach
        @endif

    });
</script>