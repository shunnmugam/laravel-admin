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
                    @include('layout::widget.editor',['name'=>'page_content','value'=>@$data->page_content])   
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