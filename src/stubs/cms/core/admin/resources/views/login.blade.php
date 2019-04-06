<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' }} | Administrator </title>

    <!-- Bootstrap -->
    {!!Cms::style('theme/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
    <!-- Font Awesome -->
    {!!Cms::style('theme/vendors/font-awesome/css/font-awesome.min.css')!!}
    <!-- NProgress -->
    {!!Cms::style('theme/vendors/nprogress/nprogress.css')!!}
    <!-- iCheck -->
    {!!Cms::style('theme/vendors/iCheck/skins/flat/green.css')!!}


    <!-- bootstrap-progressbar -->
    {!!Cms::style('theme/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')!!}
    <!-- bootstrap-daterangepicker -->
    {!!Cms::style('theme/vendors/bootstrap-daterangepicker/daterangepicker.css')!!}

    <!-- Custom Theme Style -->
    {!!Cms::style('theme/build/css/custom.min.css')!!}
    <!-- Animate.css -->
    {!!Cms::style('theme/vendors/animate.css/animate.min.css')!!}


</head>

<body class="login">
@include('layout::site.notifications')
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                {{ Form::open(array('url'=>route('dobackendlogin'),'method' => 'post')) }}
                    <h1>Login Form</h1>
                    <div>
                        {!! Form::text('username', Cookie::get('admin_username'), array('id'=>'username','class' => 'form-control input-fields-input','required' => 'required','placeholder'=>'Username')) !!}
                    </div>
                    <div>
                        {!! Form::password('password', array('id'=>'password','class' => 'form-control input-fields-input','required' => 'required','placeholder'=>'Password')) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('remember', '1', Cookie::get('admin_username') ? true : false, array('id'=>'remember')) !!}
                        <label for="remember"><span></span>Remember Me</label>
                        {!! Form::submit('Sign In', ['class' => 'btn btn-default submit']) !!}
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i>{{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' }}</h1>
                            <p>©2016 All Rights Reserved. {{isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' }}</p>
                        </div>
                    </div>
                {{Form::close()}}
            </section>
        </div>

    </div>
</div>
</body>
</html>
