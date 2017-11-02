<div class="item form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">Allow User Registration<span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        {{Form::hidden('allow_user_registration',0)}}
        {{ Form::checkbox('allow_user_registration',1,(@$data->configuration_parm->allow_user_registration==1) ? true : false, array('class' => 'js-switch', )) }}

    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">Allow User Login<span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        {{Form::hidden('allow_user_login',0)}}
        {{ Form::checkbox('allow_user_login',1,(@$data->configuration_parm->allow_user_login==1) ? true : false, array('class' => 'js-switch', )) }}

    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">New User Register Group<span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        {{ Form::select('new_user_group',$datas['user_group'],@$data->configuration_parm->new_user_group,array('id'=>'status','class' => 'form-control','required' => 'required' )) }}
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">Login Regirection Url
    </label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        {{ Form::text('login_redirection_url',@$data->configuration_parm->login_redirection_url,array('id'=>'login_redirection_url','class' => 'form-control' )) }}
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">Logout Regirection Url
    </label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        {{ Form::text('logout_redirection_url',@$data->configuration_parm->logout_redirection_url,array('id'=>'logout_redirection_url','class' => 'form-control' )) }}
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="status">Verification
    </label>
    <div class="col-md-3 col-sm-3 col-xs-12">
        {{ Form::select('register_verification',[0=>'None',1=>'Self',2=>'Administrator'],@$data->configuration_parm->register_verification,array('id'=>'logout_redirection_url','class' => 'form-control' )) }}
    </div>
</div>