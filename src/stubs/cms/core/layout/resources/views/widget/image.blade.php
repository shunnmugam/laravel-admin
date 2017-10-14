<input id="thumbnail-{{$id}}" class="form-control {{@$class_name}}" type="text" name="{{$name}}" style="width: 75%;float: left" value="{{@$value}}">
<a data-input="thumbnail-{{$id}}" data-preview="holder-{{$id}}" class="btn btn-primary lfm {{@$class_name}}" style="width: 25%">
    <i class="fa fa-picture-o"></i> Choose
</a>
<img id="holder-{{$id}}" style="margin-top:15px;max-height:100px;">
@section('script')
    {{Cms::script('theme/vendors/laravel-filemanager/js/lfm.js')}}

    <script>
        $('.lfm').filemanager('image');
    </script>
@append