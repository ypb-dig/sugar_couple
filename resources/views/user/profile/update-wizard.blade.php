@section('page-title', __tr('Update Profile'))
@section('head-title', __tr('Update Profile'))
@section('keywordName', __tr('Update Profile'))
@section('keyword', __tr('Update Profile'))
@section('description', __tr('Update Profile'))
@section('keywordDescription', __tr('Update Profile'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- include header -->
@include('includes.header')
<!-- /include header -->
<body class="_bg-gradient-primary lw-login-register-page">
    <!-- include navbar -->
    @include('includes.landing-navbar')
    <!-- /include navbar -->
    <div class="lw-page-bg"></div>
    <div class="container">
         <!-- SmartWizard html -->

        <div class="card mt-5">
            <div class="card-body text-center">
                <img class="lw-logo-img hide" src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>">
                <a class="float-right" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw"></i><strong><?= __tr('Logout') ?></strong>
                </a>
                <hr>
                <h5>
                	<?= __tr('Please complete your profile') ?>
            	</h5>
            </div>
        </div>
		<div id="smartwizard" class="lw-update-wizard">
		    <ul class="justify-content-center d-none d-md-flex">
		        <li>
		        	<a class="h5" href="#step-1"><i class="fas fa-images"></i><br><?= __tr('Profile Pictures') ?></a>
			    </li>
		        <li>
		        	<a class="h5" href="#step-2"><i class="fas fa-map-marker-alt"></i><br><?= __tr('Choose Location') ?>
			        </a>
			    </li>
			    <li>
                    <a class="h5" href="#step-3"><i class="fas fa-check"></i><br><?= __tr('Finished') ?>
			        </a>
			    </li>
		    </ul>

		    <div>
		        <div id="step-1" class="">
		            <div class="row">
		            	<div class="col-lg-12">
			            	<div class="pb-3">
			            		<!-- User Basic Information Form -->
								<form class="lw-ajax-form lw-form" lwSubmitOnChange method="post" data-show-message="true" action="<?= route('user.write.update_profile_wizard') ?>" data-callback="checkProfileStatus">

									<div class="form-row">
					            		<!-- Look for  -->
										<div class="col-lg-4">
			                                <label for="looking_for"><?= __tr('Busco por') ?></label>
			                                <select name="looking_for" data-toggle="tooltip" data-placement="top" title="Selecione o que você busca" class="form-control" id="looking_for">
												<option value="" selected disabled><?= __tr('Eu busco por') ?></option>
												@foreach($genders as $genderKey => $gender)
													@if($profileInfo['gender'] <= 2 && $genderKey == 3)
													<option value="<?= $genderKey ?>" <?= (__ifIsset($profileInfo['looking_for']) and $genderKey == $profileInfo['looking_for']) ? 'selected' : '' ?>><?= __tr('Mulher') ?></option>
													@endif
													@if($profileInfo['gender'] <= 2 && $genderKey == 4)
													<option value="<?= $genderKey ?>" <?= (__ifIsset($profileInfo['looking_for']) and $genderKey == $profileInfo['looking_for']) ? 'selected' : '' ?>><?= __tr('Homem') ?></option>
													@endif
													@if($profileInfo['gender'] >= 3 && $genderKey == 1)
													<option value="<?= $genderKey ?>" <?= (__ifIsset($profileInfo['looking_for']) and $genderKey == $profileInfo['looking_for']) ? 'selected' : '' ?>><?= __tr('Homem') ?></option>
													@endif
													@if($profileInfo['gender'] >= 3 && $genderKey == 2)
													<option value="<?= $genderKey ?>" <?= (__ifIsset($profileInfo['looking_for']) and $genderKey == $profileInfo['looking_for']) ? 'selected' : '' ?>><?= __tr('Mulher') ?></option>
													@endif
												@endforeach
												<option value="5" <?= (__ifIsset($profileInfo['looking_for']) and 5 == $profileInfo['looking_for']) ? 'selected' : '' ?>><?= __tr('Ambos') ?></option>
											</select>
										</div>								
									</div>
									<div class="form-row hide">
					            		<!-- Birthday -->
										<div class="col-lg-4">
			                                <label for="birthday"><?= __tr('Birthday') ?></label>
			                                <input type="text" name="birthday" value="<?= __ifIsset($profileInfo['birthday'], $profileInfo['birthday']) ?>" placeholder="<?= __tr('DD/MM/AAAA') ?>" class="form-control" required>
										</div>
										<!-- /Birthday -->
										<div class="col-lg-4">
											<label for="select_gender"><?= __tr('Eu sou') ?></label>
											<select name="gender" class="form-control" id="select_gender">
												<option value="" selected disabled><?= __tr('Eu sou') ?></option>
												@foreach($genders as $genderKey => $gender)
													<option value="<?= $genderKey ?>" <?= (__ifIsset($profileInfo['gender']) and $genderKey == $profileInfo['gender']) ? 'selected' : '' ?>><?= $gender ?></option>
												@endforeach
											</select>
										</div>
									</div>
								</form>
			            	</div>
			            </div>
			            <div class="col-lg-12">
			            	<hr class="">
			            	<div class="pt-3">
			            		<div class="row" id="lwProfileAndCoverEditBlock">
				                    <div class="col-lg-4 offset-lg-4 mt-4">
				                        <input type="file" 
				                            name="filepond"
				                            class="filepond lw-file-uploader"
				                            id="lwFileUploader" 
				                            data-remove-media="false"
				                            data-allowed-media='<?= getMediaRestriction('profile') ?>'
				                            data-callback="checkProfileStatus"
				                            data-default-image-url="<?= $profileInfo['profile_picture_url'] ?>"
				                            data-instant-upload="true" 
				                            data-action="<?= route('user.upload_profile_image') ?>"
				                            data-label-idle="<span class='filepond--label-action'>Procurar</span>"
				                            data-image-preview-height="170"
				                            data-image-crop-aspect-ratio="1:1"
				                            data-style-panel-layout="compact circle"
				                            data-style-load-indicator-position="center bottom"
				                            data-style-progress-indicator-position="right bottom"
				                            data-style-button-remove-item-position="left bottom"
				                            data-style-button-process-item-position="right bottom"s>
				                    </div>
				                   <!--  <div class="col-lg-8 hide">
				                        <input type="file" 
				                            name="filepond"
				                            class="filepond lw-file-uploader"
				                            id="lwFileUploader" 
				                            data-allowed-media='<?= getMediaRestriction('profile') ?>'
				                            data-default-image-url="<?= $profileInfo['cover_picture_url'] ?>"
				                            data-remove-media="false"
				                            data-instant-upload="true" 
				                            data-action="<?= route('user.upload_cover_image') ?>"
				                            data-callback="checkProfileStatus"
				                            data-label-idle="<span class='filepond--label-action'>Procurar</span>">
				                    </div> -->
				                </div>
			            	</div>
			            </div>
			            
		            </div>
		        </div>
		        <div id="step-2" class="">
		            <h3 class="border-bottom border-gray pb-2">Step 2 <i class="fas fa-map-marker-alt"></i> <?= __tr('Location') ?></h3> 
		            <small> Sua localização não será compartilhada com nenhum outro usuário </small>
			        <div class="card-body">
						@if(getStoreSettings('allow_google_map'))
			            <div id="lwUserEditableLocation">
			            	<div class="form-group">
			                    <label for="address_address"><?= __tr('Tipo de Endereço') ?></label><br/>
			                    <input type="radio" name="address_type_input" onchange="changeAddressType()" class="form-control_" value="neighborhood"> Somente Bairro<br/>
			                    <input type="radio" name="address_type_input" onchange="changeAddressType()" class="form-control_" value="complete" checked="true"> Endereço Completo			      
			                </div>
			                <div class="form-group">
			                    <label for="address_address"><?= __tr('Location') ?></label>
			                    <input type="text" id="address-input" name="address_address" class="form-control map-input">
			                    <input type="hidden" name="address_latitude" id="address-latitude" value="<?= $profileInfo['location_latitude'] ?>" />
			                    <input type="hidden" name="address_longitude" id="address-longitude" value="<?= $profileInfo['location_longitude'] ?>" />
			                    <input type="hidden" name="address" id="address" value="<?= $profileInfo['address'] ?>" />
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
							<!-- / info message -->
						@endif
			        </div>
		        </div>
		        <div id="step-3" class="">
		            <h2 class="text-center p-5">
		            	<?= __tr('Congratulations') ?>
		            </h2>
		            <div class="text-center ">
		            	<a href class="btn btn-primary p-3 text-white lw-ajax-link-action" data-method="post" data-action="<?= route('user.profile.finish_wizard') ?>" data-callback="finishWizardCallback"> <strong><?= __tr('Ir para pagina de perfil') ?></strong></a>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
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
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __tr('Cancel') ?></button>
                    <a class="btn btn-primary" href="<?= route('user.logout') ?>"><?= __tr('Logout') ?></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Logout Modal-->
</body>
@push('appScripts')

<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAP_KEY') ?>&libraries=places&callback=initialize" async defer></script>
<script type="text/javascript">

	//set buttons
    function setButtons(stepNumber, stepsStatus) {
    	if (stepNumber == 0) {
			if (stepsStatus.step_one) {
				$(".sw-btn-next").attr('disabled', false);
			} else {
				//$(".sw-btn-prev").attr('disabled', true);
				$(".sw-btn-next").attr('disabled', true);				
			}
		}
		if (stepNumber == 1) {
			if (!stepsStatus.step_two) {
				$(".sw-btn-next").attr('disabled', true);
			} else {
				$(".sw-btn-next").attr('disabled', false);
			}
		}
    }

    var stepNumber = 0;
    //load steps status
    var stepsStatus = <?= json_encode($profileStatus) ?>;
	
	checkProfileStatus = function () {
		__DataRequest.get("<?= route('user.profile.wizard_completed')?>", {}, function(response) {
			stepsStatus = response.data.profileStatus;
			setButtons(stepNumber, stepsStatus);
		},{});
	};

	finishWizardCallback = function (response) {
		if (_.has(response.data, 'redirectURL')) {
			window.location = response.data.redirectURL;
		}
	};

    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'dots',
        transitionEffect:'fade',
        showStepURLhash: false,
        transitionEffect : "none",
        transitionSpeed: '0',
        toolbarSettings: {
			toolbarPosition: 'bottom',
			showPreviousButton : true,
			showNextButton : true,
        }
    });

    // Step show event
    $("#smartwizard")
    	.on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
			e.preventDefault();
			stepNumber = stepNumber;
			if(stepNumber == 2){
				$(".sw-btn-prev").hide();
				$(".sw-btn-next").hide();
			}

			//checkProfileStatus(stepNumber);
			setButtons(stepNumber, stepsStatus);
    });

	setButtons(stepNumber, stepsStatus);

 	function changeAddressType(){
 		var type = $("input[name=address_type_input]").val();
 		if(type == "complete"){
			initialize();
 		} else {
			initialize("(regions)");
 		}
 	}

    function initialize(type) {

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

	        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -23.552133;
	        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || -46.6373606;

	        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
	            center: {lat: latitude, lng: longitude},
	            zoom: 13
	        });
	        const marker = new google.maps.Marker({
	            map: map,
	            position: {lat: latitude, lng: longitude},
	        });

	        marker.setVisible(isEdit);

	        if(type){
				var options = {
				  types: [type]
				};
			}else {
				var options = {
				  types: ['address']
			  	};
			}

	        var autocomplete = new google.maps.places.Autocomplete(input, options);

			var infoWindow = new google.maps.InfoWindow;

	   		// Try HTML5 geolocation.
	        if (navigator.geolocation) {
	          navigator.geolocation.getCurrentPosition(function(position) {
	            var pos = {
	              lat: position.coords.latitude,
	              lng: position.coords.longitude
	            };

	            infoWindow.setPosition(pos);
	            infoWindow.setContent('Sua localização');
	            //infoWindow.open(map);
	            map.setCenter(pos);
	            map.setZoom(17);

				var circle = new google.maps.Circle(
          			{
	          			center: pos, 
	          			radius: position.coords.accuracy
          			}
          		);
     			autocomplete.setBounds(circle.getBounds());

	            geocoder.geocode({'location': pos}, function (results, status) {
	                if (status === google.maps.GeocoderStatus.OK) {
	                    const lat = results[0].geometry.location.lat();
	                    const lng = results[0].geometry.location.lng();
	                    setLocationCoordinates(autocomplete.key, lat, lng, results[0]);
	                    $("input[name=address_address]").val(results[0].formatted_address);
	                }
	            });

	          }, function() {
	            handleLocationError(true, infoWindow, map.getCenter());
	          });
	        } else {
	          // Browser doesn't support Geolocation
	          handleLocationError(false, infoWindow, map.getCenter());
	        }

			function handleLocationError(browserHasGeolocation, infoWindow, pos) {
				infoWindow.setPosition(pos);
				infoWindow.setContent(browserHasGeolocation ?
				                      'Error: The Geolocation service failed.' :
				                      'Error: Your browser doesn\'t support geolocation.');
				infoWindow.open(map);
			}

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
	                window.alert("Endereço não localizado: '" + place.name + "'");
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
	        var requestData = responseData.data;
	        __DataRequest.updateModels('profileData', {
	            city: requestData.city,
	            country_name: requestData.country_name
	        });

	        if (responseData.reaction == 1) {
	        	_.defer(function() {
	        		checkProfileStatus();
	        	});
	        }

	        var mapSrc = "https://maps.google.com/maps/place?q="+lat+","+lng+"&output=embed";
	        $('#gmap_canvas').attr('src', mapSrc);
	    });
	};

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

                __DataRequest.updateModels('profileData', requestData.userProfileData);

            });
        }
    }
</script>
@endpush

<!-- include footer -->
@include('includes.footer')
<!-- /include footer -->