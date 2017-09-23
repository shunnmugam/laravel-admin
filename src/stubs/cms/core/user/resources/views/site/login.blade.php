@extends('layout::site.master')

@section('sIte_tItle','login')
@section('addlinks')

@endsection

@section('body')
    <div class="col-xs-12 col-sm-12 col-md-6 login-div">
        <div class="col-md-offset-4 col-lg-offset-4 col-md-8">
            <h2>Have an Account?</h2>
            {{ Form::open(array('role' => 'form', 'route'=>array('do_login'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form cd-form form-horizontal form-label-left', 'id' => 'login-form')) }}

            <p class="fieldset">
                <label class="image-replace cd-username" for="login-username">Username</label>
                <input class="full-width has-padding has-border" id="login-username" name="username" required type="text" placeholder="User Name">
                <span class="cd-error-message">Wrong Username</span>
            </p>

            <p class="fieldset">
                <label class="image-replace cd-username" for="login-password">Username</label>
                <input class="full-width has-padding has-border" id="login-password" name="password" required type="password"  placeholder="Password">
                <a href="#0" for="#login-password" class="hide-password">Hide</a>
                <span class="cd-error-message">Wrong Password</span>
            </p>

            <p class="fieldset">
                <input type="checkbox" id="remember-me">
                <label for="remember-me">Remember me</label>
            </p>

            <p class="fieldset">
                <input class="full-width form-submit" type="submit" value="Login">
            </p>
            {{Form::close()}}

            <p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 registration-div">

        <div class="col-md-offset-right-4 col-lg-offset-right-4 col-md-8">
        <h2>Create New Account</h2>
        {{ Form::open(array('role' => 'form', 'route'=>array('do_register'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form cd-form form-horizontal form-label-left', 'id' => 'registration-form','novalidate' => 'novalidate')) }}
        <p class="message"></p>
        <p class="fieldset">
            <label class="image-replace cd-username" for="signup-username">Username</label>
            <input class="full-width has-padding has-border" id="signup-username" name="username" required type="text" placeholder="Username">
            <span class="cd-error-message">User Name Wrong</span>
        </p>

        <p class="fieldset">
            <label class="image-replace cd-email" for="signup-email">E-mail</label>
            <input class="full-width has-padding has-border" id="signup-email" name="email" type="email" placeholder="E-mail">
            <span class="cd-error-message">Wrong Email</span>
        </p>

        <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password">Password</label>
            <input class="full-width has-padding has-border" id="signup-password" name="password" type="text"  required placeholder="Password">
            <a href="#0" class="hide-password" for="#signup-password">Hide</a>
            <span class="cd-error-message">Wrong Password</span>
        </p>

        <p class="fieldset">

            <label for="accept-terms">I agree to the <a href="#0">Terms and conditions</a></label>
        </p>

        <p class="fieldset">
            <input class="full-width has-padding form-submit" type="submit" id="register-submit" value="Create account">
        </p>
        {{Form::close()}}
        </div>
    </div>

@endsection