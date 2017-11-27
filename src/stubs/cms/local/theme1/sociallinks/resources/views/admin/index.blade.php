@extends('layout::admin.master')

@section('title','user')
@section('style')
    {!!Cms::style('theme/vendors/select2/select2.css')!!}

@endsection
@section('body')
    <div class="x_content">

        
            {{ Form::open(array('role' => 'form', 'url'=>array(url('/administrator/save-social-links')), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'user-form','novalidate' => 'novalidate')) }}
            <div class="box-header with-border mar-bottom20">
                {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_cat' , 'value' => 'save' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

                <a class="btn btn-default btn-sm pull-right btn-right-spacing" href="{{route('page.index')}}" ><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back</a>

                {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
            </div>

            <span class="section">Social networks</span>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Facebook url
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('social[facebook]',@$data['facebook'],array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                    'placeholder'=>"Facebook page url"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">twitter
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('social[twitter]',@$data['twitter'],array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12"
                    ,'placeholder'=>"Twitter id"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">linkedin
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('social[linkedin]',@$data['linkedin'],array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12"
                    ,'placeholder'=>"linkedin id"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">pinterest
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('social[pinterest]',@$data['pinterest'],array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12"
                    ,'placeholder'=>"pinterest id"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">instagram
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('social[instagram]',@$data['instagram'],array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12"
                    ,'placeholder'=>"instagram id"))}}
                </div>
            </div>

                

            </div>
            <img id="holder" style="margin-top:15px;max-height:100px;">
       {{Form::close()}}
    </div>

@endsection

@section('script')
    <!-- validator -->
    {!! Cms::script("theme/vendors/validator/validator.js") !!}
    {!!Cms::script('theme/vendors/select2/select2.min.js')!!}
    <script>
        $("documnt").ready(function() {
            $('select').select2();
        });
    </script>
    @endsection