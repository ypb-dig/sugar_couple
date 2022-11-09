@section('page-title', __tr('Create an Account'))
@section('head-title', __tr('Create an Account'))
@section('keywordName', strip_tags(__tr('Create an Account!')))
@section('keyword', strip_tags(__tr('Create an Account!')))
@section('description', strip_tags(__tr('Create an Account!')))
@section('keywordDescription', strip_tags(__tr('Create an Account!')))
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
        <!-- container start -->
        <div class="container">
            <div class="row justify-content-center">
                            <!-- card -->
            <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6">
                <!-- card body -->
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <!-- /background image -->
                        <div class="col-lg-12 col-md-9">
                            <div class="p-5">
                                <!-- page heading -->
                                <div class="text-center">
                                    <a href="<?= url(''); ?>">
                                        <img class="lw-logo-img" src="/imgs/logotipo-quero-p.png" alt="<?= getStoreSettings('name') ?>">
                                    </a>
                                    <hr class="mt-4 mb-4">
                                    <h4 class="text-gray-200 mb-4"><?= __tr('Create an Account!') ?></h4>
                                </div>

                                <!-- /page heading -->
                                <form class="user lw-ajax-form lw-form" method="post" action="<?= route('user.sign_up.process') ?>" data-show-processing="true" data-secured="true" data-unsecured-fields="first_name,last_name" data-callback="onSignUpCallback">
                                    <div class="form-group row">
                                        <!-- First Name -->
                                        <div class="col-sm-6 mb-3 mb-sm-0 hide">
                                            <input type="text" class="form-control form-control-user" name="first_name" placeholder="<?= __tr('First Name') ?>" minlength="3">
                                        </div>
                                        <!-- /First Name -->

                                        <!-- Last Name -->
                                        <div class="col-sm-6 hide">
                                            <input type="text" class="form-control form-control-user" name="last_name" placeholder="<?= __tr('Last Name') ?>" minlength="3">
                                        </div>
                                        <!-- /Last Name -->
                                    </div>
                                    <div class="form-group row">
                                        <!-- Username -->
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" name="username" placeholder="<?= __tr('Username') ?>" data-toggle="tooltip" data-placement="top" title="Preencha com o nome de usuário desejado" required minlength="5">
                                        </div>
                                        <!-- /Username -->

                                        <!-- Mobile Number -->
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user phone_with_ddd" name="mobile_number" data-toggle="tooltip" data-placement="top" title="Preencha com um número de celular válido"  placeholder="<?= __tr('Mobile No') ?>" required>
                                        </div>
                                        <!-- /Mobile Number -->
                                    </div>
                                    <!-- Email Address -->
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="<?= __tr('Email válido') ?>" data-toggle="tooltip" data-placement="top" title="Preencha com o email válido"  required>
                                    </div>
                                    <!-- /Email Address -->
                                    <!-- Email Address Confirmation -->
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="repeat_email" placeholder="<?= __tr('Confirme seu email') ?>" data-toggle="tooltip" data-placement="top" title="Preencha novamente com seu email" onblur="matchEmail()" required>
                                        <label style="display: none" id="match_repeat_email-error" class="lw-validation-error" for="repeat_email">Os endereços de e-mail não coincidem.</label>
                                    </div>

                                    <script>
                                        function matchEmail(){
                                            var email = $('input[name="email"]').val();
                                            var n_email = $('input[name="repeat_email"]').val();
                                            console.log(email, n_email);
                                            if(email == n_email){
                                                $("#match_repeat_email-error").hide();
                                            } else {
                                                $("#match_repeat_email-error").show();
                                            }

                                        }
                                    </script>
                                    <!-- /Email Address Confirmation -->

                                    <!-- Selec Gender Fillter -->
                                    <div class="col-sm-12 mb-6 mb-sm-0" style="padding: 0px 0px 12px !important;">
                                        <select name="gender" class="select-gender-filter form-control form-control-user lw-user-gender-select-box" data-toggle="tooltip" data-placement="top" title="Escolha o que você é"  required>
                                            <option value="" selected disabled>Genêro</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Feminino">Feminino</option>
                                        </select>
                                    </div>
				                        <!-- /Gender -->
                                    <div class="form-group row">
                                        <!-- Gender -->
				                        <div class="col-sm-6 mb-3 mb-sm-0">
				                            <select name="gender" class="form-control form-control-user lw-user-gender-select-box" id="select_gender" data-toggle="tooltip" data-placement="top" title="Escolha o que você é"  required>
				                                <option value="" selected disabled><?= __tr('EU SOU') ?></option>
				                                @foreach($genders as $genderKey => $gender)
				                                    <option value="<?= $genderKey ?>"><?= $gender ?></option>
				                                @endforeach
				                            </select>
				                        </div>


                                        <!-- Confirm Password -->
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user date-mask" name="dob" placeholder="<?= __tr('Data de nascimento DD/MM/AAAA') ?>" data-toggle="tooltip" data-placement="top" title="Preencha com sua data de nascimento"  required="true" >
                                        </div>
                                        <!-- /Confirm Password -->
                                    </div>

                                    <div class="form-group row">
                                        <!-- Password -->
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="password" data-toggle="tooltip" data-placement="top" title="Crie sua senha"  placeholder="<?= __tr('Password') ?>" required minlength="6">
                                        </div>
                                        <!-- /Password -->

                                        <!-- Confirm Password -->
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" name="repeat_password" data-toggle="tooltip" data-placement="top" title="Repita sua senha criada"  placeholder="<?= __tr('Repeat Password') ?>" required minlength="6">
                                        </div>
                                        <!-- /Confirm Password -->
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
										    <input type="hidden" name="accepted_terms"> 
										    <input type="checkbox" class="form-check-input" id="acceptTerms" name="accepted_terms" value="1" required onclick="showTerms()"> 
										    <label class="form-check-label" for="acceptTerms">
										    	<?= __tr('I accept all ') ?>
										    	<a  href="javascript:showTerms();">
										    	<?= __tr('terms and conditions') ?></a>
										    </label>
									  	</div>
                                    </div>

                                    <div>
                                        <!-- Register Account Button -->
                                        <a href class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block">
                                            <?= __tr('Register Account') ?>
                                        </a>
                                        <!-- /Register Account Button -->
                                    </div>
                                    <hr>
                                    <!-- Register with Google Button -->
									@if(getStoreSettings('allow_google_login'))
                                    <a href="<?= route('social.user.login', [getSocialProviderKey('google')]) ?>" class="btn btn-google btn-user btn-block">
                                    	<i class="fab fa-google fa-fw"></i> <?= __tr('Register with Google') ?>
                                    </a>
									@endif
                                    <!-- /Register with Google Button -->

                                    <!-- Register with Facebook Button -->
									@if(getStoreSettings('allow_facebook_login'))
                                    <a href="<?= route('social.user.login', [getSocialProviderKey('facebook')]) ?>" class="btn btn-facebook btn-user btn-block">
                                    	<i class="fab fa-facebook-f fa-fw"></i> <?= __tr('Register with Facebook') ?>
									</a>
									@endif
                                    <!-- /Register with Facebook Button -->
                                </form>
								@if(getStoreSettings('allow_google_login') || getStoreSettings('allow_facebook_login'))
                                <hr>
								@endif
                                <div class="text-center">
                                    <!-- Forgot Password Link -->
                                    <a class="small" href="<?= route('user.forgot_password') ?>"><?= __tr('Forgot Password?') ?></a>
                                    <!-- /Forgot Password Link -->
                                </div>
                                <div class="text-center">
                                    <!-- Login Link -->
                                    <a class="small" href="<?= route('user.login') ?>"><?= __tr('Already have an account? Login!') ?></a>
                                    <!-- /Login Link -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Nested Row within Card Body -->
                </div>
                <!-- /card body -->
            </div>
            <!-- /card -->
            </div>
        </div>
        <!-- /container end -->

        <div class="terms-box">
            <i class="fa fa-times" onclick="hideTerms()"></i>
              <span class="title"> Termos e condições </span>
              <div class="terms">
                @include("includes.landing-terms")
                <div class="text-center">
                    <button class="btn btn-success" onclick="acceptTerms()"> Aceitar </button>
                    <button class="btn btn-danger" onclick="rejectTerms()"> Rejeitar </button>
                </div>
              </div>
        </div>
        <script>

            function showTerms(){
                $(".terms-box").show();
                $("#acceptTerms").prop("checked", false);
            }

            function hideTerms(){
                $(".terms-box").hide();
                $("#acceptTerms").prop("checked", false);
            }

            function acceptTerms(){
                $("#acceptTerms").prop("checked", true);
                $(".terms-box").hide();
            }

            function rejectTerms(){
                $("#acceptTerms").prop("checked", false);
                $(".terms-box").hide();
            }

            function ValidateGander(){
                var filterGender = document.querySelector('.select-gender-filter');
                var gender = document.querySelector('#select_gender');

                filterGender.addEventListener('change', function(){

                  if(filterGender.value == "Masculino"){

                    console.log("Sou macho");

                    gender.options[1].classList.remove("hide-filter");
                    gender.options[4].classList.remove("hide-filter")

                    gender.options[2].classList.add("hide-filter");
                    gender.options[3].classList.add("hide-filter");

                  }else if(filterGender.value == "Feminino"){
                    
                    console.log("Sou Fêmea");

                    gender.options[2].classList.remove("hide-filter");
                    gender.options[3].classList.remove("hide-filter")

                    gender.options[1].classList.add("hide-filter");
                    gender.options[4].classList.add("hide-filter");
                  }
                });
            }

            ValidateGander();

        </script>
        <style>
            .terms-box{
                display: none;
                background: #FFF;
                box-shadow: 0px 0px 0px 1px #DDD;
                max-width: 90vw;
                max-height: 90vh;
                width: 90vw;
                height: 400px;
                top: 20%;
                left: calc(50% - 90vw/2);
                border-radius: 10px;
                position: fixed;
                padding: 20px;
                text-align: justify;
                z-index: 1000;
            }

           .terms-box .title {
                font-size: 24px;
                display: block;
                position: relative;
                top: -40px;
                width: 90%;
            }

            .terms-box .terms {
                overflow-y: scroll;
                overflow-x: hidden;
                height: 90%;
                width: 100%;
                position: relative;
                top: -5%;
            }

           .terms-box > i {
                position: relative;
                top: -10px;
                left: 100%;
                color: #9e140e;
                cursor: pointer;
            }

            .lw-login-register-page input[type=email]{
              text-transform: lowercase;
            }

            .hide-filter{
                display: none;
            }

        </style>
    </body>
    @push('appScripts')
    <script>
    //on sign up success callback
    function onSignUpCallback(response) {
        //check reaction code is 1 and intended url is not empty
        if (response.reaction == 1) {
            //redirect to intendedUrl location
            window.location = "<?= route('user.sign_up_success') ?>";

            _.defer(function() {
                $('.lw-ajax-form').trigger("reset"); 
                $(".sucesso-cadastro").show();           
            })
        }
    }
    </script>
    @endpush
    <!-- include footer -->
    @include('includes.footer')
    <!-- /include footer -->
</html>