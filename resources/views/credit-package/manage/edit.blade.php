 <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?=  __tr( 'Edit Credit Package' )  ?></h1>
	<!-- back button -->
	<a class="btn btn-light btn-sm" href="<?= route('manage.credit_package.read.list') ?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to Credit Packages') ?>
	</a>
	<!-- /back button -->
</div>
 <!-- Start of Page Wrapper -->
 <div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
 				<!-- page add form -->
                <form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.credit_package.write.edit', ['packageUId' => $packageEditData['_uid']]) ?>">

                    <div class="row">
                        <div class="col-lg-6">
                            <input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('media.package.upload_temp_media') ?>" data-remove-media="true" data-callback="afterUploadedFile" data-allow-image-preview="false" data-allowed-media='<?= getMediaRestriction('gift') ?>'>
                            <input type="hidden" name="package_image" class="lw-uploaded-file" value="">
                        </div>
                        <div class="col-lg-6" id="lwPackageImagePreview">
                            <img class="lw-gift-preview-image lw-uploaded-preview-img" src="<?= $packageEditData['packageImageUrl'] ?>">
                        </div>
                    </div>

					<!-- title input field -->
					<div class="form-group">
                        <label for="lwTitle"><?= __tr('Title') ?></label>
						<input type="text" value="<?= $packageEditData['title'] ?>" id="lwTitle" class="form-control" name="title" placeholder="<?=  __tr( 'Title' )  ?>" required minlength="3">
					</div>
					<!-- / title input field -->
 					<div class="form-group row">
						<!-- price field -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="lwPrice"><?= __tr('Price') ?></label>
							<input type="number" value="<?= $packageEditData['price'] ?>" id="lwPrice" class="form-control" name="price" required digits="true">
						</div>
						<!-- /price field -->
						
						<!-- credits field -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="lwPremiumPrice"><?= __tr('Credits') ?></label>
							<input type="number" value="<?= $packageEditData['credits'] ?>" id="lwPremiumPrice" class="form-control" name="credits" required digits="true">
						</div>
						<!-- / credits field -->
					</div>
					 
					<!-- status field -->
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="statusCheck" name="status" <?= $packageEditData['status'] == 1 ? 'checked' : '' ?>>
						<label class="custom-control-label" for="statusCheck"><?=  __tr( 'Active' )  ?></label>
					</div>
					<!-- / status field -->
					<br><br>
					<!-- Update button -->
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?=  __tr( 'Update' )  ?></button>
					<!-- / Update button -->
				</form>
				<!-- / page add form -->
			</div>
		</div>
	</div>
</div>
<!-- End of Page Wrapper -->
@push('appScripts')
<script>
function afterUploadedFile(responseData) {
    if (responseData.reaction == 1) {
        $('.lw-gift-preview-image').attr('src', responseData.data.path);
    }
}
</script>
@endpush