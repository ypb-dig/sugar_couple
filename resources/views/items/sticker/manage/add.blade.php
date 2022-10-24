 <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?=  __tr( 'Add Sticker' )  ?></h1>
	<!-- back button -->
	<a class="btn btn-light btn-sm" href="<?= route('manage.item.sticker.view') ?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to Stickers') ?>
	</a>
	<!-- /back button -->
</div>
 <!-- Start of Page Wrapper -->
 <div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body">
 				<!-- page add form -->
				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.item.sticker.write.add') ?>">
					<!-- add sticker image -->
					<div class="row">
                        <div class="col-lg-6">
                            <input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('media.sticker.upload_temp_media') ?>" data-remove-media="true" data-callback="afterUploadedFile" data-allow-image-preview="false" data-allowed-media='<?= getMediaRestriction('sticker') ?>'>
                            <input type="hidden" name="sticker_image" class="lw-uploaded-file" value="">
                        </div>
                        <div class="col-lg-6" style="display: none" id="lwStickerImagePreview">
                            <img class="lw-sticker-preview-image lw-uploaded-preview-img" src="">
                        </div>
                    </div>
 					<!-- add sticker image -->

					<!-- title input field -->
					<div class="form-group">
						<label for="lwTitle"><?= __tr('Title') ?></label>
						<input type="text" class="form-control" name="title" id="lwTitle" required minlength="3">
					</div>
					<!-- / title input field -->

					<div class="form-group row">
 						<!-- normal price field -->
 						<div class="col-sm-6 mb-3 mb-sm-0">
 							<label for="lwNormalPrice"><?= __tr('Normal Price') ?></label>
							<div class="input-group">
								<input type="number" class="form-control" name="normal_price" id="lwNormalPrice" required min="0" digits="true">
								<div class="input-group-append">
									<span class="input-group-text"><?= __tr('Credits') ?></span>
								</div>
							</div>
						</div>
						<!-- / normal price field -->

						<!-- premium price field -->
						<div class="col-sm-6 mb-3 mb-sm-0">
 							<label for="lwPremiumPrice"><?= __tr('Premium Price') ?></label>
							<div class="input-group">
								<input type="number" class="form-control" name="premium_price" id="lwPremiumPrice" required min="0" digits="true">
								<div class="input-group-append">
									<span class="input-group-text"><?= __tr('Credits') ?></span>
								</div>
							</div>
						</div>
						<!-- / premium price field -->
					</div>

                    <!-- Is for premium user only -->
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="isForPremiumUserOnly" name="is_for_premium_user">
						<label class="custom-control-label" for="isForPremiumUserOnly"><?=  __tr( 'Is for premium user only' )  ?></label>
					</div>
					<!-- /Is for premium user only -->

					<!-- status field -->
					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="statusCheck" name="status">
						<label class="custom-control-label" for="statusCheck"><?=  __tr( 'Active' )  ?></label>
					</div>
					<!-- / status field -->
					<br><br>
					
					<!-- add button -->
					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?=  __tr( 'Add' )  ?></button>
					<!-- / add button -->
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
		$("#lwStickerImagePreview").show();
        $('.lw-sticker-preview-image').attr('src', responseData.data.path);
    }
}
// Check if only for premium user checkbox clicked
$('#isForPremiumUserOnly').on('click', function() {
    if ($(this).is(":checked")) {
        $('#lwNormalPrice').val('');
        $('#lwNormalPrice').attr('disabled', true);
    } else {
        $('#lwNormalPrice').attr('disabled', false);
    }
});
</script>
@endpush