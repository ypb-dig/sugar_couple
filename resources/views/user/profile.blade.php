@section('page-title', strip_tags($userData['userName']))
@section('head-title', strip_tags($userData['userName']))
@section('page-url', url()->current())

@if(isset($userData['aboutMe']))
	@section('keywordName', strip_tags($userProfileData['aboutMe']))
	@section('keyword', strip_tags($userProfileData['aboutMe']))
	@section('description', strip_tags($userProfileData['aboutMe']))
	@section('keywordDescription', strip_tags($userProfileData['aboutMe']))
@endif

@if(isset($userData['profilePicture']))
	@section('page-image', $userData['profilePicture'])
@endif
@if(isset($userData['coverPicture']))
	@section('twitter-card-image', $userData['coverPicture'])
@endif

<!-- if user block then don't show profile page content -->
@if($isBlockUser)
	<!-- info message -->
	<div class="alert alert-info">
		<?= __tr('This user is unavailable.') ?>
	</div>
	<!-- / info message -->
@elseif($blockByMeUser)
	<!-- info message -->
	<div class="alert alert-info">
		<?= __tr('You have blocked this user.') ?>
	</div>
	<!-- / info message -->
@else
    <div class="">
		<div class="card mb-3">
			@if($isOwnProfile)
			<div class="float-right text-right">
				<!-- total user likes count -->
				<i class="fas fa-heart text-danger"></i> <span id="lwTotalUserLikes" class="mr-3">
				<?= __trn('__totalUserLike__ curtida', '__totalUserLike__ curtidas',$totalUserLike, [
					'__totalUserLike__' => $totalUserLike
				]) ?></span>
				<!-- /total user likes count -->

				<!-- total user visitors count -->
				<i class="fas fa-eye text-warning"></i> <?= __trn('__totalVisitors__ visualização', '__totalVisitors__ visualizações', $totalVisitors, [
					'__totalVisitors__' => $totalVisitors
				]) ?>
				<!-- /total user visitors count -->
			</div>
			@endif
			<div class="card-header">
				@if(!$isOwnProfile)
				<span class="float-right">
					<!-- report button -->
					<a class="text-primary btn-link btn" title="<?= __tr('Report') ?>" data-toggle="modal" data-target="#lwReportUserDialog"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>
					<!-- /report button -->	

					<!-- Block User button -->
					<a class="text-primary btn-link btn" title="<?= __tr('Block User') ?>" id="lwBlockUserBtn"><i class="fas fa-ban"></i></a>
					<!-- /Block User button -->
				</span>
				@endif
				<h4>
					<?= $userData['fullName'] ?>
					@if(!__isEmpty($userData['userAge'])) <span style="float: right;" data-model="userData.userAge"><?= $userData['userAge'] ?> <?=__tr('anos') ?></span>@endif
					<!-- show user online, idle or offline status -->
					@if(!$isOwnProfile)
						@if($userOnlineStatus == 1)
						<span class="lw-dot lw-dot-success float-none {{$userData['userUId']}}" title="<?= __tr("Online") ?>"></span>
						@elseif($userOnlineStatus == 2)
						<span class="lw-dot lw-dot-warning float-none {{$userData['userUId']}}" title="<?= __tr("Idle") ?>"></span>
						@elseif($userOnlineStatus == 3)
						<span class="lw-dot lw-dot-danger float-none {{$userData['userUId']}}" title="<?= __tr("Offline") ?>"></span>
						@endif
					@endif
					<script>
						function getUserStatus(userUID){
							

							$.getJSON("/{{$userData['userUId']}}/online/status", function( data ) {
								console.log('Online Status:', data);
								var status = data.data.onlineStatus;

								var dotclass = "";
								var title = "";

								switch(status){
									case 1: 
									dotclass = "lw-dot-success";
									title = "<?= __tr("Online") ?>";
									break;
									case 2: 
									dotclass = "lw-dot-warning";
									title = "<?= __tr("Idle") ?>";
									break;
									case 3: 
									dotclass = "lw-dot-danger";
									title = "<?= __tr("Offline") ?>";
									break;																
								}
								
								$("span.lw-dot.{{$userData['userUId']}}")
									.removeClass("lw-dot-warning lw-dot-danger lw-dot-success")
									.addClass(dotclass)
									.attr("title", title);
							});

						}
						setInterval(function(){
							getUserStatus('{{$userData['userUId']}}');
						}, 60 * 1000);
					</script>
					<!-- /show user online, idle or offline status -->

					<!-- if user is premium then show badge -->
					@if(getFeatureSettings('premium_badge'))
						<i class="fas fa-star"></i>
					@endif
					<!-- /if user is premium then show badge -->

					@if(__ifIsset($userProfileData['isVerified']) 
						and $userProfileData['isVerified'] == 1)
						<i class="fas fa-user-check text-info"></i>
					@endif
				</h4>
				@if((__ifIsset($userProfileData['city']) and __ifIsset($userProfileData['country_name'])))
				<i class="fas fa-map-marker-alt text-success"></i> 
				<span class="mr-3"><span data-model="profileData.city"><?= $userProfileData['city'] ?></span>, <span data-model="profileData.country_name"><?= $userProfileData['country_name'] ?></span></span>
				@endif
			</div>
		</div>
		<!-- User Profile and Cover photo -->
		<div class="card mb-4 lw-profile-image-card-container">
			<div class="card-body">
				@if($isOwnProfile)
				<span class="lw-profile-edit-button-container">
					<a class="lw-icon-btn" href role="button" id="lwEditProfileAndCoverPhoto">
						<i class="fa fa-pencil-alt"></i>
					</a>
					<a class="lw-icon-btn" href role="button" id="lwCloseProfileAndCoverBlock" style="display: none;">
						<i class="fa fa-check"></i> Salvar
					</a>
				</span>
				@endif
				<div class="row" id="lwProfileAndCoverStaticBlock">     
					<div class="col-lg-12">
						<div class="card mb-3 lw-profile-image-card-container">
						<img class="lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img" id="lwProfilePictureStaticImage" data-src="<?= imageOrNoImageAvailable($userData['profilePicture']) ?>">
							<img class="lw-cover-picture card-img-top lw-lazy-img" id="lwCoverPhotoStaticImage" data-src="<?= imageOrNoImageAvailable($userData['coverPicture']) ?>">
						</div>
					</div> 
				</div>
				@if($isOwnProfile)
					<div class="row" id="lwProfileAndCoverEditBlock" style="display: none;">
						<div class="col-lg-3">
							<input type="file" 
								name="filepond"
								class="filepond lw-file-uploader"
								id="lwFileUploader" 
								data-remove-media="true"
								data-instant-upload="true" 
								data-action="<?= route('user.upload_profile_image') ?>"
								data-label-idle="<?= __tr('Drag & Drop your picture or') ?> <span class='filepond--label-action'><?= __tr('Browse') ?></span>"
								data-image-preview-height="170"
								data-image-crop-aspect-ratio="1:1"
								data-style-panel-layout="compact circle"
								data-style-load-indicator-position="center bottom"
								data-style-progress-indicator-position="right bottom"
								data-style-button-remove-item-position="left bottom"
								data-style-button-process-item-position="right bottom"
								data-callback="afterUploadedProfilePicture">
						</div>
						<div class="col-lg-9">
							<input type="file" 
								name="filepond"
								class="filepond lw-file-uploader mt-5"
								id="lwFileUploader" 
								data-remove-media="false"
								data-instant-upload="true" 
								data-action="<?= route('user.upload_cover_image') ?>"
								data-callback="afterUploadedCoverPhoto"
								data-label-idle="<?= __tr('Drag & Drop your picture or') ?> <span class='filepond--label-action'><?= __tr('Browse') ?></span>">
						</div>
					</div>
				@endif
			</div>            
		</div>
		<!-- /User Profile and Cover photo -->
		
		<!-- mobile view premium block -->
		@if($isPremiumUser)
		<div class="mb-4 d-block d-md-none">
			<div class="card">
				<div class="card-body">
					<span class="lw-premium-badge" title="<?= __tr('Premium User') ?>"></span>
				</div> 
			</div>
		</div>
		@endif
		<!-- /mobile view premium block -->

		<!-- mobile view like dislike block -->
		@if(!$isOwnProfile)
        <div class="mb-4 d-block d-md-none">
			<!-- profile related -->
			<div class="card">
				<div class="card-header">
					<?= __tr('Like Dislike') ?>
				</div>
				<div class="card-body">
					<!-- Like and dislike buttons -->
					@if(!$isOwnProfile)
					<div class="lw-like-dislike-box">
						<!-- like button -->
						<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'],'like' => 1]) ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action lw-like-action-btn" id="lwLikeBtn">
							<span class="lw-animated-heart lw-animated-like-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? 'lw-is-active' : '' ?>"></span>
						</a>
						<span data-model="userLikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? __tr('Liked') : __tr('Like')  ?>
						</span>
						<!-- /like button -->
					</div>
					<div class="lw-like-dislike-box">
						<!-- dislike button -->
						<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'],'like' => 0]) ?>" data-method="post" data-callback="onLikeCallback" title="Dislike" class="lw-ajax-link-action lw-dislike-action-btn" id="lwDislikeBtn">
							<span class="lw-animated-heart lw-animated-broken-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? 'lw-is-active' : '' ?>"></span>
						</a>
						<span data-model="userDislikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? __tr('Disliked') : __tr('Dislike')  ?>
						</span>
						<!-- /dislike button -->
					</div>
                    @endif
				</div> 
				<!-- / Like and dislike buttons -->
			</div>
			<div class="card mt-3">
				<div class="card-header">
					<?= __tr('Send a message or Gift') ?>
				</div>
				<div class="card-body text-center">
                    <!-- message button -->
                    <a class="mr-3 btn-link btn" onclick="getChatMessenger('<?= route('user.read.individual_conversation', ['specificUserId' => $userData['userId']]) ?>')" href id="lwMessageChatButton" data-chat-loaded="false" data-toggle="modal" data-target="#messengerDialog"><i class="far fa-comments fa-3x"></i>
                        <br> <?= __tr('Message') ?></a>

                    <!-- send gift button -->
                    <a href title="<?= __tr('Send Gift') ?>" data-toggle="modal" data-target="#lwSendGiftDialog" class="btn-link btn"><i class="fa fa-gift fa-3x" aria-hidden="true"></i>
                        <br> <?= __tr('Gift') ?>
                    </a>
                    <!-- /send gift button -->
                </div>
            </div>
		</div>
		@endif
		<!-- /mobile view like dislike block -->
		@if(isset($userProfileData['aboutMe']))		
		<div class="card mb-3">
			<div class="card-header organize.luiz">
			<i class="fas fa-user text-primary"></i> <?= __tr('About Me') ?>
			</div>
			<div class="card-body">
			<!-- About Me -->
			<div class="form-group">
				<div class="lw-inline-edit-text" data-model="profileData.aboutMe">
					<?= __ifIsset($userProfileData['aboutMe'], $userProfileData['aboutMe'], '-') ?>
				</div>
			</div>
			<!-- /About Me -->
			</div>
		</div>
		@endif		
		@if(!__isEmpty($photosData) or $isOwnProfile)
		<div class="card mb-3">
			<div class="card-header">
				@if($isOwnProfile)
					<span class="float-right">
						<a class="lw-icon-btn" href="<?= route('user.photos_setting', ['username' => getUserAuthInfo('profile.username')]) ?>" role="button">
							<i class="fas fa-cog"></i>
						</a>
					</span>
				@endif
			<h5><i class="fas fa-images text-warning"></i> <?= __tr('Galeria') ?></h5>
			</div>
			<style>
				.trash-icon {
				    margin-left: -20px;
				    margin-top: 0px;
				    color: red;
				    cursor: pointer;
				    position: relative;
				    top: -59px;
				    left: 0px;
				}
			</style>
			<div class="card-body">
				<div class="row text-center text-lg-left lw-horizontal-container pl-2">					
					@if(!__isEmpty($photosData))
						@foreach($photosData as $key => $photo)
						@include("../includes/photowithcomments")
						@endforeach
					@else
						<?= __tr('Ooops... No images found...') ?>
					@endif
				</div>
			</div>
		</div>
		@endif
    
		@if(getUserSettings('show_received_gifts', $userData['userId']) == true && !$isOwnProfile)

			<!-- user gift data -->
			@if(!__isEmpty($userGiftData) or $isOwnProfile)
			<div class="card mb-3">
				<!-- Gift Header -->
				<div class="card-header">
					<h5><i class="fa fa-gifts" aria-hidden="true"></i>  <?= __tr('Gifts') ?></h5>
				</div>
				<!-- /Gift Header -->
				<script>
					function openGiftModal(id){
						$('#lwGiftModal' + id).modal("show");
						@if($isOwnProfile)
						 __DataRequest.post("/user/" + id + "/checked-as-viewed", {}, function(responseData) {
					 		console.log(responseData);
				         });
				         @endif
					}
				</script>
				<!-- Gift Card Body -->
				<div class="card-body">
					@if(!__isEmpty($userGiftData))
					<div class="row">
						@foreach($userGiftData as $gift)
							<div class="lw-user-gift-container">
								<img onclick="openGiftModal({{$gift['_id']}})" data-src="<?= imageOrNoImageAvailable($gift['userGiftImgUrl']) ?>" class="lw-user-gift-img lw-lazy-img"/>
								<small>
								@if($gift['from_id'] !=  getUserID())
	                            <?= __tr('sent by') ?> <br>
	                            <a href="<?= route('user.profile_view', ['username' => $gift['senderUserName']]) ?>">@<?= $gift['senderUserName'] ?></a></small>
	                            @else
	                          	<?= __tr('enviado para') ?> <br>
	                            <a href="<?= route('user.profile_view', ['username' => $gift['fromUserName']]) ?>">@<?= $gift['fromUserName'] ?></a></small>
	                            @endif
	                            @if($gift['status'] === 1) 
	                            <i class="fas fa-mask" title="<?= __tr('This is a private gift you and only sender can see this.') ?>"></i>
	                            @endif
							</div>
							@if($isOwnProfile)
							<script>	
								@if($gift['viewed'] == 0)
									setTimeout(function(){
										openGiftModal({{$gift['_id']}})
									}, 2000);
								@endif
							</script>
							@endif
							<!-- Gift Modal-->
							<div class="modal fade gift-modal animated animate__zoomInDown animate__delay-5s" id="lwGiftModal{{$gift['_id']}}" tabindex="-1" role="dialog" aria-labelledby="lwGiftModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-md" role="document">
									<div class="modal-content">						
										<div class="modal-body text-center">
											<div class="lw-user-gift-container">
												<img data-src="<?= imageOrNoImageAvailable($gift['userGiftImgUrl']) ?>" class="lw-user-gift-img lw-lazy-img"/>
												<small>
												@if($gift['from_id'] !=  getUserID())
					                            <?= __tr('sent by') ?> <br>
					                            <a href="<?= route('user.profile_view', ['username' => $gift['senderUserName']]) ?>">@<?= $gift['senderUserName'] ?></a></small>
					                            @else
					                          	<?= __tr('enviado para') ?> <br>
					                            <a href="<?= route('user.profile_view', ['username' => $gift['fromUserName']]) ?>">@<?= $gift['fromUserName'] ?></a></small>
					                            @endif
					                            @if($gift['status'] === 1) 
					                            <i class="fas fa-mask" title="<?= __tr('This is a private gift you and only sender can see this.') ?>"></i>
					                            @endif
											</div>
											@if( isset($gift['message']))
											<p class="gift-message animated animate__fadeIn animate__delay-10s"><?= $gift['message'] ?></p>
											@endif
										</div>

										<!-- modal footer -->
										<div class="modal-footer text-center">
											<button class="btn btn-light btn-sm" data-dismiss="modal"><?= __tr('Fechar') ?></button>
										</div>
										<!-- modal footer -->
									</div>
								</div>
							</div>
							<!-- /Gift Modal-->
						@endforeach
					</div>
					@else
						<!-- info message -->
						<div class="alert alert-info">
							<?= __tr('There are no gifts.') ?>
						</div>
						<!-- / info message -->
					@endif
				</div>
				<!-- Gift Card Body -->
			</div>
			@endif
			<!-- /user gift data -->
		@endif
		<!-- User Basic Information -->
		<div class="card mb-3">            
			<!-- Basic information Header -->
			<div class="card-header">
				<!-- Check if its own profile -->
				@if($isOwnProfile)
					<span class="float-right">
						<a class="lw-icon-btn" href role="button" id="lwEditBasicInformation">
							<i class="fa fa-pencil-alt"></i>
						</a>
						<a class="lw-icon-btn" href role="button" id="lwCloseBasicInfoEditBlock" style="display: none;">
							<i class="fa fa-check"></i> Salvar
						</a>
					</span>
				@endif
				<!-- /Check if its own profile -->
				<h5><i class="fas fa-info-circle text-info"></i>  <?= __tr('Basic Information') ?></h5>
			</div>
			<!-- /Basic information Header -->
			<!-- Basic Information content -->
			<div class="card-body">
				<!-- Static basic information container -->
				<div id="lwStaticBasicInformation">
					@if($isOwnProfile)
					<div class="form-group row">
						<!-- First Name -->
						<div class="col-sm-12 mb-3 mb-sm-0">
							<label for="first_name"><strong><?= __tr('First Name') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="userData.first_name"><?= __ifIsset($userData['first_name'], $userData['first_name'], '-') ?></div>
						</div>
						<!-- /First Name -->
						<!-- Last Name -->
						<div class="col-sm-6 hide">
							<label for="last_name"><strong><?= __tr('Last Name') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="userData.last_name"><?= __ifIsset($userData['last_name'], $userData['last_name'], '-') ?></div>
						</div>
						<!-- /Last Name -->
					</div>
					@endif
					<div class="form-group row">
						<!-- Gender -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="select_gender"><strong><?= __tr('Gender') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.gender_text">
							<?= __ifIsset($userProfileData['gender_text'], $userProfileData['gender_text'], '-') ?>
							</div>
						</div>
						<!-- /Gender -->
						<!-- Preferred Language -->
						<div class="col-sm-6">
							<label><strong><?= __tr('Preferred Language') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.formatted_preferred_language">
								<?= __ifIsset($userProfileData['formatted_preferred_language'], $userProfileData['formatted_preferred_language'], '-') ?>
							</div>
						</div>
						<!-- /Preferred Language -->
					</div>
					<div class="form-group row">
						<!-- Relationship Status -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label><strong><?= __tr('Relationship Status') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.formatted_relationship_status">
								<?= __ifIsset($userProfileData['formatted_relationship_status'], $userProfileData['formatted_relationship_status'], '-') ?>
							</div>
						</div>
						<!-- /Relationship Status -->
						<!-- Work Status -->
						<div class="col-sm-6">
							<label for="work_status"><strong><?= __tr('Work Status') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.formatted_work_status">
								<?= __ifIsset($userProfileData['formatted_work_status'], $userProfileData['formatted_work_status'], '-') ?>
							</div>
						</div>
						<!-- /Work Status -->
					</div>
					<div class="form-group row">
						<!-- Education -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="education"><strong><?= __tr('Education') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.formatted_education">
								<?= __ifIsset($userProfileData['formatted_education'], $userProfileData['formatted_education'], '-') ?>
							</div>
						</div>
						<!-- /Education -->
						<!-- Birthday -->
						<div class="col-sm-6">
							<label for="birthday"><strong><?= __tr('Birthday') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.birthday">
								<?= __ifIsset($userProfileData['birthday'], $userProfileData['birthday'], '-') ?>
							</div>
						</div>
						<!-- /Birthday -->
					</div>
					@if(isPremiumUser() && 1 == 2)
					<div class="form-group row">
						<!-- Mobile Number -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="mobile_number"><strong><?= __tr('Mobile Number') ?></strong></label>
							<div class="lw-inline-edit-text" data-model="profileData.mobile_number">
								<?= __ifIsset($userProfileData['mobile_number'], $userProfileData['mobile_number'], '-') ?>
							</div>
						</div>
						<!-- /Mobile Number -->
					</div>
					@endif
				</div>
				<!-- /Static basic information container -->

				@if($isOwnProfile)
					<!-- User Basic Information Form -->
					<form class="lw-ajax-form lw-form lw-form-profile" lwSubmitOnChange_ method="post" data-show-message="true" action="<?= route('user.write.basic_setting') ?>" data-callback="getUserProfileData" style="display: none;" id="lwUserBasicInformationForm">
						<div class="form-group row">
							<!-- First Name -->
							<div class="col-sm-12 mb-3 mb-sm-0">
								<label for="first_name"><?= __tr('First Name') ?></label>
								<input type="text" value="<?= $userData['first_name'] ?>" class="form-control" name="first_name"
								placeholder="<?= __tr('First Name') ?>">
							</div>
							<!-- /First Name -->
							<!-- Last Name -->
							<div class="col-sm-6 hide">
								<label for="last_name"><?= __tr('Last Name') ?></label>
								<input type="text" value="<?= $userData['last_name'] ?>" class="form-control" name="last_name" placeholder="<?= __tr('Last Name') ?>">
							</div>
							<!-- /Last Name -->
						</div>
						<div class="form-group row">
							<!-- Gender -->
							<div class="col-sm-6 mb-3 mb-sm-0">
								<label for="select_gender"><?= __tr('Gender') ?></label>
								<select name="gender" class="form-control" id="select_gender">
									<option value="" selected disabled><?= __tr('Choose your gender') ?></option>
									@foreach($genders as $genderKey => $gender)
										@if($genderKey == $userProfileData['gender']))
										<option value="<?= $genderKey ?>" <?= (__ifIsset($userProfileData['gender']) and $genderKey == $userProfileData['gender']) ? 'selected' : '' ?>><?= $gender ?></option>
										@endif
									@endforeach
								</select>
							</div>

							<!-- /Gender -->
							<!-- Birthday -->
							<div class="col-sm-6">
								<label for="select_preferred_language"><?= __tr('Preferred Language') ?></label>
								<select name="preferred_language" class="form-control" id="select_preferred_language">
									<option value="" selected disabled><?= __tr('Choose your Preferred Language') ?></option>
									@foreach($preferredLanguages as $languageKey => $language)
										<option value="<?= $languageKey ?>" <?= (__ifIsset($userProfileData['preferred_language']) and $languageKey == $userProfileData['preferred_language']) ? 'selected' : '' ?>><?= $language ?></option>
									@endforeach
								</select>
							</div>
							<!-- /Preferred Language -->
						</div>
						<div class="form-group row">
							<!-- Relationship Status -->
							<div class="col-sm-6 mb-3 mb-sm-0">
								<label for="select_relationship_status"><?= __tr('Relationship Status') ?></label>
								<select name="relationship_status" class="form-control" id="select_relationship_status">
									<option value="" selected disabled><?= __tr('Choose your Relationship Status') ?></option>
									@foreach($relationshipStatuses as $relationshipStatusKey => $relationshipStatus)
										<option value="<?= $relationshipStatusKey ?>" <?= (__ifIsset($userProfileData['relationship_status']) and $relationshipStatusKey == $userProfileData['relationship_status']) ? 'selected' : '' ?>><?= $relationshipStatus ?></option>
									@endforeach
								</select>
							</div>
							<!-- /Relationship Status -->
							<!-- Work status -->
							<div class="col-sm-6">
								<label for="select_work_status"><?= __tr('Work Status') ?></label>
								<select name="work_status" class="form-control" id="select_work_status">
									<option value="" selected disabled><?= __tr('Choose your work status') ?></option>
									@foreach($workStatuses as $workStatusKey => $workStatus)
										<option value="<?= $workStatusKey ?>" <?= (__ifIsset($userProfileData['work_status']) and $workStatusKey == $userProfileData['work_status']) ? 'selected' : '' ?>><?= $workStatus ?></option>
									@endforeach
								</select>
							</div>
							<!-- /Work status -->
						</div>
						<div class="form-group row">
							<!-- Education -->
							<div class="col-sm-6 mb-3 mb-sm-0">
								<label for="select_education"><?= __tr('Education') ?></label>
								<select name="education" class="form-control" id="select_education">
									<option value="" selected disabled><?= __tr('Choose your education') ?></option>
									@foreach($educations as $educationKey => $educationValue)
										<option value="<?= $educationKey ?>" <?= (__ifIsset($userProfileData['education']) and $educationKey == $userProfileData['education']) ? 'selected' : '' ?>><?= $educationValue ?></option>
									@endforeach
								</select>
							</div>
							<!-- /Education -->
							<!-- Birthday -->
							<div class="col-sm-6">
                                <label for="birthday"><?= __tr('Birthday') ?></label>
                                <input type="text" name="birthday" value="<?= __ifIsset($userProfileData['dob'], $userProfileData['dob']) ?>" placeholder="<?= __tr('DD/MM/AAAA') ?>" class="form-control date-mask" required>
							</div>
							<!-- /Birthday -->
						</div>
						@if($isOwnProfile)
						
						<div class="form-group row">
							<!-- Mobile Number -->
							<div class="col-sm-6">
                                <label for="mobile_number"><?= __tr('Mobile Number') ?></label>
                                <input type="text" value="<?= $userData['mobile_number'] ?>" name="mobile_number" placeholder="<?= __tr('Mobile Number') ?>" class="form-control phone_with_ddd" required maxlength="15">
							</div>
							<!-- /Mobile Number -->
						</div>
						<!-- About Me -->
						<div class="form-group">
							<label for="about_me"><?= __tr('About Me') ?></label>
							<textarea class="form-control" name="about_me" id="about_me" rows="3" placeholder="<?= __tr('Say something about yourself.') ?>">{{ isset($userProfileData['aboutMe'])? $userProfileData['aboutMe'] : '' }}</textarea>
						</div>
						<!-- /About Me -->
						@endif
					</form>
					<!-- /User Basic Information Form -->
				@endif
			</div>
		</div>
		<!-- /User Basic Information -->
	 	<div class="card mb-3 hide">
			<div class="card-header">
			@if($isOwnProfile)
				<span class="float-right">
					<a class="lw-icon-btn" href role="button" id="lwEditUserLocation">
						<i class="fa fa-pencil-alt"></i>
					</a>
					<a class="lw-icon-btn" href role="button" id="lwCloseLocationBlock" style="display: none;">
						<i class="fa fa-check"></i> Salvar
					</a>
				</span>
			@endif
			<h5><i class="fas fa-map-marker-alt"></i> <?= __tr('Location') ?></h5>
			</div>
			<div class="card-body">
				@if(getStoreSettings('allow_google_map'))
				<div id="lwUserStaticLocation">
					<?php 
						$latitude = (__ifIsset($userProfileData['latitude'], $userProfileData['latitude'], '21.120779')); 
						$longitude = (__ifIsset($userProfileData['longitude'], $userProfileData['longitude'], '79.0544606')); 
					?>
					<div class="gmap_canvas"><iframe height="300" id="gmap_canvas" src="https://maps.google.com/maps/place?q=<?= $latitude ?>,<?= $longitude ?>&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
					</div>
				</div>
				<div id="lwUserEditableLocation" style="display: none;">
					<div class="form-group">
						<label for="address_address"><?= __tr('Location') ?></label>
						<input type="text" id="address-input" name="address_address" class="form-control map-input">
						<input type="hidden" name="address_latitude" data-model="profileData.latitude" id="address-latitude" value="<?= $latitude ?>" />
						<input type="hidden" name="address_longitude" data-model="profileData.longitude" id="address-longitude" value="<?= $longitude ?>" />
					</div>
					<div id="address-map-container" style="width:100%;height:400px; ">
						<div style="width: 100%; height: 100%" id="address-map"></div>
					</div>
				</div>
				@else
					<!-- info message -->
					<div class="alert alert-info">
						<?= __tr('Something went wrong with Google Api Key, please contact to system administrator.') ?>
					</div>
					<!-- / info message  -->
				@endif
			</div>
		</div>

		<!-- User Specifications -->
		@if(!__isEmpty($userSpecificationData))
			@foreach($userSpecificationData as $specificationKey => $specifications)
				<div class="card mb-3">
					<!-- User Specification Header -->
					<div class="card-header">
						<!-- Check if its own profile -->
						@if($isOwnProfile)
							<span class="float-right">
								<a class="lw-icon-btn" href role="button" id="lwEdit<?= $specificationKey ?>" onclick="showHideSpecificationUser('<?= $specificationKey ?>', event)">
									<i class="fa fa-pencil-alt"></i>
								</a>
								<a class="lw-icon-btn" href role="button" id="lwClose<?= $specificationKey ?>Block" onclick="showHideSpecificationUser('<?= $specificationKey ?>', event)" style="display: none;">
									<i class="fa fa-check"></i> Salvar
								</a>
							</span>
						@endif
						<!-- /Check if its own profile -->
						<h5><?= $specifications['icon'] ?> <?= $specifications['title'] ?></h5>
					</div>
					<!-- /User Specification Header -->
					<div class="card-body">
						<!-- User Specification static container -->
						<div id="lw<?= $specificationKey ?>StaticContainer">
							@foreach(collect($specifications['items'])->chunk(2) as $specKey => $specification)
								<div class="form-group row">
									@foreach($specification as $itemKey => $item)
										<div class="col-sm-6 mb-3 mb-sm-0">
											<label><strong><?= $item['label'] ?></strong></label>
											<div class="lw-inline-edit-text" data-model="specificationData.<?= $item['name'] ?>">
												<?= $item['value'] ?>
											</div>
										</div>
									@endforeach
								</div>
							@endforeach
						</div>
						<!-- /User Specification static container -->
						@if($isOwnProfile)
							<!-- User Specification Form -->
							<form class="lw-ajax-form lw-form" method="post" lwSubmitOnChange action="<?= route('user.write.profile_setting') ?>" data-callback="getUserProfileData" id="lwUser<?= $specificationKey ?>Form" style="display: none;">
								@foreach(collect($specifications['items'])->chunk(2) as $specification)
								<div class="form-group row">
									@foreach($specification as $itemKey => $item)
										<div class="col-sm-6 mb-3 mb-sm-0">
											@if($item['input_type'] == 'select')
												<label for="<?= $item['name'] ?>"><?= $item['label'] ?></label>
												<select name="<?= $item['name'] ?>" class="form-control">
													<option value="" selected disabled><?= __tr('Choose __label__', [
													'__label__' => $item['label']
												]) ?></option>
													@foreach($item['options'] as $optionKey => $option)
														<option value="<?= $optionKey ?>" <?= $item['selected_options'] == $optionKey ? 'selected' : '' ?>>
															<?= $option ?>
														</option>
													@endforeach
												</select>
											@elseif($item['input_type'] == 'textbox')
												<label for="<?= $item['name'] ?>"><?= $item['label'] ?></label>
												<input type="text" id="<?= $item['name'] ?>" name="<?= $item['name'] ?>" class="form-control" value="<?= $item['selected_options'] ?>">                
											@endif
										</div>
									@endforeach
								</div>
								@endforeach
							</form>
							<!-- /User Specification Form -->
						@endif
					</div>
				</div>
			@endforeach
		@endif
		<!-- /User Specifications -->

		</div>
	</div>


	    <!-- user report Modal-->
	    <div class="modal fade" id="lwReportUserDialog" tabindex="-1" role="dialog" aria-labelledby="userReportModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-md" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="userReportModalLabel"><?= __tr('Abuse Report to __username__', [
	                    '__username__' => $userData['fullName']]) ?></h5>
	                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">×</span>
	                    </button>
	                </div>
	                <form class="lw-ajax-form lw-form" id="lwReportUserForm" method="post" data-callback="userReportCallback" action="<?= route('user.write.report_user', ['sendUserUId' => $userData['userUId']]) ?>">
	                    <div class="modal-body">
	                        <!-- reason input field -->
	                        <div class="form-group">
	                            <label for="lwUserReportReason"><?= __tr('Reason') ?></label>
	                            <textarea class="form-control" rows="3" id="lwUserReportReason" name="report_reason" required></textarea>
	                        </div>
	                        <!-- / reason input field -->
	                    </div>

	                    <!-- modal footer -->
	                    <div class="modal-footer mt-3">
	                        <button class="btn btn-light btn-sm" id="lwCloseUserReportDialog"><?= __tr('Cancel') ?></button>
	                        <button type="submit" class="btn btn-primary btn-sm lw-ajax-form-submit-action btn-user lw-btn-block-mobile"><?= __tr('Report') ?></button>
	                    </div>
	                </form>
	                <!-- modal footer -->
	            </div>
	        </div>
	    </div>
	    <!-- /user report Modal-->

		
	<!-- send gift Modal-->
	<div class="modal fade" id="lwSendGiftDialog" tabindex="-1" role="dialog" aria-labelledby="sendGiftModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
                    <?php $totalAvailableCredits = totalUserCredits() ?>
					<h5 class="modal-title" id="sendGiftModalLabel"><?= __tr('Send Gift') ?> <small class="text-muted"><?= __tr('(Credits Available:  __availableCredits__)', [
                        '__availableCredits__' => $totalAvailableCredits
                    ]) ?></small></h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				@if(isset($giftListData) and !__isEmpty($giftListData))

				<!-- insufficient balance error message -->
				<div class="alert alert-info" id="lwGiftModalErrorText" style="display: none">
					<?= __tr('Your credit balance is too low, please') ?>
					<a href="<?= route('user.credit_wallet.read.view') ?>"><?= __tr('purchase credits') ?></a>
				</div>
				<!-- / insufficient balance error message -->
				<script>

					//send gift callback
					function sendGiftCallback(response) {
						//check success reaction is 1
						if (response.reaction == 1) {
							var requestData = response.data;
							//form reset after success
							$("#lwSendGiftForm").trigger("reset");
							//remove active class after success on select gift radio option
							$("#lwSendGiftRadioBtn_"+requestData.giftUid).removeClass('active');
							//close dialog after success
							$('#lwSendGiftDialog').modal('hide');
							//reload view after 2 seconds on success reaction
							_.delay(function() {
								__Utils.viewReload();
							}, 1000)
						//if error type is insufficient balance then show error message
						} else if (response.data['errorType'] == 'insufficient_balance') {
							//show error div
							$("#lwGiftModalErrorText").show();
						} else {
							//hide error div
							$("#lwGiftModalErrorText").hide();
						}
					}
				</script>
				<form class="lw-ajax-form lw-form" id="lwSendGiftForm" method="post" data-callback="sendGiftCallback" action="<?= route('user.write.send_gift', ['sendUserUId' => $userData['userUId']]) ?>">
					<div class="modal-body">
						<div class="btn-group-toggle" data-toggle="buttons">
							@foreach($giftListData as $key => $gift)
							<span class="btn lw-group-radio-option-img" id="lwSendGiftRadioBtn_<?= $gift['_uid'] ?>">
								<input type="radio" value="<?= $gift['_uid'] ?>" name="selected_gift"/>
								<span>
									<img class="lw-lazy-img" data-src="<?= imageOrNoImageAvailable($gift['gift_image_url']) ?>"/><br>
									<?= $gift['formattedPrice'] ?>
								</span>
							</span>
							@endforeach
						</div>
						
						<!-- select private / public -->
						<div class="custom-control custom-checkbox custom-control-inline mt-3">
							<input type="checkbox" class="custom-control-input" id="isPrivateCheck"  name="isPrivateGift">
							<label class="custom-control-label" for="isPrivateCheck"><?=  __tr( 'Private' )  ?></label>
						</div>
						<!-- /select private / public -->

						<!-- Message -->
						<div class="form-input form-control-inline mt-3">
							<label class="form-control-label" for="giftMessage"><?=  __tr( 'Mensagem' )  ?></label>
							<input type="text" class="form-control" id="giftMessage"  name="gift_message">
						</div>
						<!-- /Message -->
					</div>
					<!-- modal footer -->
					<div class="modal-footer mt-3">
						<button class="btn btn-light btn-sm" id="lwCloseSendGiftDialog"><?= __tr('Cancel') ?></button>
						<button type="submit" class="btn btn-primary btn-sm lw-ajax-form-submit-action btn-user lw-btn-block-mobile"><?= __tr('Send') ?></button>
					</div>
					<!-- modal footer -->
				</form>
				@else
					<!-- info message -->
					<div class="alert alert-info">
						<?= __tr('There are no gifts') ?>
					</div>
					<!-- / info message -->
				@endif
			</div>
		<!-- /send gift Modal-->
		</div>
	</div>
</div>
	<!-- User block Confirmation text html -->
	<div id="lwBlockUserConfirmationText" style="display: none;">
		<h3><?= __tr('Are You Sure!') ?></h3>
		<strong><?= __tr('You want to block this user.') ?></strong>
	</div>
	<!-- /User block Confirmation text html -->

	<!-- Content for sidebar -->
	@push('sidebarProfilePage')
		<li class="d-none d-md-block">
			<!-- profile related -->
			<div class="card">
	 			<div class="card-header hide">
					<?= $userData['fullName'] ?> 
				</div> 
				<div class="card-body">
					<img class="profile-image-badge profile-image-badge-{{getUserPlan($userData['userId'])}} lw-profile-thumbnail lw-photoswipe-gallery-img lw-lazy-img" id="lwProfilePictureStaticImage" data-src="<?= imageOrNoImageAvailable($userData['profilePicture']) ?>">

					<!-- user credit data -->
					
					@if(getUserSettings('show_wallet_credits', $userData['userId']) == true && !$isOwnProfile)
					<div class="credits">SC$ <span><?= totalUserCredits($userData['userId']) ?></span></div>
					@endif

					@if($isPremiumUser && 1 == 2)
					<span class="lw-premium-badge" title="<?= __tr('Premium User') ?>"></span>
					@endif 
					<!-- Like and dislike buttons -->
					@if(!$isOwnProfile)
					<div class="lw-like-dislike-box">
						<!-- like button -->
						<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'],'like' => 1]) ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action" id="lwLikeBtn">
							<span class="lw-animated-heart lw-animated-like-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? 'lw-is-active' : '' ?>"
								></span>
						</a>
						<span data-model="userLikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 1) ? __tr('Liked') : __tr('Like')  ?>
						</span>
						<!-- /like button -->
					</div>
					<div class="lw-like-dislike-box">
						<!-- dislike button -->
						<a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $userData['userUId'],'like' => 0]) ?>" data-method="post" data-callback="onLikeCallback" title="Dislike" class="lw-ajax-link-action" id="lwDislikeBtn">
							<span class="lw-animated-heart lw-animated-broken-heart <?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? 'lw-is-active' : '' ?>"
								></span>
						</a>
						<span data-model="userDislikeStatus"><?= (isset($userLikeData['like']) and $userLikeData['like'] == 0) ? __tr('Disliked') : __tr('Dislike')  ?>
						</span>
						<!-- /dislike button -->
					</div>
				</div> 
				<!-- / Like and dislike buttons -->
			</div>
			<div class="card mt-3">
				<div class="card-header">
					<?= __tr('Send a message or Gift') ?>
				</div>
				<div class="card-body text-center">
				<!-- message button -->
				<a class="mr-lg-3 btn-link btn" onclick="getChatMessenger('<?= route('user.read.individual_conversation', ['specificUserId' => $userData['userId']]) ?>')" href id="lwMessageChatButton" data-chat-loaded="false" data-toggle="modal" data-target="#messengerDialog"><i class="far fa-comments fa-3x"></i>
					<br> <?= __tr('Message') ?></a>

				<!-- send gift button -->
				<a href title="<?= __tr('Send Gift') ?>" data-toggle="modal" data-target="#lwSendGiftDialog" class="btn-link btn"><i class="fa fa-gift fa-3x" aria-hidden="true"></i>
					<br> <?= __tr('Gift') ?>
				</a>
				<!-- /send gift button -->
					</div>
				</div>
			@endif
		</li>
	@endpush
@endif


<!-- Congratulations Message Modal-->
<div class="modal fade" id="congratModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= __tr('Parabéns!') ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                PARABÉNS, Você preencheu seu perfil, agora escolha um de nossos planos PREMIUM
                <br/><br/>
                APROVEITE A PROMOÇÃO DE INAUGURAÇÃO POR TEMPO LIMITADO.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __tr('Fechar') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- /Congratulations Modal-->

<!-- /if user block then don't show profile page content -->
<style>
.credits {
    margin-top: 10px;
    background: #e9e9e9;
    border: 1px solid #aab8c2;
    font-size: 14px;
}

.credits span{
    font-size: 15px;
}

.lw-icon-btn{
	color: #319e0e;
	width: 60px;
}

.lw-icon-btn:hover{
	color: #319e0e;
}

.gift-modal p.gift-message {
    font-size: 20px;
    margin-top: 20px;
    background: #DDD;
    border-radius: 30px;
    padding: 10px;
}
.gift-modal .modal-content {
    background: transparent;
    border: none;
}

.gift-modal .modal-footer{
    border: none;
    display: block;
}

.gift-modal .lw-user-gift-container {
    width: 460px;
    height: 300px;
    font-size: 21px;
}

@media(max-width: 500px){
	.gift-modal .lw-user-gift-container {
   		width: 340px !important;
    	height: 240px !important;
    }

}

.gift-modal .lw-user-gift-container:before {
    margin-left: 46%;
}
.gift-modal .lw-user-gift-img{
    width: 26%;
    height: 40%;
    margin-top: 40px;
}


/* Photo Modal */
.photo-modal .modal-dialog {
	width: 100vw;
	margin: auto;
    max-width: unset;
    max-height: unset;

}

.photo-modal .modal-body {
	padding: 0px;
	display: flex;
}

.photo-modal .modal-content {
    height: 95%;
    background: transparent;
}

.photo-modal img.lw-user-photo {
    width: unset;
    margin: auto;
    display: flex;
 	max-width: 90%;
    max-height: 90%;
    height: inherit !important;
    object-fit: contain;
    border: none;
}

.photo-modal .photo-panel {
    background: #000000;
    height: 80vh;
    width: 70%;
    position: relative;

}

.photo-modal .comments-panel {
	width: 30%;
    background: #FFF;
    padding: 20px;
    margin-top: 0px;
    flex-wrap: wrap;
}


.photo-modal .photo-panel, .photo-modal .comments-panel { 
    display: flex;
    margin: 0px;
    height: 100vh;
    max-height: 100vh;
    overflow-y: scroll;
}

.photo-modal .close {
    font-size: 50px;
    color: #fff;
    position: absolute;
    top: 0px;
    right: 31%;
    z-index: 1000;
    display: block;
    opacity: 1;
    cursor: pointer;
}

@if(!isPremiumUser() || !$isPremiumUser)
.photo-modal .photo-panel {
	width: 100%;
}
.photo-modal .close {
    right: 1%;
}	
@endif


.btn-comment-visibility {
    border-radius: 30px;
    padding: 0px 10px;
}

@media(max-width: 768px){
	.photo-modal .modal-body {
	    flex-flow: wrap;
	}
	.photo-modal .photo-panel {
		width: 100%;
	}
	.photo-modal .comments-panel {
		width: 100%;
	    max-height: unset;
	}
	.photo-modal .close {
	    right: 1%;
	}
}

.photo-modal .modal-header {
    border-bottom: none;
}

.photo-modal .navigation.photo-navigation {
    position: absolute;
    top: 45%;
    color: #FFF;
    font-size: 40px;
    width: 100%;
    padding: 0px 10px;
}

@media(max-width: 768px){
	.photo-modal .navigation.photo-navigation {
		font-size: 30px;
	}
}

@media(max-width: 425px){
	.photo-modal .navigation.photo-navigation {
		font-size: 25px;
	}
}

.photo-modal .photo-navigation div {
    cursor: pointer;
}

.photo-modal .photo-navigation .next {
    float: right;
}

.photo-modal .photo-navigation .previous {
    float: left;
}

.photo-modal .comment-list {
    width: 100%;
}
.photo-modal .comment {
    background: #f3f2f2;
    border: 1px solid #e5e5e5;
    margin-bottom: 7px;
    padding: 5px 10px;
    text-align: left;
    position: relative;
    display: inline-block;
    border-radius: 20px;
    max-width: 470px;
    width: 100%;
}

.photo-modal a.by {
	display: block;
    margin-right: 10px;
    color: #000000;
    font-weight: bold;
}

.photo-modal span.date {
    font-size: 12px;
}

.photo-modal .more {
    text-align: left;
    margin-bottom: 20px;
    padding: 0px 10px;
}

.photo-modal .more span.action {
    cursor: pointer;
    margin-right: 10px;
}

.photo-modal .more span.action:hover {
    text-decoration: underline;
}

.photo-modal .new-comment {
	text-align: left;
    width: 100%;
    margin: auto;
    border-bottom: 1px solid #DDD;
    margin-bottom: 30px;
}
</style>
@push('appScripts')
@if(getStoreSettings('allow_google_map'))
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key') ?>&libraries=places&callback=initialize" async defer></script>
@endif
<script>

	$(document).ready(function(){
		$('.phone_with_ddd').mask('(00) 00000-0000');
		$('.date').mask('00/00/0000');
		getBoleto();
	});

    // Get user profile data
    function getUserProfileData(response) {
        // If successfully stored data
        if (response.reaction == 1) {
            __DataRequest.get("<?= route('user.get_profile_data', ['username' => getUserAuthInfo('profile.username')]) ?>", {}, function(responseData) {
                var requestData = responseData.data;
                var specificationUpdateData = [];
                _.forEach(requestData.userSpecificationData, function(specification) {
                    _.forEach(specification['items'], function(item) {
                        specificationUpdateData[item.name] = item.value;
                    });
                });
                __DataRequest.updateModels('userData', requestData.userData);
                __DataRequest.updateModels('profileData', requestData.userProfileData);
                __DataRequest.updateModels('specificationData', specificationUpdateData);

                if(requestData.showCompletedModal){
                	$("#congratModal").modal("show");
                }
            });
        }
    }

	function getBoleto() {
		
		// aqui eu pego boletos que foram pagos e não forma creditados ao usuário
		urlStatus = __Utils.apiURL("<?= route('get.user.status.boleto', ['userUid' => $userData['userUId']]) ?>");

		// faço uma chamada ajax
		$.ajax({
			url: urlStatus,
			type: "GET",
			error: function(jqXHR, textStatus, errorThrown) {
				// Aqui você pode acessar os detalhes do erro
				console.log('Ocorreu um erro 1: ' + errorThrown);
  			},
			success: function(resp){
				// se foi encontrado algum valor na tabela pre_orders ele restorna o resultado
				if(resp){
					var planId = resp["packge_plans"],
					orderCode = resp["code"],
					reffId = resp["id"];

					var requestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.pagseguro_plan_transaction_complete_boleto', ['planId' => 'planId']) ?>", {'planId': planId});

					$.ajax({
						url: requestUrl,
						type: "GET",
						data: {id: orderCode },
						error: function(jqXHR, textStatus, errorThrown) {
							// Aqui você pode acessar os detalhes do erro
							console.log('Ocorreu um erro: ' + errorThrown);
						},
						success: function(resp){
					
							var payed = true,
							payedUrl = __Utils.apiURL("<?= route('set.user.status.boleto.payed')?>");

							$.ajax({
								headers: {
       								'X-CSRF-TOKEN': "<?= csrf_token() ?>"
   								},
								url: payedUrl,
								type: 'POST',
								data:{
									status: payed,
									reffId: reffId,
								},
								error: function(jqXHR, textStatus, errorThrown) {
									// Aqui você pode acessar os detalhes do erro
									console.log('Ocorreu um erro: ' + errorThrown);
								},success: function(resp){
									location.reload();
								}
							})
						}
					});
				}else{
					console.log("Não foi encontrado nenhuma pre_order")
				}

			}
			
		});
	}

	function handlePaymentCallbackEvent(response) {
		//hide payment options
		$("#lwPaymentOption").hide();
		//hide loader after ajax request complete
		$(".lw-show-till-loading").hide();
		//after process on server enable payment button block
		$("#lwPaymentOption").removeClass('lw-disabled-block-content');
		//check reaction code is 1
		if (response.reaction == 1) {
			//show confirmation 
			showConfirmation('Pagamento realizado com sucesso', null, {
				buttons: [
					Noty.button('<?= __tr('Reload to Update') ?>', 'btn btn-secondary btn-sm', function () {
						__Utils.viewReload();
						return;
					})
				]
			});
			//load transaction list data function
			_.defer(function() {
				reloadTransactionTable();
			});
			//bind error message on div
			$("#lwSuccessMessage").text(response.data.message);
			//show div
			$("#lwSuccessMessage").toggle();
			_.delay(function() {
				//hide div
				$("#lwSuccessMessage").toggle();
			}, 10000);
		} else {
			//bind error message on div
			$("#lwErrorMessage").text(response.data.errorMessage);
			//show hide div
			$("#lwErrorMessage").toggle();
			_.delay(function() {
				//hide div
				$("#lwErrorMessage").toggle();
			}, 10000);
		}
	}


	/**************** User Like Dislike Fetch and Callback Block Start ******************/
	//add disabled anchor tag class on click
	$(".lw-like-action-btn, .lw-dislike-action-btn").on('click', function() {
		$('.lw-like-dislike-box').addClass("lw-disable-anchor-tag");
	});
	//on like Callback function
	function onLikeCallback(response) {
		var requestData = response.data;
		//check reaction code is 1 and status created or updated and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && (requestData.status == "created" || requestData.status == 'updated')) {
			__DataRequest.updateModels({
				'userLikeStatus' 	: '<?= __tr('Liked') ?>', //user liked status
				'userDislikeStatus' : '<?= __tr('Dislike') ?>', //user dislike status
			});
			//add class
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
			//check if updated then remove class in dislike heart
			if (requestData.status == 'updated') {
				$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			}
		}
		//check reaction code is 1 and status created or updated and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && (requestData.status == "created" || requestData.status == 'updated')) {
			__DataRequest.updateModels({
				'userLikeStatus' 	: '<?= __tr('Like') ?>', //user like status
				'userDislikeStatus' : '<?= __tr('Disliked') ?>', //user disliked status
			});
			//add class
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			//check if updated then remove class in like heart
			if (requestData.status == 'updated') {
				$(".lw-animated-like-heart").toggleClass("lw-is-active");
			}
		}
		//check reaction code is 1 and status deleted and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userLikeStatus' 	: '<?= __tr('Like') ?>', //user like status
			});
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
		}
		//check reaction code is 1 and status deleted and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userDislikeStatus' 	: '<?= __tr('Dislike') ?>', //user like status
			});
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
		}
		//remove disabled anchor tag class
		_.delay(function() {
			$('.lw-like-dislike-box').removeClass("lw-disable-anchor-tag");
		}, 1000);
	}
	/**************** User Like Dislike Fetch and Callback Block End ******************/

	
	//gift-message
	$('.gift-modal').on('shown.bs.modal', function (e) {
	  $("#" + e.currentTarget.id + " .gift-message").show();
	  console.log('Element', e.currentTarget.id);
	});

	//close Send Gift Dialog
	$("#lwCloseSendGiftDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwSendGiftForm").trigger("reset");
		//close dialog after success
		$('#lwSendGiftDialog').modal('hide');
	});

	//user report callback
	function userReportCallback(response) {
		//check success reaction is 1
		if (response.reaction == 1) {
			var requestData = response.data;
			//form reset after success
			$("#lwReportUserForm").trigger("reset");
			//close dialog after success
			$('#lwReportUserDialog').modal('hide');
			//reload view after 2 seconds on success reaction
			_.delay(function() {
				__Utils.viewReload();
			}, 1000)
		}
	}

	//close User Report Dialog
	$("#lwCloseUserReportDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwReportUserForm").trigger("reset");
		//close dialog after success
		$('#lwReportUserDialog').modal('hide');
	});

	//block user confirmation
	$("#lwBlockUserBtn").on('click', function(e) {
		var confirmText = $('#lwBlockUserConfirmationText');
		//show confirmation 
		showConfirmation(confirmText, function() {
			var requestUrl = '<?= route('user.write.block_user') ?>',
				formData = {
					'block_user_id' : '<?= $userData['userUId'] ?>',
				};					
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					__Utils.viewReload();
				}
			});
		});
    });
    
    // Click on edit / close button 
    $('#lwEditBasicInformation').click(function(e) {
        e.preventDefault();
        showHideBasicInfoContainer();
    });

     $('#lwCloseBasicInfoEditBlock').click(function(e) {
        e.preventDefault();
        $(".lw-form-profile").submit();
        showHideBasicInfoContainer();
    });
    // Show / Hide basic information container
    function showHideBasicInfoContainer() {
        $('#lwUserBasicInformationForm').toggle();
        $('#lwStaticBasicInformation').toggle();
        $('#lwCloseBasicInfoEditBlock').toggle();
        $('#lwEditBasicInformation').toggle();
    }
    // Show hide specification user settings
    function showHideSpecificationUser(formId, event) {
        event.preventDefault();
        $('#lwEdit'+formId).toggle();
        $('#lw'+formId+'StaticContainer').toggle();
        $('#lwUser'+formId+'Form').toggle();
        $('#lwClose'+formId+'Block').toggle();
    }
    // Click on profile and cover container edit / close button 
    $('#lwEditProfileAndCoverPhoto, #lwCloseProfileAndCoverBlock').click(function(e) {
        e.preventDefault();
        showHideProfileAndCoverPhotoContainer();
    });
    // Hide / show profile and cover photo container
    function showHideProfileAndCoverPhotoContainer() {
        $('#lwProfileAndCoverStaticBlock').toggle();
        $('#lwProfileAndCoverEditBlock').toggle();
        $('#lwEditProfileAndCoverPhoto').toggle();
        $('#lwCloseProfileAndCoverBlock').toggle();
    }
     // After successfully upload profile picture
    function afterUploadedProfilePicture(responseData) {
        $('#lwProfilePictureStaticImage, .lw-profile-thumbnail').attr('src', responseData.data.image_url);
    }
    // After successfully upload Cover photo
    function afterUploadedCoverPhoto(responseData) {
        $('#lwCoverPhotoStaticImage').attr('src', responseData.data.image_url);
    }
</script>
<script>
// Click on edit / close button 
$('#lwEditUserLocation, #lwCloseLocationBlock').click(function(e) {
    e.preventDefault();
    showHideLocationContainer();
});
// Show hide location container
function showHideLocationContainer() {
    $('#lwUserStaticLocation').toggle();
    $('#lwUserEditableLocation').toggle();
    $('#lwEditUserLocation').toggle();
    $('#lwCloseLocationBlock').toggle();
}

function initialize() {

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 13
        });
        const marker = new google.maps.Marker({
            map: map,
            position: {lat: latitude, lng: longitude},
        });

        marker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(false);
            const place = autocomplete.getPlace();

            geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng, place);
                }
            });

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

        });
    }
}

function setLocationCoordinates(key, lat, lng, placeData) {
    __DataRequest.post("<?= route('user.write.location_data') ?>", {
        'latitude': lat,
        'longitude': lng,
        'placeData': placeData.address_components
    }, function(responseData) {
        showHideLocationContainer();
        var requestData = responseData.data;
        __DataRequest.updateModels('profileData', {
            city: requestData.city,
            country_name: requestData.country_name,
            latitude: lat,
            longitude: lng
        });
        var mapSrc = "https://maps.google.com/maps/place?q="+lat+","+lng+"&output=embed";
        $('#gmap_canvas').attr('src', mapSrc)
    });
};

// $(".lw-animated-heart").on("click", function() {
//     $(this).toggleClass("lw-is-active");
// });

function getPhotoComments(image_uid, key){
	 __DataRequest.get("/api/photo/get-comments/"+ image_uid + "/" + <?= getUserID()?>, {}, function(responseData) {
       	console.log(responseData);
       	$('[data-source='+image_uid+'] .comment-list').html(responseData.data.html);
    });
}

var photos = <?= json_encode($photosData) ?>;
if(photos.length > 0){
	photos.forEach(function(photo){
		$('[data-source='+photo.image_uid+']').on('shown.bs.modal', function (e) {
			getPhotoComments(photo.image_uid);
		});
	});
}

function changeCommentVisibility(response){
	getPhotoComments(response.data.image_uid);
}

function onCreateComment(response){
	$('[name=comment]').val("");
	getPhotoComments(response.data.image_uid);
}

var total = <?= count($photosData) ?> - 1;

function updateNavigation(index){
	console.log("index", index);

	if(index  >= total){
		$(".photo-navigation .next").hide();
	} else {
		$(".photo-navigation .next").show();
	}

	if(index <= 0){
		$(".photo-navigation .previous").hide();
	} else {
		$(".photo-navigation .previous").show();
	}
}

updateNavigation(0);

function navigationNext(index){
	if(index < total){
		var next = index + 1;
		$("#photo_modal_" + index).modal("hide");
		$("#photo_modal_" + next).modal("show");
		updateNavigation(next);

	}
}

function navigationPrevious(index){
	if(index > 0){
		var previous = index - 1;
		$("#photo_modal_" + index).modal("hide");
		$("#photo_modal_" + previous).modal("show");
		updateNavigation(previous);

	}	
}
	

</script>
@endpush

