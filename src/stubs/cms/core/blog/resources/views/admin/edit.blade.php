@extends('layout::admin.master')

@section('title','user')
@section('style')


@endsection
@section('body')
    <div class="x_content">

        @if($layout == "create")
            {{ Form::open(array('role' => 'form', 'route'=>array('blog.store'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'blog-form','novalidate' => 'novalidate')) }}
        @elseif($layout == "edit")
            {{ Form::open(array('role' => 'form', 'route'=>array('blog.update',$data->id), 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'id' => 'blog-form','novalidate' => 'novalidate')) }}
        @endif
            <div class="box-header with-border mar-bottom20">
                {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => 'submit_cat' , 'value' => 'Edit_Product' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}

                <a class="btn btn-default btn-sm pull-right btn-right-spacing" href="{{route('user.index')}}" ><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back</a>

                {{ Form::button('<i class="glyphicon glyphicon-refresh"></i>&nbsp;&nbsp;&nbsp;Clear', ['type' => 'reset','class' => 'mybuttn btn btn-sm btn-dafault pull-right btn-right-spacing']) }}
            </div>

            <span class="section">Blog Info</span>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Blog Category <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="category" class="form-control" required>
                        @php
                            recurse($category,0,@$data->category_id)
                        @endphp
                    </select>

                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('title',@$data->title,array('id'=>"title",'class'=>"form-control col-md-7 col-xs-12" ,
                    'data-validate-length-range'=>"6",'placeholder'=>"e.g Story",'required'=>"required"))}}
                </div>
            </div>

            <div class="item form-group">
                <label for="thumbnail" class="control-label col-md-3 col-sm-3 col-xs-12">Blog Image</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="input-group-btn">
                        @include('layout::widget.image',['name'=>'image','id'=>'image','value'=>@$data->image])
                    </span>
                </div>
            </div>

            <div class="ln_solid"></div>

                <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Author
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {{Form::text('author',@$data->author,array('id'=>"title",'class'=>"form-control col-md-7 col-xs-12" ,
                    'placeholder'=>"both name(s) e.g Jon Doe"))}}
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
                    <label class="control-label col-sm-2 col-xs-12" for="number">Blog Content <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        @include('layout::widget.editor',['name'=>'contents','value'=>@$data->content])
                    </div>
                </div>
            </div>

            <img id="holder" style="margin-top:15px;max-height:100px;">
       {{Form::close()}}
    </div>
    @php
    /*
    * private build option
    */
    function recurse($arr, $level = 0,$selected=''){
        # we have a numerically-indexed array. go through each item:
        foreach ($arr as $n) {
            # print out the item ID and the item name
            echo '<option '.(($selected==$n['id']) ? "selected=selected" : "").' value="' . $n['id'] . '">'
                . str_repeat("-", $level)
                . $n['name']
                . '</option>'. PHP_EOL;
            # if item['children'] is set, we have a nested data structure, so
            # call recurse on it.
            if (isset($n['child'])) {
                # we have children: RECURSE!!
                recurse( $n['child'], $level+1,$selected);
            }
        }
    }
    @endphp
@endsection

@section('script')
<!-- validator -->
{!! Cms::script("theme/vendors/validator/validator.js") !!}
@endsection