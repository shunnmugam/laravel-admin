@extends('layout::admin.master')

@section('style')

@endsection

@section('body')
    @php
    $is_super_admin = (User::isSuperAdmin()!=false) ? true : false;
    @endphp
    <div id="admin-role-page">

        <div class="col-xs-12 col-sm-3">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs-left">
                @foreach($groups as $group)
                    <li class="{{($loop->iteration == 1) ? 'active' : ''}}"><a href="#group-{{str_replace(' ','',$group->group)}}" data-toggle="tab">{{$group->group}}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-xs-12 col-sm-9">
            {{ Form::open(array('role' => 'form', 'route'=>array('do_menu_assign_from_admin'), 'method' => 'post', 'class' => 'form-horizontal form-label-left', 'id' => 'role-form')) }}
            {{ Form::button('<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save', array('type' => 'submit', 'id' => 'submit_btn', 'name' => '' , 'value' => 'role_save' , 'class' => 'mybuttn btn btn-sm btn-dafault pull-right')) }}
            <div class="tab-content">
                @foreach($groups as $group)
                    <div class="tab-pane {{($loop->iteration == 1) ? 'active' : ''}}" id="group-{{str_replace(' ','',$group->group)}}">
                        <div class="row">
                            @foreach($menus as $key => $values)
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <fieldset>
                                                <input type="hidden" id="role-hidden-{{$group->group.'-'.$values->id}}" name="role[{{$group->id}}][{{$values->id}}]" value="0" />
                                                {!! Form::checkbox('role['.$group->id.']['.$values->id.']', '1', (@$permission[$group->id][$values->id]==1 || $group->id==1) ? true : false, array('id'=>'role-'.$group->group.'-'.$values->id)) !!}
                                                <label for="role-{{$group->group.'-'.$values->id}}">{{$values->name}}</label> <br />
                                        </fieldset>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            {{Form::close()}}
        </div>

    </div>
@endsection