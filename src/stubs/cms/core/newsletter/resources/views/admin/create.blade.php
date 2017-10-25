@extends('layout::admin.master')

@section('title','user')
@section('style')


@endsection
@section('body')
    <div class="x_content">

            {{ Form::open(array('role' => 'form', 'route'=>array('newsletter_send_mail_from_admin'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'blog-form','novalidate' => 'novalidate')) }}

        <div class="box-header with-border mar-bottom20">
            {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Send', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_cat' , 'value' => 'Edit_Product' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

            <a class="btn btn-default btn-sm pull-right btn-right-spacing" href="{{route('subscriber.index')}}" ><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back</a>

            {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
        </div>

        <span class="section">News Letter</span>
        <div class="col-xs-12">

            <div class="item form-group">
                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="name">Content <span class="required">*</span>
                </label>
                <div class="col-md-11 col-sm-1 col-xs-12">
                    @include('layout::widget.editor',['name'=>'contents'])
                </div>
            </div>


        </div>


        {{Form::close()}}
    </div>
@endsection