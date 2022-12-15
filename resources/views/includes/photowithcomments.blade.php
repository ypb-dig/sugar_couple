
<img data-toggle="modal" data-target="#photo_modal_{{$key}}" class="lw-user-photo lw-lazy-img" data-img-index="<?= $key ?>" data-src="<?= imageOrNoImageAvailable($photo['image_url']) ?>"/>


<div class="modal photo-modal" id="photo_modal_{{$key}}" data-source="<?=$photo['image_uid']?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="photo-panel">
          <img class="lw-user-photo lw-lazy-img" data-img-index="<?= $key ?>" data-src="<?= imageOrNoImageAvailable($photo['image_url']) ?>">
          <div class="navigation photo-navigation">
            <div class="previous" onclick="navigationPrevious(<?= $key ?>)"><i class="fa fa-arrow-circle-left"></i></div>
            <div class="next" onclick="navigationNext(<?= $key ?>)"><i class="fa fa-arrow-circle-right"></i></div>
          </div>
        </div>
        {{-- @if(isPremiumUser() && $isPremiumUser) --}}
          <div class="comments-panel">
             {{-- @if(!$isOwnProfile) --}}
                <div class="new-comment">
                  <form class="newsletter-form lw-ajax-form lw-form" method="post" action="<?= route('api.photo.write.comment', $photo['image_uid']) ?>" data-show-processing="true" data-callback="onCreateComment" id="lwComment">
                      <div class="form-group text-left">
                        <label> Deixar recado </label>
                      <input class="form-control" type="text" required name="comment"/> 
                      <input class="form-control" type="hidden" name="owner" value="{{$userData['userId']}}"/>  
                      <input class="form-control" type="hidden" name="by" value="{{getUserID()}}"/> 
                    </div>
                    <div class="form-group text-left">              
                      <buttom  class="btn btn-primary lw-ajax-form-submit-action" type="button"> Enviar</buttom>
                    </div>
                  </form>
                </div>
            {{-- @endif --}}
            <div class="comment-list"></div>    
          </div>
        {{-- @endif --}}
      </div>
    </div>
  </div>
</div>