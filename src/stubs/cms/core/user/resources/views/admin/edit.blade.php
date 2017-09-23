@extends('layout::admin.master')

@section('title','user')
@section('style')


@endsection
@section('body')
    <div class="x_content">

        @if($layout == "create")
            {{ Form::open(array('role' => 'form', 'route'=>array('user.store'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'user-form','novalidate' => 'novalidate')) }}
        @elseif($layout == "edit")
            {{ Form::open(array('role' => 'form', 'route'=>array('user.update',$data->id), 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'user-form','novalidate' => 'novalidate')) }}
        @endif
            <div class="box-header with-border mar-bottom20">
                {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_cat' , 'value' => 'Edit_Product' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

                <a class="btn btn-default btn-sm pull-right btn-right-spacing" href="{{route('user.index')}}" ><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back</a>

                {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
            </div>

            <span class="section">Personal Info</span>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">User Group <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{ Form::select('group',$group,@$data->group[0]->id ,
             array('id'=>'status','class' => 'form-control','required' => 'required' )) }}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('name',@$data->name,array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length-range'=>"6",'placeholder'=>"both name(s) e.g Jon Doe",'required'=>"required"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('username',@$data->username,array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length-range'=>"6",'placeholder'=>"User name",'required'=>"required"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::email('email',@$data->email,array('id'=>"email",'class'=>"form-control col-md-7 col-xs-12",
                    'placeholder'=>"Email",'required'=>"required"))}}
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Number <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::number('mobile',@$data->mobile,array('id'=>"number",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length'=>"9,15",'placeholder'=>"Mobile Number",'required'=>"required"))}}
                </div>
            </div>
            <div class="item form-group">
                <label for="password" class="control-label col-md-3">Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::password('password',array('id'=>"password",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length'=>"6,8",'placeholder'=>"Password"))}}
                </div>
            </div>
            <div class="item form-group">
                <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Repeat Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::password('password2',array('id'=>"password2",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length'=>"6,8",'placeholder'=>"Password"))}}
                </div>
            </div>

                <div class="item form-group">
                    <label for="thumbnail" class="control-label col-md-3 col-sm-3 col-xs-12">Profile Image</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <span class="input-group-btn">
                            <input id="thumbnail" class="form-control" type="text" name="image" style="width: 75%;float: left">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="width: 25%">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                        </span>

                    </div>
                </div>


            <div class="ln_solid"></div>

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

            <img id="holder" style="margin-top:15px;max-height:100px;">
       {{Form::close()}}
    </div>

@endsection

@section('script')

    <!-- validator -->
    {!! Cms::script("theme/vendors/validator/validator.js") !!}
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
    @endsection
