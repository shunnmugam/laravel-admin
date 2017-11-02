<input id="thumbnail" class="form-control" type="text" name="{{$name}}" style="width: 75%;float: left" value="{{@$value}}" >
<a data-input="thumbnail" data-preview="holder" class="btn btn-primary lfm" style="width: 25%">
    <i class="fa fa-picture-o"></i> Choose
</a>

@section('script')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('.lfm').filemanager('{{isset($type) ? $type : "image"}}');
</script>
@append