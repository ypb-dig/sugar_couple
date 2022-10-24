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
                                    <div class="alert alert-success">
                                        PARABÉNS! Seu cadastro foi concluído. Cheque seu e-mail e caixa de lixo eletrônico para responder o e-mail de validação.
                                    </div>
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

    </body>
    @push('appScripts')
    
    @endpush
    <!-- include footer -->
    @include('includes.footer')
    <!-- /include footer -->
</html>