@if(!User::getUser())
{{Cms::style('theme/vendors/LRpopup/css/foxholder-styles.css')}}
{{Cms::style('theme/vendors/LRpopup/css/stylefm.css')}}

{{Cms::script('theme/vendors/LRpopup/js/main.js')}}
{{Cms::script('theme/vendors/LRpopup/js/foxholder.js')}}
{{Cms::script('theme/vendors/LRpopup/js/jquery.form.min.js')}}

<p class="col-lg-6 login_s"><a class="cd-signin" href="">Login</a></p>
<p class="col-lg-6 reg_s"><a class="cd-signup" href="">Register</a></p>

<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
    <div class="cd-user-modal-container"> <!-- this is the container wrapper -->
        <ul class="cd-switcher">
            <li><a href="#0">Sign in</a></li>
            <li><a href="#0">New account</a></li>
        </ul>

        <div id="cd-login"> <!-- log in form -->

            {{ Form::open(array('role' => 'form', 'route'=>array('do_ajax_login'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form cd-form form-horizontal form-label-left', 'id' => 'login-form','novalidate' => 'novalidate')) }}

            <p class="fieldset">
                    <label class="image-replace cd-username" for="login-username">Username</label>
                    <input class="full-width has-padding has-border" id="login-username" name="username" type="text" placeholder="User Name">
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-username" for="login-password">Username</label>
                    <input class="full-width has-padding has-border" id="login-password" name="password" type="password"  placeholder="Password">
                    <a href="#0" for="#login-password" class="hide-password">Hide</a>
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="remember-me">
                    <label for="remember-me">Remember me</label>
                </p>

                <p class="fieldset">
                    <input class="full-width ajax-submit" type="submit" id="login-submit" value="Login">
                </p>
           {{Form::close()}}

            <p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
            <!-- <a href="#0" class="cd-close-form">Close</a> -->
        </div> <!-- cd-login -->

        <div id="cd-signup"> <!-- sign up form -->
            {{ Form::open(array('role' => 'form', 'route'=>array('do_ajax_register'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form cd-form form-horizontal form-label-left', 'id' => 'registration-form','novalidate' => 'novalidate')) }}
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
                    <input class="full-width has-padding ajax-submit" type="submit" id="register-submit" value="Create account">
                </p>
            {{Form::close()}}

            <a href="#0" class="cd-close-form">Close</a>
        </div> <!-- cd-signup -->

        <div id="cd-reset-password"> <!-- reset password form -->
            <p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

            {{ Form::open(array('role' => 'form', 'route'=>array('forget_password'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form cd-form form-horizontal form-label-left', 'id' => 'forget-form','novalidate' => 'novalidate')) }}
            <p class="fieldset">
                    <label class="image-replace cd-email" for="reset-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail" name="email">
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding ajax-submit" type="submit" value="Reset password" >
                </p>
           {{Form::close()}}

            <p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
        </div> <!-- cd-reset-password -->
        <a href="#0" class="cd-close-form">Close</a>
    </div> <!-- cd-user-modal-container -->
</div>	<!-- cd-user-modal -->


<script>
$(document).ready(function(){
   $('.cd-user-modal').foxholder({
        demo: 15
    });

    /*************** Form Submit ******************/
    $(document).on('click','.ajax-submit',function(e) {
        var error = 0;
        var form = $(this).parents('form');
        $(this).parents('form').find('input').each(function() {
            if($(this).val()=='') {
                $(this).toggleClass('has-error').next('span').toggleClass('is-visible');
                error = 1;
                return false;
            }
        })

        var options = {
            target:        $(this).find('.message') ,  // target element(s) to be updated with server response
            error : formError,
           // beforeSubmit:  showRequest,  // pre-submit callback
            success:       formSuccess,  // post-submit callback

            // other available options:
            //url:       url,
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type)
            //clearForm: true        // clear all form fields after successful submit
            //resetForm: true        // reset the form after successful submit

            // $.ajax options can be used here too, for example:
            //timeout:   3000
        };

        if(error==0)
            $(form).ajaxSubmit(options);
    });

    function formError(json) {
        var response =  JSON.parse(json.responseText)
        $.each(response,function(i,v){
            alert(v);
        })
    }
    function formSuccess(json) {
        var response =  json
        alert(response.message);
        if(json.status==1 && response.url)
        window.location.href = response.url;
    }
})
</script>

@else
    <p class="col-lg-12 login_s">
        @if(User::getUser()->images)
            {!! Html::image(User::getUser()->images,'image',['class'=>"profile_img_plg"]) !!}
         @endif
        <a href="{{route('my_account')}}">({{User::getUser()->username}})</a><a class="" href="{{route('logout')}}">Logout</a>
    </p>

@endif


    <style>
        .profile_img_plg {
            width: 20px;
            border-radius: 50px;
            height: 20px;
        }
    </style>
