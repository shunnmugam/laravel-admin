@extends('layout::site.master')

@section('sIte_tItle','Profile')
@section('addlinks')

    {{Cms::style('theme/vendors/LRpopup/css/foxholder-styles.css')}}
    {{Cms::style('theme/vendors/LRpopup/css/stylefm.css')}}

    {{Cms::script('theme/vendors/LRpopup/js/main.js')}}
    {{Cms::script('theme/vendors/LRpopup/js/foxholder.js')}}
    {{Cms::script('theme/vendors/LRpopup/js/jquery.form.min.js')}}

@endsection

@section('body')
<div id="my-account-page">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-2">
            Hi {{$data->username}}
        {{ Form::open(array('role' => 'form', 'route'=>array('update_account'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form cd-form form-horizontal form-label-left', 'id' => 'registration-form','novalidate' => 'novalidate')) }}
        <p class="message"></p>
        <p class="fieldset">
            <label class="image-replace cd-username" for="signup-username">Username</label>
            <input class="full-width has-padding has-border" id="signup-username" name="username" required type="text" placeholder="Username" value="{{$data->username}}">
            <span class="cd-error-message">User Name Wrong</span>
        </p>
        <p class="fieldset">
            <label class="image-replace cd-username" for="signup-username">Name</label>
            <input class="full-width has-padding has-border" id="signup-username" name="name" required type="text" placeholder="Name" value="{{$data->name}}">
            <span class="cd-error-message">User Name Wrong</span>
        </p>

        <p class="fieldset">
            <label class="image-replace cd-email" for="signup-email">E-mail</label>
            <input class="full-width has-padding has-border" id="signup-email" name="email" type="email" placeholder="E-mail" value="{{$data->email}}">
            <span class="cd-error-message">Wrong Email</span>
        </p>

        <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password">Password</label>
            <input class="full-width has-padding has-border" id="signup-password" name="password" type="password"  required placeholder="Password">
            <a href="#0" class="hide-password" for="#signup-password">Hide</a>
            <span class="cd-error-message">Wrong Password</span>
        </p>
        <p class="fieldset">
            <label class="image-replace cd-password" for="signup-password">Password</label>
            <input class="full-width has-padding has-border" id="signup-mobile" name="mobile" type="text"  placeholder="Mobile" value="{{$data->mobile}}">
            <span class="cd-error-message">Wrong Password</span>
        </p>
        <p class="fieldset">
            <label class="" for="signup-image">Profile Picture</label>
            <input class="" id="signup-image" name="image" type="file" >
            <span class="cd-error-message">Wrong Password</span>
        </p>

        <p class="fieldset">
            <input class="full-width has-padding form-submit" type="submit" id="register-submit" value="Update account">
        </p>
        {{Form::close()}}
        </div>
    </div>
</div>
@endsection