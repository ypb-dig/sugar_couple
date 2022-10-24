<!-- include header -->
@include('includes.header')
<!-- /include header -->

<body id="page-top lw-admin-section" class="lw-admin-section">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- include sidebar -->
        @if(isLoggedIn())
            @include('includes.sidebar')
        @endif
        <!-- /include sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- include top bar -->
                @if(isLoggedIn())
                    @include('includes.top-bar')
                @endif
                <!-- /include top bar -->

                <!-- Begin Page Content -->
                <div class="container-fluid_">
                    @if(isset($pageRequested))
                        <?php echo $pageRequested; ?>
                    @endif
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- include footer -->
    @include('includes.footer')
    <!-- /include footer -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- /Scroll to Top Button-->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __tr('Cancel') ?></button>
                    <a class="btn btn-primary" href="<?= route('user.logout') ?>"><?= __tr('Logout') ?></a>
                </div>
            </div>
        </div>
    </div> 
    <!-- /Logout Modal-->
</body>
