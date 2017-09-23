@extends('layout::site.master')

@section('sIte_tItle','login')
@section('addlinks')

@endsection

@section('body')
    <div class="col-xs-12 col-sm-12 col-md-6 login-div">
        <div class="col-md-offset-4 col-lg-offset-4 col-md-8">

            {{ Form::open(array('role' => 'form', 'route'=>array('do_change_password'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'cd-form form-horizontal form-label-left', 'id' => 'password-change-form')) }}

            {{Form::hidden('token',$token)}}
            <p class="fieldset">
                <label class="image-replace cd-username" for="login-password">Password</label>
                <input class="full-width has-padding has-border" id="login-password" name="password" required type="password"  placeholder="Password">
                <a href="#0" for="#login-password" class="hide-password">Hide</a>
                <span class="cd-error-message">Wrong Password</span>
            </p>

            <p class="fieldset">
                <label class="image-replace cd-username" for="login-password">Re Enter Password</label>
                <input class="full-width has-padding has-border" id="login-password" name="re-enter-password" required type="password"  placeholder="Password">
                <a href="#0" for="#login-password" class="hide-password">Hide</a>
                <span class="cd-error-message">Wrong Password</span>
            </p>

            <p class="fieldset">
                <input class="full-width" type="submit" value="Login">
            </p>
            {{Form::close()}}

            <p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
        </div>
    </div>

@endsection