@extends('layout::admin.master')

@section('title','site configuration')
@section('style')
    {!! Cms::style("theme/vendors/switchery/dist/switchery.min.css") !!}
    {!!Cms::style('theme/vendors/select2/select2.css')!!}
@endsection
@section('body')
    <div id="site-configurations">
        {{ Form::open(array('role' => 'form', 'route'=>array('admin_site_configuration_save'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'module-form','novalidate' => 'novalidate')) }}
        <div class="box-header with-border mar-bottom20">
            {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_btn' , 'value' => 'save' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

           {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Site Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('site_name',@$data->site_name,array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length-range'=>"6",'placeholder'=>"site name ",'required'=>"required"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Site Online <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::hidden('site_online',0)}}
                    {{ Form::checkbox('site_online',1,(@$data->site_online==1) ? true : false, array('class' => 'js-switch', )) }}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Site Logo <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="input-group-btn">
                        <input id="thumbnail" class="form-control" type="text" name="site_logo" style="width: 75%;float: left" value="{{(@$data->site_logo) ? $data->site_logo : ''}}">
                         <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="width: 25%">
                           <i class="fa fa-picture-o"></i> Choose
                         </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <h3>Theme Details</h3>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Theme<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::select('active_theme',$themes,@$data->active_theme,['class'=>'form-control'])}}
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
@endsection

@section('script')
    {!!Cms::script('theme/vendors/select2/select2.min.js')!!}
    {!! Cms::script("theme/vendors/switchery/dist/switchery.min.js") !!}
    <!-- validator -->
    {!! Cms::script("theme/vendors/validator/validator.js") !!}
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $("documnt").ready(function() {
            $('select').select2();
            $('#lfm').filemanager('image');
        });
    </script>
@endsection
