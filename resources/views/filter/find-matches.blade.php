@if(!__isEmpty($filterData))
    @foreach($filterData as $filter)
    <div class="col mb-4">
        <div class="card text-center lw-user-thumbnail-block <?= (isset($filter['isPremiumUser']) and $filter['isPremiumUser'] == true) ? 'lw-has-premium-badge' : '' ?>">
			<!-- show user online, idle or offline status -->
			@if($filter['userOnlineStatus'])
				<div class="pt-2">
					@if($filter['userOnlineStatus'] == 1)
						<span class="lw-dot lw-dot-success {{$filter['id']}}" title="Online"></span>
						@elseif($filter['userOnlineStatus'] == 2)
						<span class="lw-dot lw-dot-warning {{$filter['id']}}" title="Idle"></span>
						@elseif($filter['userOnlineStatus'] == 3)
						<span class="lw-dot lw-dot-danger {{$filter['id']}}" title="Offline"></span>
					@endif
				</div>
			@endif
            <script>
                function getUserStatus(userUID){
                    

                    $.getJSON("/{{$filter['id']}}/online/status", function( data ) {
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

                        $("span.lw-dot.{{$filter['id']}}")
                            .removeClass("lw-dot-warning lw-dot-danger lw-dot-success")
                            .addClass(dotclass)
                            .attr("title", title);
                    });

                }
                setInterval(function(){
                    getUserStatus('{{$filter['id']}}');
                }, 60 * 1000);
            </script>
			<!-- /show user online, idle or offline status -->
            <a href="<?= route('user.profile_view', ['username' => $filter['username']]) ?>">
                <img data-src="<?= imageOrNoImageAvailable($filter['profileImage']) ?>" class="profile-image-badge profile-image-badge-<?= getUserPlan($filter['id']) ?>  lw-user-thumbnail lw-lazy-img"/>
            </a>
            <div class="card-title">
                <h5>
                	<a class="text-secondary" href="<?= route('user.profile_view', ['username' => $filter['username']]) ?>">
                		<?= $filter['fullName'] ?>
            		</a>
					<?= $filter['detailString'] ?> <br>

                    @if($filter['neighborhood'])
                        <?= $filter['neighborhood'] ?>,
                    @endif
                    @if($filter['city'])
                        <?= $filter['city'] ?> <br>
                    @endif

	                @if($filter['countryName'])
	                    <?= $filter['countryName'] ?>
	                @endif
                    
				</h5>
            </div>
        </div>
    </div>
    @endforeach
@else
    <!-- info message -->
    <div class="col-sm-12 alert alert-info">
        <?= __tr('There are no matches found.') ?>
    </div>
    <!-- / info message -->
@endif