<!-- Page Heading -->
<h3><?= __tr('Integration Settings') ?></h3>
<!-- /Page Heading -->
<hr>
<!-- pusher Setting Form -->
<form class="lw-ajax-form lw-form" method="post" data-callback="onIntegrationSettingCallback" action="<?= route('manage.configuration.write', ['pageType' => request()->pageType]) ?>">
	<!-- Pusher Block Start-->
	<div class="form-group mt-2">
		<!-- pusher settings -->
		<fieldset class="lw-fieldset mb-3">
			<!-- PUSHER SETTING DATA -->
			<!-- allow pusher input radio field -->
			<legend class="lw-fieldset-legend">
				<!-- enable pusher hidden field -->
				<input type="hidden" name="allow_pusher" id="lwEnablePusher" value="0"/>
				<!-- enable pusher hidden field -->
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="lwAllowPusher" <?= $configurationData['allow_pusher'] == true ? 'checked' : '' ?> name="allow_pusher" value="1">
					<label class="custom-control-label" for="lwAllowPusher"><?= __tr('Allow Pusher') ?></label>
				</div>
			</legend>
			<!-- /allow pusher input radio field -->

			<!-- Pusher Link button -->
            <a href="https://pusher.com/" target="_blank" type="button" class="float-right btn btn-light lw-btn btn-sm rounded" title="Details"><i class="fa fa-info"></i></a><br>
            <!-- / Pusher Link button -->

			<!-- show after pusher allow information -->
			<div class="btn-group" id="lwIsPusherKeysExist"  style="display:none">
				<button type="button" disabled="true" class="btn btn-success lw-btn"><?= __tr('Pusher keys are installed.') ?></button>
				<button type="button" class="btn btn-light lw-btn" id="lwAddPusherKeys"><?= __tr('Update') ?></button>
			</div>
			<!-- show after pusher allow information -->

			<!-- pusher key exists hidden field -->
			<input type="hidden" name="pusher_keys_exist" id="lwPusherKeysExist" value="<?= $configurationData['pusher_app_id'] ?>"/>
			<!-- pusher key exists hidden field -->

			<div id="lwPusherInputField">
				<!-- Pusher App ID Key -->
				<div class="mb-3">
                    <label for="lwPusherAppId"><?= __tr('Pusher App ID') ?></label>
					<input type="text" class="form-control form-control-user" name="pusher_app_id" placeholder="<?= __tr('Add Your Pusher App ID') ?>" id="lwPusherAppId">
				</div>
				<!-- / Pusher App ID Key -->

				<!-- Pusher App key -->
				<div class="mb-3">
                    <label for="lwPusherAppKey"><?= __tr('Pusher App Key') ?></label>
					<input type="text" class="form-control form-control-user" name="pusher_app_key" placeholder="<?= __tr('Add Your Pusher App Key') ?>" id="lwPusherAppKey">
				</div>
				<!-- / Pusher App key -->

				<!-- Pusher App Secret -->
				<div class="mb-3">
                    <label for="lwPusherAppSecret"><?= __tr('Pusher App Secret') ?></label>
					<input type="text" class="form-control form-control-user" name="pusher_app_secret" placeholder="<?= __tr('Add Your Pusher App Secret') ?>" id="lwPusherAppSecret">
				</div>
				<!-- / Pusher App Secret -->

				<!-- Pusher App Cluster key -->
				<div class="mb-3">
                    <label for="lwPusherAppClusterKey"><?= __tr('Pusher App Cluster Key') ?></label>
					<input type="text" class="form-control form-control-user" name="pusher_app_cluster_key" placeholder="<?= __tr('Add Your Pusher App Cluster Key') ?>" id="lwPusherAppClusterKey">
				</div>
				<!-- / Pusher App Cluster key -->
			</div>
			<!-- /PUSHER SETTING DATA -->

			<!-- AGORA SETTING DATA -->
			<fieldset class="lw-fieldset mb-3 mt-4">
				<!-- allow agora input radio field -->
				<legend class="lw-fieldset-legend">
					<!-- enable agora hidden field -->
					<input type="hidden" name="allow_agora" id="lwEnableAgora" value="0"/>
					<!-- enable agora hidden field -->
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="lwAllowAgora" <?= $configurationData['allow_agora'] == true ? 'checked' : '' ?> name="allow_agora" value="1">
						<label class="custom-control-label" for="lwAllowAgora"><?= __tr('Allow Agora ( Audio / Video Call )') ?></label>
					</div>
				</legend>
				<!-- /allow agora input radio field -->

				<!-- Agora Link button -->
				<a href="https://www.agora.io/en/" target="_blank" type="button" class="float-right btn btn-light lw-btn btn-sm rounded" title="Details"><i class="fa fa-info"></i></a><br>
				<!-- / Agora Link button -->

				<!-- show after agora allow information -->
				<div class="btn-group" id="lwIsAgoraKeysExist"  style="display:none">
					<button type="button" disabled="true" class="btn btn-success lw-btn"><?= __tr('Agora keys are installed.') ?></button>
					<button type="button" class="btn btn-light lw-btn" id="lwAddAgoraKeys"><?= __tr('Update') ?></button>
				</div>
				<!-- show after agora allow information -->

				<!-- agora key exists hidden field -->
				<input type="hidden" name="agora_keys_exist" id="lwAgoraKeysExist" value="<?= $configurationData['agora_app_id'] ?>"/>
				<!-- agora key exists hidden field -->

				<!-- agora app id or app certificate key input field-->
				<div id="lwAgoraInputField">
					<!-- Agora App ID Key -->
					<div class="mb-3">
						<label for="lwAgoraAppId"><?= __tr('Agora App ID') ?></label>
						<input type="text" class="form-control form-control-user" name="agora_app_id" placeholder="<?= __tr('Add Your Agora App ID') ?>" id="lwAgoraAppId">
					</div>
					<!-- / Agora App ID Key -->

					<!-- Agora App Certificate Key -->
					<div class="mb-3">
						<label for="lwAgoraAppKey"><?= __tr('Agora App Certificate Key') ?></label>
						<input type="text" class="form-control form-control-user" name="agora_app_certificate_key" placeholder="<?= __tr('Add Your Agora App Certificate Key') ?>" id="lwAgoraAppKey">
					</div>
					<!-- / Agora App Certificate Key -->
				</div>
				<!-- /agora app id or app certificate key input field-->
			</fieldset>
			<!-- AGORA SETTING DATA -->
		</fieldset>
		<!-- /pusher settings -->
	</div>
	<!-- /Pusher Block End-->

	<!-- Google Map Block Start-->
	<div class="form-group mt-2">
		<!-- google map settings -->
		<fieldset class="lw-fieldset mb-3">
			<!-- allow google map input radio field -->
			<legend class="lw-fieldset-legend">
				<!-- enable google map hidden field -->
				<input type="hidden" name="allow_google_map" id="lwEnableGoogleMap" value="0"/>
				<!-- enable google map hidden field -->
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="lwAllowGoogleMap" <?= $configurationData['allow_google_map'] == true ? 'checked' : '' ?> name="allow_google_map" value="1">
					<label class="custom-control-label" for="lwAllowGoogleMap"><?= __tr('Allow Google Map') ?></label>
				</div>
			</legend>
			<!-- /allow google map input radio field -->

			<!-- show after google map allow information -->
			<div class="btn-group" id="lwIsGoggleMapKeysExist"  style="display:none">
				<button type="button" disabled="true" class="btn btn-success lw-btn"><?= __tr('Google Map keys are installed.') ?></button>
				<button type="button" class="btn btn-light lw-btn" id="lwAddGoogleMapKeys"><?= __tr('Update') ?></button>
			</div>
			<!-- show after google map allow information -->

			<!-- google map key exists hidden field -->
			<input type="hidden" name="google_map_keys_exist" id="lwGoogleMapKeysExist" value="<?= $configurationData['google_map_key'] ?>"/>
			<!-- google map key exists hidden field -->

			<div id="lwGoogleMapInputField">
				<!-- Google Map Key Key -->
				<div class="mb-3">
                    <label for="lwGoogleMapKey"><?= __tr('Google Map Key') ?></label>
					<input type="text" class="form-control form-control-user" name="google_map_key" placeholder="<?= __tr('Add Your Google Map Key') ?>" id="lwGoogleMapKey">
				</div>
				<!-- /Google Map Key Key -->
			</div>
		</fieldset>
		<!-- /google map settings -->
	</div>
	<!-- /Google Map Block End-->

	<!-- Giphy Block Start-->
	<div class="form-group mt-2">
		<!-- giphy map settings -->
		<fieldset class="lw-fieldset mb-3">
			<!-- allow giphy input radio field -->
			<legend class="lw-fieldset-legend">
				<!-- enable giphy hidden field -->
				<input type="hidden" name="allow_giphy" id="lwEnableGiphy" value="0"/>
				<!-- enable giphy hidden field -->
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="lwAllowGiphy" <?= $configurationData['allow_giphy'] == true ? 'checked' : '' ?> name="allow_giphy" value="1">
					<label class="custom-control-label" for="lwAllowGiphy"><?= __tr('Allow Giphy') ?></label>
				</div>
			</legend>
			<!-- /allow giphy input radio field -->

			<!-- show after giphy allow information -->
			<div class="btn-group" id="lwIsGiphyKeysExist"  style="display:none">
				<button type="button" disabled="true" class="btn btn-success lw-btn"><?= __tr('Giphy keys are installed.') ?></button>
				<button type="button" class="btn btn-light lw-btn" id="lwAddGiphyKeys"><?= __tr('Update') ?></button>
			</div>
			<!-- show after giphy allow information -->

			<!-- giphy key exists hidden field -->
			<input type="hidden" name="giphy_keys_exist" id="lwGiphyKeysExist" value="<?= $configurationData['giphy_key'] ?>"/>
			<!-- giphy key exists hidden field -->

			<div id="lwGiphyKeyInputField">
				<!-- Giphy Key -->
				<div class="mb-3">
                    <label for="lwGiphyKey"><?= __tr('Giphy Key') ?></label>
					<input type="text" class="form-control form-control-user" name="giphy_key" placeholder="<?= __tr('Add Your Giphy Key') ?>" id="lwGiphyKey">
				</div>
				<!-- /Giphy Key -->
			</div>
		</fieldset>
		<!-- /giphy map settings -->
	</div>
	<!-- /Giphy Block End-->

	<!-- Update Button -->
    <a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile">
        <?= __tr('Update') ?>
    </a>
    <!-- /Update Button -->
</form>
<!-- /pusher Setting Form -->

@push('appScripts')
<script>
	// Pusher js block start
	$(document).ready(function() {
		/*********** Pusher Enable / Disable Checkout start here ***********/
		var isPusherAllow = $('#lwAllowPusher').is(':checked');
		if (!isPusherAllow) {
			$('#lwPusherInputField').addClass('lw-disabled-block-content');
			$('#lwAddPusherKeys').attr("disabled", true);
		}
		$("#lwAllowPusher").on('change', function(event) {
			isPusherAllow  = $(this).is(":checked");
			//check is enable false then add class
			if (!isPusherAllow) {
				$("#lwPusherInputField").addClass('lw-disabled-block-content');
				$('#lwAddPusherKeys').attr("disabled", true);
			//else remove class
			} else {
				$("#lwPusherInputField").removeClass('lw-disabled-block-content');
				$('#lwAddPusherKeys').attr("disabled", false);
			}
		});
		/*********** Pusher Enable / Disable Checkout end here ***********/

		/*********** Pusher Keys setting start here ***********/
		var isPusherKeysInstalled = "<?= $configurationData['pusher_app_id'] ?>",
			lwPusherInputField = $('#lwPusherInputField'),
			lwIsPusherKeysExist = $('#lwIsPusherKeysExist');
		
		// Check if test pusher keys are installed
		if (isPusherKeysInstalled) {
			lwPusherInputField.hide();
			lwIsPusherKeysExist.show();
		} else {
			lwIsPusherKeysExist.hide();
		}
		// Update pusher checkout keys
		$('#lwAddPusherKeys').click(function() {
			$("#lwPusherKeysExist").val(0);
			lwPusherInputField.show();
			lwIsPusherKeysExist.hide();
		});
		/*********** Pusher Keys setting end here ***********/
	});
	//Pusher js block end

	//Agora js block start
	$(document).ready(function() {
		/*********** Agora Enable / Disable Checkout start here ***********/
		var isAgoraAllow = $('#lwAllowAgora').is(':checked');
		if (!isAgoraAllow) {
			$('#lwAgoraInputField').addClass('lw-disabled-block-content');
			$('#lwAddAgoraKeys').attr("disabled", true);
		}
		$("#lwAllowAgora").on('change', function(event) {
			isAgoraAllow  = $(this).is(":checked");
			//check is enable false then add class
			if (!isAgoraAllow) {
				$("#lwAgoraInputField").addClass('lw-disabled-block-content');
				$('#lwAddAgoraKeys').attr("disabled", true);
			//else remove class
			} else {
				$("#lwAgoraInputField").removeClass('lw-disabled-block-content');
				$('#lwAddAgoraKeys').attr("disabled", false);
			}
		});
		/*********** Agora Enable / Disable Checkout end here ***********/

		/*********** Agora Keys setting start here ***********/
		var isAgoraKeysInstalled = "<?= $configurationData['agora_app_id'] ?>",
			lwAgoraInputField = $('#lwAgoraInputField'),
			lwIsAgoraKeysExist = $('#lwIsAgoraKeysExist');
		
		// Check if test Agora keys are installed
		if (isAgoraKeysInstalled) {
			lwAgoraInputField.hide();
			lwIsAgoraKeysExist.show();
		} else {
			lwIsAgoraKeysExist.hide();
		}
		// Update Agora checkout keys
		$('#lwAddAgoraKeys').click(function() {
			$("#lwAgoraKeysExist").val(0);
			lwAgoraInputField.show();
			lwIsAgoraKeysExist.hide();
		});
		/*********** Agora Keys setting end here ***********/
	});
	//Agora js block start
	
	// Google Map js block start
	$(document).ready(function() {
		/*********** Google Map Enable / Disable Checkout start here ***********/
		var isGoogleMapAllow = $('#lwAllowGoogleMap').is(':checked');
		if (!isGoogleMapAllow) {
			$('#lwGoogleMapInputField').addClass('lw-disabled-block-content');
			$('#lwAddGoogleMapKeys').attr("disabled", true);
		}
		$("#lwAllowGoogleMap").on('change', function(event) {
			isPusherAllow  = $(this).is(":checked");
			//check is enable false then add class
			if (!isPusherAllow) {
				$("#lwGoogleMapInputField").addClass('lw-disabled-block-content');
				$('#lwAddGoogleMapKeys').attr("disabled", true);
			//else remove class
			} else {
				$("#lwGoogleMapInputField").removeClass('lw-disabled-block-content');
				$('#lwAddGoogleMapKeys').attr("disabled", false);
			}
		});
		/*********** Google Map Enable / Disable Checkout end here ***********/

		/*********** Google Map Keys setting start here ***********/
		var isGoogleMapKeysInstalled = "<?= $configurationData['google_map_key'] ?>",
			lwGoogleMapInputField = $('#lwGoogleMapInputField'),
			lwIsGoggleMapKeysExist = $('#lwIsGoggleMapKeysExist');
		
		// Check if test Google Map keys are installed
		if (isGoogleMapKeysInstalled) {
			lwGoogleMapInputField.hide();
			lwIsGoggleMapKeysExist.show();
		} else {
			lwIsGoggleMapKeysExist.hide();
		}
		// Update pusher checkout keys
		$('#lwAddGoogleMapKeys').click(function() {
			$("#lwGoogleMapKeysExist").val(0);
			lwGoogleMapInputField.show();
			lwIsGoggleMapKeysExist.hide();
		});
		/*********** Google Map Keys setting end here ***********/
	});
	//Google Map js block end

	// Giphy js block start
	$(document).ready(function() {
		/*********** Giphy Enable / Disable Checkout start here ***********/
		var isGiphyAllow = $('#lwAllowGiphy').is(':checked');
		if (!isGiphyAllow) {
			$('#lwGiphyKeyInputField').addClass('lw-disabled-block-content');
			$('#lwAddGiphyKeys').attr("disabled", true);
		}

		$("#lwAllowGiphy").on('change', function(event) {
			isPusherAllow  = $(this).is(":checked");
			//check is enable false then add class
			if (!isPusherAllow) {
				$("#lwGiphyKeyInputField").addClass('lw-disabled-block-content');
				$('#lwAddGiphyKeys').attr("disabled", true);
			//else remove class
			} else {
				$("#lwGiphyKeyInputField").removeClass('lw-disabled-block-content');
				$('#lwAddGiphyKeys').attr("disabled", false);
			}
		});
		/*********** Giphy Enable / Disable Checkout end here ***********/

		/*********** Giphy Keys setting start here ***********/
		var isGiphyKeysInstalled = "<?= $configurationData['giphy_key'] ?>",
			lwGiphyKeyInputField = $('#lwGiphyKeyInputField'),
			lwIsGiphyKeysExist = $('#lwIsGiphyKeysExist');
		
		// Check if Live Giphy keys are installed
		if (isGiphyKeysInstalled) {
			lwGiphyKeyInputField.hide();
			lwIsGiphyKeysExist.show();
		} else {
			lwIsGiphyKeysExist.hide();
		}
		// Update Giphy checkout keys
		$('#lwAddGiphyKeys').click(function() {
			$("#lwGiphyKeysExist").val(0);
			lwGiphyKeyInputField.show();
			lwIsGiphyKeysExist.hide();
		});
		/*********** Giphy Keys setting end here ***********/
	});
	//Giphy js block end

	//on integration setting success callback function
	function onIntegrationSettingCallback(responseData) {
		//check reaction code is 1 then reload view
		if (responseData.reaction == 1) {
			showConfirmation('Settings Updated Successfully', null, {
				buttons: [
					Noty.button('Reload', 'btn btn-secondary btn-sm', function () {
						__Utils.viewReload();
					})
				]
			});
		}
	};
</script>
@endpush