@section('page-title', __tr('Forgot Your Password?'))
@section('head-title', __tr('Forgot Your Password?'))
@section('keywordName', strip_tags(__tr('Forgot Your Password?')))
@section('keyword', strip_tags(__tr('Forgot Your Password?')))
@section('description', strip_tags(__tr('Forgot Your Password?')))
@section('keywordDescription', strip_tags(__tr('Forgot Your Password?')))
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
    @if(false)
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
								<div class="p-5 lw-success-message">
									<!-- heading -->
									<div class="text-center">
										<a href="<?= url(''); ?>">
											<img class="lw-logo-img" src="/imgs/logotipo-quero-p.png" alt="Quero Meu Daddy">
										</a>
										<hr class="mt-4 mb-4">
										<h4 class="text-gray-200 mb-4"><?= __tr('Forgot Your Password?') ?></h4>
										<p class="mb-4"><?=  __tr( "We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!" )  ?></p>
									</div>
									<!-- / heading -->
									<!-- forgot password form form -->
									<form class="user lw-ajax-form lw-form" method="post" action="<?= route('user.forgot_password.process') ?>">
										<!-- email input field -->
										<div class="form-group">
											<input type="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp" placeholder="<?= __tr( 'Enter Email Address...' ) ?>" required>
										</div>
										<!-- / email input field -->

										<!-- Reset Password button -->
										<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block">
											<?=  __tr( 'Recuperar senha' )  ?>
										</button>
										<!-- Reset Password button -->
									</form>
									<!-- forgot password form form -->
									<hr>
									<!-- account and login page link -->
									<div class="text-center">
										<a class="small" href="<?= route('user.sign_up') ?>"><?=  __tr( 'Create an Account!' )  ?></a>
									</div>
									<div class="text-center">
										<a class="small" href="<?= route('user.login') ?>"><?=  __tr( 'Already have an account? Login!' )  ?></a>
									</div>
									<!-- / account and login page link -->
								</div>
							</div>
						</div>
						<!-- / Nested Row within Card Body -->
					</div>
				</div>
			</div>
		</div>
		<!-- / Outer Row -->
	</div>
</body>
@include('includes.footer')