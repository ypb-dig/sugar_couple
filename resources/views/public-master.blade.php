<!-- include header -->
@include('includes.header')
<!-- /include header -->
<body id="page-top" class="lw-page-bg lw-public-master">
    <div class="public-topbar">
        <div class="logo">
            <a class="sidebar-brand d-flex align-items-center bg-dark" href="<?= url('/home') ?>">
                <div class="sidebar-brand-icon">
                    <img class="lw-logo-img" src="/imgs/logotipo-quero-p.png" alt="{{ getStoreSettings('name') }}">
                </div>
                <img class="lw-logo-img d-sm-none d-none d-md-block" src="/imgs/logotipo-quero-p.png"
                        alt="{{ getStoreSettings('name') }}">
                <img class="lw-logo-img d-sm-block d-md-none" src="/imgs/logotipo-quero-p.png" alt="{{ getStoreSettings('name') }}">
            </a>
        </div>
        <div class="topbar">
            <!-- include top bar -->
            @if(isLoggedIn())
            @include('includes.public-top-bar')
            @endif
            <!-- /include top bar -->
        </div>
    </div>
    <!-- Page Wrapper -->
    <div id="wrapper" class="container-fluid">
        <!-- include sidebar -->
        @if(isLoggedIn())
        @include('includes.public-sidebar')
        @endif
        <!-- /include sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column lw-page-bg">
            <div id="content">
                <!-- include top bar -->
                @if(isLoggedIn()  && 1 == 2)
                @include('includes.public-top-bar')
                @endif
                <!-- /include top bar -->

                <!-- Begin Page Content -->
                <div class="lw-page-content">
                    <!-- header advertisement -->
                    @if(!getFeatureSettings('no_adds') and getStoreSettings('header_advertisement')['status'] == 'true')
                    <div class="lw-ad-block-h90">
                        <?= getStoreSettings('header_advertisement')['content'] ?>
                    </div>
                    @endif
                    <!-- /header advertisement -->
                    @if(isset($pageRequested))
                    <?php echo $pageRequested; ?>
                    @endif
                    <!-- footer advertisement -->
                    @if(!getFeatureSettings('no_adds') and getStoreSettings('footer_advertisement')['status'] == 'true')
                    <div class="lw-ad-block-h90">
                        <?= getStoreSettings('footer_advertisement')['content'] ?>
                    </div>
                    @endif
                    <!-- /footer advertisement -->
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

	<div class="lw-cookie-policy-container row p-4" id="lwCookiePolicyContainer">
		<div class="col-sm-11">
            @include('includes.cookie-policy')
        </div>
		<div class="col-sm-1 mt-2"><button id="lwCookiePolicyButton" class="btn btn-primary"><?= __tr('OK') ?></button></div>
	</div>
    <!-- include footer -->
    @include('includes.landing-footer')
    <!-- /include footer -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- /Scroll to Top Button-->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= __tr('Ready to Leave?') ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= __tr('Select "Logout" below if you are ready to end your current session.') ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __tr('Not now') ?></button>
                    <a class="btn btn-primary" href="<?= route('user.logout') ?>"><?= __tr('Logout') ?></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Logout Modal-->
</body>
</html>