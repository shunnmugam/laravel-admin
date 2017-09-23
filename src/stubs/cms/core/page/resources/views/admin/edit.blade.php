@extends('layout::admin.master')

@section('title','user')
@section('style')
    {!!Cms::style('theme/vendors/select2/select2.css')!!}

@endsection
@section('body')
    <div class="x_content">

        @if($layout == "create")
            {{ Form::open(array('role' => 'form', 'route'=>array('page.store'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'user-form','novalidate' => 'novalidate')) }}
        @elseif($layout == "edit")
            {{ Form::open(array('role' => 'form', 'route'=>array('page.update',$data->id), 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'user-form','novalidate' => 'novalidate')) }}
        @endif
            <div class="box-header with-border mar-bottom20">
                {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_cat' , 'value' => 'Edit_Product' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

                <a class="btn btn-default btn-sm pull-right btn-right-spacing" href="{{route('page.index')}}" ><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back</a>

                {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
            </div>

            <span class="section">Page Info</span>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Page Title <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('title',@$data->title,array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length-range'=>"6",'placeholder'=>"Page Title",'required'=>"required"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Page Url<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('url',@$data->url,array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length-range'=>"6",'placeholder'=>"Page url e.g about us",'required'=>"required"))}}
                </div>
            </div>

                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Who Can View?<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{Form::select('can[]',$group,@explode(',',$data->can),array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                        'data-validate-length-range'=>"6",'multiple'=>"multiple",))}}
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {{ Form::select('status',array("1"=>"Enable","0"=>"Disable"),@$data->status ,
                 array('id'=>'status','class' => 'form-control','required' => 'required' )) }}
                    </div>
                </div>

            </div>
            <div class="col-xs-12">
            <div class="item form-group">
                <label class="control-label col-sm-2 col-xs-12" for="number">Page Content <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea required="required" name="page_content" class="form-control my-editor">{!! old('content', @$data->page_content) !!}</textarea>
                </div>
            </div>
            </div>

            <img id="holder" style="margin-top:15px;max-height:100px;">
       {{Form::close()}}
    </div>

@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        var editor_config = {
            path_absolute : "/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    <!-- validator -->
    {!! Cms::script("theme/vendors/validator/validator.js") !!}
    {!!Cms::script('theme/vendors/select2/select2.min.js')!!}
    <script>
        $("documnt").ready(function() {
            $('select').select2();
        });
    </script>
    @endsection