<!-- Page Heading -->
<h3><?= __tr('General Settings') ?></h3>
<!-- Page Heading -->
<hr>
<!-- General setting form -->
<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.configuration.write', ['pageType' => request()->pageType]) ?>">

    <div class="">
		<label for="lwUploadLogo"><?= __tr('Upload Logo') ?></label>
        <input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('media.upload_logo') ?>" id="lwUploadLogo" data-callback="afterUploadedFile" data-default-image-url="<?= getStoreSettings('logo_image_url') ?>">
    </div>

    <div class="row">
        <div class="col-lg-6">
			<label for="lwUploadSmallLogo"><?= __tr('Upload Small Logo') ?></label>
            <input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('media.upload_small_logo') ?>" id="lwUploadSmallLogo" data-callback="afterUploadedFile" data-default-image-url="<?= getStoreSettings('small_logo_image_url') ?>">
        </div>
        <div class="col-lg-6">
			<label for="lwUploadFavicon"><?= __tr('Upload Favicon') ?></label>
            <input type="file" class="lw-file-uploader" data-instant-upload="true" data-action="<?= route('media.upload_favicon') ?>" data-callback="afterUploadedFile" id="lwUploadFavicon" data-default-image-url="<?= getStoreSettings('favicon_image_url') ?>">
        </div>
    </div>
    
    <!-- Website Name -->
    <div class="form-group">
		<label for="lwWebsiteName"><?= __tr('Your Website Name') ?></label>
        <input type="text" class="form-control form-control-user" name="name" id="lwWebsiteName" value="<?= $configurationData['name'] ?>" required>
    </div>
    <!-- /Website Name -->
    <!-- Business Email -->
    <div class="form-group">
		<label for="lwBusinessEmail"><?= __tr('Business Email') ?></label>
        <input type="email" class="form-control form-control-user" name="business_email" id="lwBusinessEmail" value="<?= $configurationData['business_email'] ?>" required>
    </div>
    <!-- /Business Email -->
    <!-- Contact Email -->
    <div class="form-group">
		<label for="lwContactEmail"><?= __tr('Contact Email') ?></label>
        <input type="email" class="form-control form-control-user" name="contact_email" id="lwContactEmail" value="<?= $configurationData['contact_email'] ?>">
    </div>
    <!-- /Contact Email -->

    <!-- Select Timezone -->
    <div class="form-group">
        <label for="lwSelectTimezone"><?= __tr('Select Timezone') ?></label>
        <select id="lwSelectTimezone" class="form-control form-control-user" name="timezone" required>
            @foreach($configurationData['timezone_list'] as $timezone)
                <option value="<?= $timezone['value'] ?>" <?= ($configurationData['timezone'] == $timezone['value']) ? 'selected' : '' ?>><?= $timezone['text'] ?></option>
            @endforeach
        </select>
    </div>
    <!-- /Select Timezone -->

    <!-- Distance Measurement -->
    <div class="form-group">
        <label for="lwDistanceMeasurement"><?= __tr('Distance Measurement') ?></label>
        <select id="lwDistanceMeasurement" class="form-control form-control-user" name="distance_measurement" required>
            <option value="6371" <?= ($configurationData['distance_measurement'] == '6371') ? 'selected' : '' ?>><?= __tr('KM') ?></option>
            <option value="3959" <?= ($configurationData['distance_measurement'] == '3959') ? 'selected' : '' ?>><?= __tr('Miles') ?></option>
        </select>
    </div>
    <!-- /Distance Measurement -->
    
    <!-- Update Button -->
    <a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile">
        <?= __tr('Update') ?>
    </a>
    <!-- /Update Button -->
</form>
<!-- /General setting form -->

@push('appScripts')
<script>
    // After file successfully uploaded then this function is called
    function afterUploadedFile(responseData) {
        var requestData = responseData.data;
        $('#lwUploadedLogo').attr('src', requestData.path);
    }
    $(function() {
        $('#lwSelectTimezone').selectize();
    });
</script>
@endpush