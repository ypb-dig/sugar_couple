<!-- Page Heading -->
<h3><?= __tr('User Settings') ?></h3>
<!-- /Page Heading -->
<hr>
<!-- User Setting Form -->
<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.configuration.write', ['pageType' => request()->pageType]) ?>">
	<!-- Activation Required For New User -->
    <div class="form-group mt-2">
		<!-- Activation required for new user -->
		<label><?= __tr('Activation required for new user') ?></label>
		<!-- /Activation required for new user -->
        <!-- Yes -->
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="activation_required_yes" name="activation_required_for_new_user" class="custom-control-input" value="1" <?= $configurationData['activation_required_for_new_user'] == true ? 'checked' : '' ?>>
            <label class="custom-control-label" for="activation_required_yes"><?= __tr('Yes') ?></label>
        </div>
        <!-- /Yes -->
        <!-- No -->
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="activation_required_no" name="activation_required_for_new_user" class="custom-control-input" value="0" <?= $configurationData['activation_required_for_new_user'] == false ? 'checked' : '' ?>>
            <label class="custom-control-label" for="activation_required_no"><?= __tr('No') ?></label>
        </div>
        <!-- /No -->
	</div>
	<!-- /Activation Required For New User -->

	<!-- Activation Required For Change Email -->
	<div class="form-group mt-2 mb-4">
		<!-- Activation required for change email -->
		<label><?= __tr('Activation required for change email') ?></label>
		<!-- /Activation required for change email -->
        <!-- Yes -->
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="activation_required_change_email_yes" name="activation_required_for_change_email" class="custom-control-input" value="1" <?= $configurationData['activation_required_for_change_email'] == true ? 'checked' : '' ?>>
            <label class="custom-control-label" for="activation_required_change_email_yes"><?= __tr('Yes') ?></label>
        </div>
        <!-- /Yes -->
        <!-- No -->
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="activation_required_change_email_no" name="activation_required_for_change_email" class="custom-control-input" value="0" <?= $configurationData['activation_required_for_change_email'] == false ? 'checked' : '' ?>>
            <label class="custom-control-label" for="activation_required_change_email_no"><?= __tr('No') ?></label>
        </div>
        <!-- /No -->
	</div>
	<!-- /Activation Required For Change Email -->

	<!-- Allocate Bonus Credit To User -->
	<div class="mb-4">
		<!-- Allocate Bonus Credits field -->
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="hidden" name="enable_bonus_credits" value="">
			<input type="checkbox" class="custom-control-input" id="lwEnableBonusCredits" name="enable_bonus_credits" value="1" <?= $configurationData['enable_bonus_credits'] == true ? 'checked' : '' ?>>
			<label class="custom-control-label" for="lwEnableBonusCredits"><?=  __tr( 'Allocate Bonus Credits' )  ?></label>
		</div>
		<!-- / Allocate Bonus Credits field -->

		<!-- Number of credits -->
		<div class="mt-3" id="lwNumberOfCredits">
			<label for="lwNumberOfCredits"><?= __tr('No. of Credits') ?></label>
			<input type="number" class="form-control form-control-user" value="<?= $configurationData['number_of_credits'] ?>" name="number_of_credits" id="lwNumberOfCredits">
		</div>
		<!-- / Number of credits -->
	</div>
	<!-- /Allocate Bonus Credit To User -->

	<div class="form-group row">
		<!-- Booster period -->
		<div class="col-sm-12 mb-3 mb-sm-0">
            <label for="termsAndConditionsUrl"><?= __tr('URL for Terms And Conditions') ?></label>
			<input type="text" name="terms_and_conditions_url" class="form-control form-control-user" id="termsAndConditionsUrl" required value="<?= $configurationData['terms_and_conditions_url'] ?>">
		</div>
		<!-- / Booster period -->
	</div>

	<!-- Number of credits -->
	<div class="form-group">
		<label for="lwUserPhotoRestriction"><?= __tr('User Photos Restriction') ?></label>
		<input type="number" class="form-control form-control-user" value="<?= $configurationData['user_photo_restriction'] ?>" name="user_photo_restriction" id="lwUserPhotoRestriction">
	</div>
	<!-- / Number of credits -->
	
    <!-- Update Button -->
    <a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile mt-2">
        <?= __tr('Update') ?>
    </a>
    <!-- /Update Button -->
</form>
<!-- /User Setting Form -->

@push('appScripts')
<script>
	$(document).ready(function() {
		var enableBonusCredits = '<?= $configurationData['enable_bonus_credits'] ?>';
		//check is false then disabled input price field
		if (!enableBonusCredits) {
			//hide number of credits input field
			$("#lwNumberOfCredits").hide();
		}

		// on change enable credits event
		$("#lwEnableBonusCredits").on('change', function() {
			enableBonusCredits = $(this).is(':checked');
			//check is enable true
			if (enableBonusCredits) {
				//show number of credits input field
				$("#lwNumberOfCredits").show();
			} else {
				//hide number of credits input field
				$("#lwNumberOfCredits").hide();
			}
		});
	});
</script>
@endpush