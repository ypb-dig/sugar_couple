<div class="p-3">
    <!-- login form -->
    <form class="user lw-ajax-form lw-form" data-callback="onLoginCallback" method="post" action="<?= route("user.login.process") ?>" data-show-processing="true" data-secured="true">
        <!-- email input field -->
        <div class="form-group">
            <input type="text" class="form-control form-control-user" name="email_or_username" aria-describedby="emailHelp" placeholder="<?= __tr( "Enter Email Address..." ) ?>" required/>
        </div>
        <!-- / email input field -->

        <!-- password input field -->
        <div class="form-group">
            <input type="password" class="form-control form-control-user" name="password" placeholder="<?= __tr( "Password" ) ?>" required minlength="6"/>
        </div>
        <!-- password input field -->

        <!-- login button -->
        <button class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block"><?= __tr('Login') ?></button>
        <!-- / login button -->
    </form>
    <!-- / login form -->
     <!-- forgot password button -->
    <div class="text-center mt-3">
        <a class="small" href="<?= route('user.forgot_password') ?>"><?=  __tr( 'Forgot Password?' )  ?></a>
    </div>
    <!-- / forgot password button -->
</div>

@push('appScripts')
<script>
//on login success callback
function onLoginCallback(response) {
    //check reaction code is 1 and intended url is not empty
    if (response.reaction == 1 && !_.isEmpty(response.data.intendedUrl)) {
        //redirect to intendedUrl location
        _.defer(function() {
            window.location.href = response.data.intendedUrl;
        })
    }
}
</script>
@endpush