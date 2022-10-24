@section('page-title', __tr('Notification Settings'))
@section('head-title', __tr('Notification Settings'))
@section('keywordName', __tr('Notification Settings'))
@section('keyword', __tr('Notification Settings'))
@section('description', __tr('Notification Settings'))
@section('keywordDescription', __tr('Notification Settings'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Configurações') ?></h1>
</div>

<!-- Notification Setting Form -->
<form class="lw-ajax-form lw-form" method="post" action="<?= route('user.write.setting', ['pageType' => request()->pageType]) ?>">
	<div class="row">
		<div class="col-sm-6 mb-2">
			<!-- Show Visitor Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_visitor_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowVisitorNotify" name="show_visitor_notification" value="true" <?= $userSettingData['show_visitor_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowVisitorNotify"><?=  __tr( 'Show Visitors Notification' )  ?></label>
			</div>
			<!-- / Show Visitor Notification field -->
		</div>
		<div class="col-sm-6">
			<!-- Show Profile Like Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_like_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowLikeNotify" name="show_like_notification" value="true" <?= $userSettingData['show_like_notification'] == true ? 'checked' : '' ?> <?= getFeatureSettings('show_like') == true ? '' : 'disabled' ?>>
				<label class="custom-control-label" for="lwShowLikeNotify">
                    <?=  __tr( 'Show Likes Notification' )  ?> 
                @if(getFeatureSettings('show_like', 'select_user') == '2')
					 <span class="lw-premium-feature-badge"></span>
				@endif
                </label>
			</div>
			<!-- / Show Profile Like Notification field -->
		</div>
		<div class="col-sm-6">
			<!-- Show Gifts Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_gift_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowGiftNotify" name="show_gift_notification" value="true" <?= $userSettingData['show_gift_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowGiftNotify"><?=  __tr( 'Show Gifts Notification' )  ?></label>
			</div>
			<!-- / Show Gifts Notification field -->
		</div>
		<div class="col-sm-6">
			<!-- Show Messages Notification field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_message_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowMessageNotify" name="show_message_notification" value="true" <?= $userSettingData['show_message_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowMessageNotify"><?=  __tr( 'Show Messages Notification' )  ?></label>
			</div>
			<!-- / Show Messages Notification field -->
		</div>
		<div class="col-sm-6 mt-2">
			<!-- Show User LoggedIn field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_user_login_notification" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowLoginNotify" name="show_user_login_notification" value="true" <?= $userSettingData['show_user_login_notification'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowLoginNotify"><?=  __tr( 'Show Login Notification For Your Liked Users' )  ?></label>
			</div>
			<!-- / Show User LoggedIn field -->
		</div>
		<div class="col-sm-6 mt-2">
			<!-- Show User Received Gifts field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_received_gifts" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowGifts" name="show_received_gifts" value="true" <?= $userSettingData['show_received_gifts'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowGifts"><?=  __tr( 'Mostrar presentes recebidos' )  ?></label>
			</div>
			<!-- / Show User Received Gifts field -->
		</div>
		<div class="col-sm-6 mt-2">
			<!-- Show User Received Gifts field -->
			<div class="custom-control custom-checkbox custom-control-inline">
				<input type="hidden" name="show_wallet_credits" value="false">
				<input type="checkbox" class="custom-control-input" id="lwShowCredits" name="show_wallet_credits" value="true" <?= $userSettingData['show_wallet_credits'] == true ? 'checked' : '' ?>>
				<label class="custom-control-label" for="lwShowCredits"><?=  __tr( 'Mostrar saldo de SC$' )  ?></label>
			</div>
			<!-- / Show User Received Gifts field -->
		</div>
	</div>
	
	<!-- Update Button -->
	<a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile mt-3 btn-sm">
		<?= __tr('Update') ?>
	</a>
	<!-- /Update Button -->
</form>
<!-- Notification Setting Form -->