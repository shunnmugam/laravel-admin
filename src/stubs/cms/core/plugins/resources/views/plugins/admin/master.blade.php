@php
    $params = $data->params;
@endphp
@extends('layout::admin.master')

@section('title',$data->name.'|Plugins')
@section('style')
    {!! Cms::style("theme/vendors/switchery/dist/switchery.min.css") !!}
@endsection
@section('body')
    <div class="x_content">

    {{ Form::open(array('role' => 'form', 'route'=>array('plugin.update',$data->id), 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'user-form','novalidate' => 'novalidate')) }}

        <div class="box-header with-border mar-bottom20">
            {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_cat' , 'value' => 'Edit_Product' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

            <a class="btn btn-default btn-sm pull-right btn-right-spacing" href="{{route('plugin.index')}}" ><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back</a>

            {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
        </div>
        <h3>{{$data->name}}</h3>
        {{-- include plugin view --}}
        <div class="col-xs-12 col-sm-12 col-md-8">
        @include($data->adminview)
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::select('status',array("1"=>"Enable","0"=>"Disable"),$data->status ,
         array('id'=>'status','class' => 'form-control','required' => 'required' )) }}
            </div>
        </div>
        </div>

    {{Form::close()}}
    </div>
@endsection

@section('script')
    {!! Cms::script("theme/vendors/switchery/dist/switchery.min.js") !!}