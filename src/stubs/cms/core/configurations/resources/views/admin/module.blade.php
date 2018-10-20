@extends('layout::admin.master')

@section('title','configuration')
@section('style')
    {!! Cms::style("theme/vendors/switchery/dist/switchery.min.css") !!}
    {!!Cms::style('theme/vendors/select2/select2.css')!!}
    <style>
        #module-side-menu > li {
            margin-bottom: 10px;
        }
        #module-side-menu > li.active a {
            color:#1abb9c;
        }
        #module-side-menu a {
            font-size: 15px;
            text-transform: capitalize;
        }
        #side-menu-div {
            border-right: 1px solid;
        }
    </style>
@endsection
@section('body')
    <div class="col-xs-12 col-sm-4 col-md-3" id="side-menu-div ">
        <ul id="module-side-menu">
        @foreach($module_list as $modules)
                <li class="{{($data->id==$modules->id) ? 'active' : ''}}"><a href="{{url('/administrator/configurations/module/'.$modules->id)}}">{{$modules->name }} ({{ $modules->type==1 ? 'core' : 'local' }})</a></li>
        @endforeach
        </ul>
    </div>
    <div class="col-sm-12 col-md-9">
    <h3>{{strtoupper($data->name." Module Configurations")}}</h3>

    {{ Form::open(array('role' => 'form', 'route'=>array('admin_module_configuration_save'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'module-form','novalidate' => 'novalidate')) }}

    {{Form::hidden('module_id',$data->id)}}

    <div class="box-header with-border mar-bottom20">
        {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit' , 'value' => 'module_submit' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}


        {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
    </div>
    <div class="module-data col-xs-12">
        @includeIf($data->configuration_view,['data'=>$data,'datas'=>$datas])
    </div>
    {{Form::close()}}
    </div>
@endsection

@section('script')
    {!!Cms::script('theme/vendors/select2/select2.min.js')!!}
    {!! Cms::script("theme/vendors/switchery/dist/switchery.min.js") !!}
    <script>
        $("documnt").ready(function() {
            $('select').select2();
        });
    </script>
@endsection
