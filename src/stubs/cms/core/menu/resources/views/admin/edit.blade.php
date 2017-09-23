@extends('layout::admin.master')

@section('title','user')
@section('style')
    {!!Cms::style('theme/vendors/select2/select2.css')!!}

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

            <span class="section">Menu Info</span>

            <div class="col-xs-12 col-sm-3">
                <!-- required for floating -->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tabs-left">
                    <li class="active"><a href="#menu" data-toggle="tab">Menu</a>
                    </li>
                    <li><a href="#menuitems" data-toggle="tab">Menu Items</a>
                    </li>

                </ul>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div class="tab-content">
                    <div class=" tab-pane active" id="menu">
                    <div class="col-xs-12">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Menu Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{Form::text('name',@$data->name,array('id'=>"name",'class'=>"form-control col-md-7 col-xs-12" ,
                                'data-validate-length-range'=>"6",'placeholder'=>"eg Top Menu",'required'=>"required"))}}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Who Can see?
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('group',$group,@$data->group[0]->group ,
                         array('id'=>'status','class' => 'form-control','multiple'=>'multipe')) }}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('status',array("1"=>"Enable","0"=>"Disable"),@$data->status ,
                         array('id'=>'status','class' => 'form-control','required' => 'required' )) }}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="thumbnail" class="control-label col-md-3 col-sm-3 col-xs-12">Select Url</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                        <span class="input-group-btn">
                            <input id="thumbnail" class="form-control" type="text" name="image" style="width: 75%;float: left">
                             <a id="url-choose" data-input="thumbnail" data-preview="holder" class="btn btn-primary"
                                data-toggle="modal" data-target=".bs-example-modal-lg"
                                style="width: 25%">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                        </span>

                            </div>
                        </div>


                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Select Url</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- start accordion -->
                                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel">
                                                <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <h4 class="panel-title">Pages</h4>
                                                </a>
                                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <h4 class="panel-title">Collapsible Group Items #2</h4>
                                                </a>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        <p><strong>Collapsible Item 2 data</strong>
                                                        </p>
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <h4 class="panel-title">Collapsible Group Items #3</h4>
                                                </a>
                                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="panel-body">
                                                        <p><strong>Collapsible Item 3 data</strong>
                                                        </p>
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end of accordion -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="ln_solid"></div>

                    </div>
                    </div>
                    <div class="tab-pane" id="menuitems">

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
            //menu popup
            $('#url-choose').on('click',function(){
                $.ajax({
                    url : '{{route("get_menu_url_from_admin")}}',
                    type : "GET",
                    success : function(json)
                    {

                    }

                })
            });
        });
    </script>
    @endsection