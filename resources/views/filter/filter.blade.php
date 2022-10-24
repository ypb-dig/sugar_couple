@section('page-title', __tr('Find Matches'))
@section('head-title', __tr('Find Matches'))
@section('keywordName', __tr('Find Matches'))
@section('keyword', __tr('Find Matches'))
@section('description', __tr('Find Matches'))
@section('keywordDescription', __tr('Find Matches'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h5 class="h5 mb-0 text-gray-200">
        <span class="text-primary"><i class="fas fa-search" aria-hidden="true"></i></span>
        <?= __tr('Find Matches') ?>
    </h5>
</div>

<?php
    $usergender = getUserGender();
    $lookingFor = userIslookingFor();
    $minAge = getUserSettings('min_age');
    $maxAge = getUserSettings('max_age');

    if (request()->session()->has('userSearchData')) {
        $userSearchData = session('userSearchData');
        $lookingFor = $userSearchData['looking_for'];
        $minAge = $userSearchData['min_age'];
        $maxAge = $userSearchData['max_age'];
        $username_f = $userSearchData['username_f'];
    }
?>


<!-- Page Heading -->
<div class="card lw-find-form-container mb-4 ">
    <div class="card-body">
    <form class="form-inline mr-auto" data-show-processing="true" action="<?= route('user.read.find_matches') ?>">
            <div class="lw-username-container lw-basic-filter-field ">
                <label class="justify-content-start" for="username_f"><?= __tr('Nome de usuário') ?></label>
                <input type="text" class="form-control" autocomplete="no" name="username_f"
                value="<?= (request()->username_f != null) ? request()->username_f : getUserSettings('username_f') ?>">
            </div>
            <div class="lw-username-container lw-basic-filter-field ">
                <label class="justify-content-start" for="location"><?= __tr('Localização') ?></label>
                <input type="text" class="form-control map-input" autocomplete="no" name="location" id="location"
                value="<?= (request()->location != null) ? request()->location : getUserSettings('location') ?>">
            </div>
            <!-- Looking For -->
            <div class="lw-looking-for-container lw-basic-filter-field hide">
                <label for="lookingFor"><?= __tr('Looking For') ?></label>
                <select name="looking_for" class="form-control" id="lookingFor">
                    @foreach(configItem('user_settings.gender') as $genderKey => $gender)
                        @if( $genderKey == $lookingFor)
                        <option value="<?= $genderKey ?>" <?= (request()->looking_for == $genderKey or $genderKey == $lookingFor) ? 'selected' : '' ?>><?= $gender ?></option>
                        @endif                       
                    @endforeach
                </select>
            </div>
            <!-- /Looking For -->
            <!-- Age between -->
            <div class="lw-age-between-container lw-basic-filter-field">
                <label for="minAge"><?= __tr('Age Between') ?></label>
                <select name="min_age" class="form-control" id="minAge">
                    @foreach(range(18,70) as $age)
                        <option value="<?= $age ?>" <?= (request()->min_age == $age or $age == $minAge) ? 'selected' : '' ?>><?= __tr('__translatedAge__', [
                            '__translatedAge__' => $age
                        ]) ?></option>
                    @endforeach
                </select>
                <select name="max_age" class="form-control" id="maxAge">
                    @foreach(range(18,70) as $age)
                        <option value="<?= $age ?>" <?= (request()->max_age == $age or $age == $maxAge) ? 'selected' : '' ?>><?= __tr('__translatedAge__', [
                            '__translatedAge__' => $age
                        ]) ?></option>
                    @endforeach
                </select>
            </div>
            <!-- Order By -->
            <div class="lw-age-between-container lw-basic-filter-field">
                <label for="minAge"><?= __tr('Ordenar por') ?></label>
                <select name="orderby" class="form-control" id="orderBy" onchange="changeOrderBy()">         
                    <option value="online" <?= (request()->orderby == 'online') ? 'selected' : '' ?>>Online</option>
                    <option value="relevancia" <?= (request()->orderby == 'relevancia') ? 'selected' : '' ?>>Por Relevância</option>
                     <option value="new" <?= (request()->orderby == 'new') ? 'selected' : '' ?>>Novos Cadastros</option>
                    <option value="updated_profiles" <?= (request()->orderby == 'updated_profiles') ? 'selected' : '' ?>>Perfis atualizados</option>

                </select>               
            </div>
            <!-- /Order By -->
            <!-- /Age between -->
            <!-- Distance from my location -->
            <input type="hidden" name="lat"/>
            <input type="hidden" name="lng"/>

            <div class="lw-distance-location-container lw-basic-filter-field hide">
                <label class="justify-content-start" for="distance"><?= __tr('Distance in __distanceUnit__', ['__distanceUnit__' =>( getStoreSettings('distance_measurement') == '6371') ? 'KM' : 'Miles']) ?></label>
                <input type="text" class="form-control" name="distance"
                value="<?= (request()->distance != null) ? request()->distance : getUserSettings('distance') ?>" placeholder="<?= __tr('Anywhere') ?>">
            </div>
            <!-- /Distance from my location -->
            <div class="lw-basic-filter-footer-container lw-basic-filter-field">
                <button type="submit" class="btn btn-primary"><?= __tr('Search') ?></button>
                <a href class="btn btn-secondary" style="<?= !__isEmpty(request()->is_advance_filter) ? 'display: none;' : '' ?>" id="lwShowAdvanceFilterLink"><i class="fas fa-filter"></i> <?= __tr('Show Advance Filter') ?></a>
                <a href class="btn btn-secondary" style="<?= __isEmpty(request()->is_advance_filter) ? 'display: none;' : '' ?>" id="lwHideAdvanceFilterLink"><i class="fas fa-filter"></i> <?= __tr('Hide Advance Filter') ?></a>
            </div>
            
        </form>
        <script>
            function changeOrderBy(){
                $('.form-inline').submit();
            }
        </script>
</div>
</div>

<!-- Found matches container -->
    <!-- Advance Filter Options -->
    <div class="lw-advance-filter-container <?= !__isEmpty(request()->is_advance_filter) ? 'lw-expand-filter' : '' ?>">
        <div class="lw-filter-message text-secondary">
        </div>
        <!-- Tabs for advance filter -->
        <div class="lw-advance-filter-tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <!-- Personal Tab -->
                <li class="nav-item">
                    <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">
                        <i class="fas fa-info-circle"></i> <?= __tr('Personal') ?>
                    </a>
                </li>
                <!-- /Personal Tab -->
                @foreach($userSpecifications['groups'] as $specKey => $specification)
                    @if($specKey != 'favorites')
                    <li class="nav-item">
                        <a class="nav-link" id="<?= $specKey ?>-tab" data-toggle="tab" href="#<?= $specKey ?>" role="tab" aria-controls="<?= $specKey ?>" aria-selected="false">
                            <?= $specification['title'] ?>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
            <form class="" action="<?= route('user.read.find_matches') ?>">
                <div class="tab-content" id="lwAdvanceFilterTabContent">
                    <input type="hidden" name="is_advance_filter" value="yes">
                    <!-- Hidden field of basic filter -->
                    <input type="hidden" name="looking_for" value="<?= (!__isEmpty(request()->looking_for)) ? request()->looking_for : getUserSettings('looking_for') ?>">
                    <input type="hidden" name="min_age" value="<?= (!__isEmpty(request()->min_age)) ? request()->min_age : getUserSettings('min_age') ?>">
                    <input type="hidden" name="max_age" value="<?= (!__isEmpty(request()->max_age)) ? request()->max_age : getUserSettings('max_age') ?>">
                    <input type="hidden" name="distance" value="<?= (!__isEmpty(request()->distance)) ? request()->distance : getUserSettings('distance') ?>">
                    <!-- /Hidden field of basic filter -->

                    <!-- Personal Tab Content -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <div class="lw-specification-sub-heading hide">
                            <?= __tr('Language') ?>
                        </div>
                        <!-- Language -->
                        <div class="row hide">
                            @foreach($userSettings['preferred_language'] as $langKey => $language)
                            <div class="col-sm-12 col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="language[<?= $langKey  ?>]" name="language[<?= $langKey  ?>]" value="<?= $langKey  ?>" <?= (!__isEmpty(request()->language) and array_key_exists($langKey, request()->language)) ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="language[<?= $langKey  ?>]"><?= $language ?></label>
                                </div>
                            </div>
                            @endforeach
                        </div> 
                        <!-- /Language -->
                        <!-- Relationship Status -->
                        <div class="lw-specification-sub-heading">
                            <?= __tr('Relationship Status') ?>
                        </div>
                        <div class="row">
                            @foreach($userSettings['relationship_status'] as $relStatusKey => $relationship)
                            <div class="col-sm-12 col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="relationship_status[<?= $relStatusKey  ?>]" name="relationship_status[<?= $relStatusKey  ?>]" value="<?= $relStatusKey  ?>" <?= (!__isEmpty(request()->relationship_status) and array_key_exists($relStatusKey, request()->relationship_status)) ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="relationship_status[<?= $relStatusKey  ?>]"><?= $relationship ?></label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- /Relationship Status -->
                        
                        <!-- Work Status -->
                        <div class="lw-specification-sub-heading">
                            <?= __tr('Work Status') ?>
                        </div>
                        <div class="row">
                            @foreach($userSettings['work_status'] as $workStatusKey => $workStatus)
                            <div class="col-sm-12 col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="work_status[<?= $workStatusKey  ?>]" name="work_status[<?= $workStatusKey  ?>]" value="<?= $workStatusKey  ?>" <?= (!__isEmpty(request()->work_status) and array_key_exists($workStatusKey, request()->work_status)) ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="work_status[<?= $workStatusKey  ?>]"><?= $workStatus ?></label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- /Work Status -->
                        
                        <!-- Education -->
                        <div class="lw-specification-sub-heading">
                            <?= __tr('Education') ?>
                        </div>
                        <div class="row">
                            @foreach($userSettings['educations'] as $educationKey => $education)
                            <div class="col-sm-12 col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="education[<?= $educationKey  ?>]" name="education[<?= $educationKey  ?>]" value="<?= $educationKey  ?>" <?= (!__isEmpty(request()->education) and array_key_exists($educationKey, request()->education)) ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="education[<?= $educationKey  ?>]"><?= $education ?></label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- /Education -->
                    </div>
                    <!-- /Personal Tab Content -->
                    <!-- Other Tab Content -->
                    @foreach($userSpecifications['groups'] as $specKey => $specifications)
                    @if($specKey != 'favorites')
                        <div class="tab-pane fade" id="<?= $specKey ?>" role="tabpanel" aria-labelledby="<?= $specKey ?>-tab">
                            @foreach(collect($specifications['items'])->chunk(3) as $specification)
                                @foreach($specification as $itemKey => $item)
                                    @if($item['input_type'] == 'select')
                                        @if($itemKey == 'height')
                                            <div class="lw-specification-sub-heading">
                                                <?= $item['name'] ?>
                                            </div>
                                            <div class="lw-specification-select-box">
                                                <select name="min_height" class="form-control" id="min_height">
                                                <option value="" selected><?= __tr('Select Min Height') ?></option>
                                                @foreach($item['options'] as $optionKey => $option)
                                                    <option value="<?= $optionKey ?>" <?= (request()->min_height == $optionKey) ? 'selected'  : '' ?>><?= $option ?></option>
                                                @endforeach
                                                </select>
                                                <select name="max_height" class="form-control" id="max_height">
                                                <option value="" selected><?= __tr('Select Max Height') ?></option>
                                                @foreach($item['options'] as $optionKey => $option)
                                                    <option value="<?= $optionKey ?>" <?= (request()->max_height == $optionKey) ? 'selected'  : '' ?>><?= $option ?></option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="lw-specification-sub-heading">
                                                <?= $item['name'] ?>
                                            </div>
                                            <div class="row">
                                            @foreach($item['options'] as $optionKey => $option)
                                            <div class="col-sm-12 col-md-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="<?= $itemKey ?>[<?= $optionKey  ?>]" name="<?= $itemKey ?>[<?= $optionKey ?>]" <?= (!__isEmpty(request()->$itemKey) and array_key_exists($optionKey, request()->$itemKey)) ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="<?= $itemKey ?>[<?= $optionKey  ?>]"><?= $option ?></label>
                                                </div>
                                            </div>
                                            @endforeach
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                    @endforeach
                    <!-- /Other Tab Content -->                            
                </div>
                <div class="lw-search-button-container">
                    <button type="submit" class="btn btn-primary btn-block-on-mobile"><?= __tr('Apply Filters') ?></button>
                </div>
            </form>
        </div>
        <!-- /Tabs for advance filter -->
    </div>
    <div class="alert alert-success">
	<?= __trn('__filterCount__ Match Found','__filterCount__ Matches Found', $totalCount, ["__filterCount__" => $totalCount]) ?></div>
    <!-- /Advance Filter Options -->
    <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4" id="lwUserFilterContainer">
        @if(!__isEmpty($filterData))
            @include('filter.find-matches')
        @endif
    </div>
    @if($hasMorePages)
    <div class="lw-load-more-container">
        <button type="button" class="btn btn-light btn-block lw-ajax-link-action" id="lwLoadMoreButton" data-action="<?= $nextPageUrl ?>" data-callback="loadMoreUsers"><?= __tr('Load More') ?></button>
    </div>
    @endif

<!-- Found matches container -->
@push('appScripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key') ?>&libraries=places&callback=initialize" async defer></script>
<script>
    function loadMoreUsers(responseData) {
        $(function() {
            applyLazyImages();
        });
        var requestData = responseData.data,
            appendData = responseData.response_action.content;
        $('#lwUserFilterContainer').append(appendData);
        $('#lwLoadMoreButton').data('action', requestData.nextPageUrl);
        if (!requestData.hasMorePages) {
            $('.lw-load-more-container').hide();
        }
    }
// Show advance filter
$('#lwShowAdvanceFilterLink').on('click', function(e) {
    e.preventDefault();
    $('.lw-advance-filter-container').addClass('lw-expand-filter');
    $('#lwShowAdvanceFilterLink').hide();
    $('#lwHideAdvanceFilterLink').show();
    // $('.lw-advance-filter-container').show();
});
// Hide advance filter
$('#lwHideAdvanceFilterLink').on('click', function(e) {
    e.preventDefault();
    $('.lw-advance-filter-container').removeClass('lw-expand-filter');
    $('#lwShowAdvanceFilterLink').show();
    $('#lwHideAdvanceFilterLink').hide();
    // $('.lw-advance-filter-container').hide();
});

  $( function() {
    var list = "<?= getUserSettings('username_history') ?>";
    list = list.split(",");
    if(list.length >= 1){
        list = list.reverse();
    }

    list = list.slice(0, 20);

    $( "input[name=username_f]" ).autocomplete({
        source: list,
        minLength: 0,
        scroll: true
        }).focus(function() {
            $(this).autocomplete("search", "");
        });
  });

    // $( function() {

    //     //initialize();

    //     function getLocation() {
    //       if (navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(showPosition);
    //       } else {
    //         console.info("Geolocation is not supported by this browser.");
    //       }
    //     }

    //     function showPosition(position) {
    //         console.log("Position", position);
    //         $("input[name=lat]").val(position.coords.latitude);
    //         $("input[name=lng]").val(position.coords.longitude);
    //     }

    //     getLocation();
    // });



    function initialize() {

        console.log("Autocomplete");
        var input = document.getElementById('location');
        var options = {
            types: ['(regions)'],
        };

        autocomplete = new google.maps.places.Autocomplete(input, options);
        geolocate();
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            console.log(place);
            if (!place.geometry) {
              // User entered the name of a Place that was not suggested and
              // pressed the Enter key, or the Place Details request failed.
              window.alert("No details available for input: '" + place.name + "'");
              return;

            }

            console.log("Geometry:", place.geometry);

            $("input[name=lat]").val(place.geometry.location.lat());
            $("input[name=lng]").val(place.geometry.location.lng());
        });
        
        function geolocate() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
              const geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
              };console.log("Current Location:", geolocation, autocomplete);

              const circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy,
              });
              autocomplete.setBounds(circle.getBounds());
            });
          }
        }
    }

</script>
@endpush