@section('page-title', __tr('Login'))
@section('head-title', __tr('Login'))
@section('keywordName', strip_tags(__tr('Login')))
@section('keyword', strip_tags(__tr('Login')))
@section('description', strip_tags(__tr('Login')))
@section('keywordDescription', strip_tags(__tr('Login')))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- include header -->
@include('includes.header')
<!-- /include header -->
<body class="lw-login-register-page">
    <!-- include navbar -->
    @include('includes.landing-navbar')
    <!-- /include navbar -->
    @if(1 == 2)
    <div class="lw-page-bg lw-lazy-img" data-src="<?= __yesset("imgs/home/*.jpg", false, [
        'random' => true
    ]) ?>"></div>
    @endif
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <a href="<?= url(''); ?>">
                                            <img class="lw-logo-img hide" src="/imgs/logotipo-quero-p.png" alt="<?= getStoreSettings('name') ?>">
                                        </a>
                                        <hr class="mt-4 mb-4">
                                        @if(session('hide_form') == true)

                                        @else
										<h4 class="text-gray-200 mb-4"><?=  __tr( 'Login to your account' )  ?></h4>
                                        @endif

                                            @if(session('success'))
                                                <div class="alert alert-success">
                                                    {!! session('message') !!}
                                                </div>
                                            @endif

                                            @if(session('error'))
                                                <div class="alert alert-danger">
                                                    <?= session('message') ?>
                                                </div>
                                            @endif

											@if(session('errorStatus'))
											<!--  success message when email sent  -->
											<div class="alert alert-danger alert-dismissible">
												<button type="button" class="close" data-dismiss="alert">&times;</button>
												<?= session('message') ?>
											</div>
											<!--  /success message when email sent  -->
											@endif
									</div>

                                    @if(session('hide_form') == true)


                                    @else
                                    <!-- login form -->
                                    <form class="user lw-ajax-form lw-form" data-callback="onLoginCallback" method="post" action="<?= route('user.login.process') ?>" data-show-processing="true" data-secured="true">
                                        <!-- email input field -->
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="email_or_username" aria-describedby="emailHelp" placeholder="<?= __tr( 'Enter Email Address...' ) ?>" required>
                                        </div>
                                        <!-- / email input field -->

                                        <!-- password input field -->
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="<?= __tr( 'Password' ) ?>" required minlength="6">
                                        </div>
                                        <!-- password input field -->

                                        <!-- remember me input field -->
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="rememberMeCheckbox" name="remember_me">
                                                <label class="custom-control-label text-gray-200" for="rememberMeCheckbox"><?=  __tr( 'Remember Me' )  ?></label>
                                            </div>
                                        </div>
                                        <!-- remember me input field -->

                                        <!-- login button -->
                                        <button type="submit" value="Login" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block"><?=  __tr( 'Login' )  ?></button>
                                        <!-- / login button -->
                                        <!-- social login links -->
                                        @if(getStoreSettings('allow_google_login'))
                                        <a href="<?= route('social.user.login', [getSocialProviderKey('google')]) ?>" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> <?=  __tr( 'Login with Google' )  ?>
                                        </a>
                                        @endif
                                        @if(getStoreSettings('allow_facebook_login'))
                                        <a href="<?= route('social.user.login', [getSocialProviderKey('facebook')]) ?>" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> <?=  __tr( 'Login with Facebook' )  ?>
                                        </a>
                                        @endif
                                        <!-- social login links -->
                                    </form>
                                    <!-- / login form -->
                                    <!-- forgot password button -->
                                    <div class="text-center mt-3">
                                        <a class="small" href="<?= route('user.forgot_password') ?>"><?=  __tr( 'Forgot Password?' )  ?></a>
                                    </div>
                                    <!-- / forgot password button -->
                                    <hr class="mt-4 mb-3">
                                    <!-- create account button -->
                                    <div class="text-center">
                                        <p><?= __tr("Don't have a Account Create New Its Free!!") ?></p>
                                        <a class="btn btn-golden-border" href="<?= route('user.sign_up') ?>"><span><?=  __tr( 'Create an Account!' )  ?></span></a>
                                    </div>
                                    @endif
                                    <!-- / create account button -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
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
    <!-- include footer -->
    @include('includes.footer')
    <!-- /include footer -->