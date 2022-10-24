<div class="website-footer">
    @include('includes.landing-goldenbar')
    <div class="sitemap">
        <div class="row">
            <div class="col-md-4 logo-row">
                <div class="footer-logo">
                    <img src="/imgs/logotipo-quero-p.png"/>
                </div>
            </div>
             <div class="col-md-2">
                <ul>
                    <li><a href="<?= route('plans') ?>"><?= __tr('COMO FUNCIONA') ?></a></li>
                    <!-- <li><a href=""><?= __tr('FAQ') ?></a></li>                         -->
                    <li><a href="<?= route('user.read.contact') ?>"><?= __tr('CONTATO') ?></a></li>                
                    <li class="email"><a href="mailto:contato@queromeudaddy.com.br">contato@queromeudaddy.com.br</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul>
                    <li><a href="<?= route('privacy') ?>">POLITICA DE PRIVACIDADE</a></li>
                    <li><a href="<?= route('terms') ?>">TERMOS E CONDIÇÕES</a></li>                        
                    <li>FORMAS DE PAGAMENTO</li>
                    <li class="pagamentos"><img src="/imgs/pagamentos-icon-v2.png"/></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul>
                    <li>SIGA-NOS</li>
                    <li class="social">
                        <a href="https://www.facebook.com/queromeudaddy/"><img src="/imgs/facebook-icon.png"/></a>
                        <a href="https://www.instagram.com/queromeudaddy/"><img src="/imgs/instagram-icon.png"/></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <footer>
        <?= __tr(' © __copyrightYear__ __storeName__ ', [
                '__storeName__' => 'Quero Meu Daddy',
                '__copyrightYear__' => date('Y')
            ]) ?>
        <b> | <?= __tr('TODOS OS DIREITOS RESERVADOS - DESENVOLVIDO POR') ?> <a href="https://ypb.com.br/">  <?= __tr('YPB MKT DIGITAL') ?> </a> </b>
    </footer>
</div>

<!-- Messenger Dialog -->
<div class="modal fade" id="messengerDialog" tabindex="-1" role="dialog" aria-labelledby="messengerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button id="lwChatSidebarToggle" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <h5 class="modal-title"><?= __tr('Chat') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?= __tr('Close') ?>"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="lwChatDialogLoader" style="display: none;">
                    <div class="d-flex justify-content-center m-5">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"><?= __tr('Loading...') ?></span>
                        </div>
                    </div>
                </div>
                <div id="lwMessengerContent"></div>
            </div>
        </div>
    </div>
</div>
<!-- Messenger Dialog -->

<!-- Modal Cookies -->
<div class="modal fade show modal-cookies" id="cookies" tabindex="-1" role="dialog" aria-modal="true" style="padding-right: 17px; display: block;">
    <div class="modal-dialog modal-medium" style="bottom:0; position:absolute; right:0; left:0;max-width:100%">
        <div class="modal-content">  
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <div class="modal-body">
							<div class="m-1">
								"Usamos os cookies e dados de navegação visando proporcionar uma melhor experiência durante o uso do site. Ao continuar, você concorda com nossa <a href="https://queromeudaddy.com.br/privacy" style="color:red">Política de Privacidade"</a>
							</div>
                        </div>
                    </div>
					<div class="col-lg-3">
						<a class="btn btn-primary btn-close" data-dismiss="modal" style="color:#fff">Continuar</a>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>


<img src="<?= asset('imgs/ajax-loader.gif') ?>" style="height:1px;width:1px;display:none;">
<script>
    window.appConfig = {
        debug: "<?= config('app.debug') ?>",
        csrf_token: "<?= csrf_token() ?>"
    }
</script>

<?= __yesset([
    'dist/pusher-js/pusher.min.js',
    'dist/js/vendorlibs-public.js',
    'dist/js/vendorlibs-datatable.js',
    'dist/js/vendorlibs-photoswipe.js',
    'dist/js/vendorlibs-smartwizard.js',
    'dist/js/jquery.mask.min.js',
    'dist/js/jquery-ui.js',

], true) ?>

<script>
	$('.btn-close').click(function(event){
	  localStorage.setItem('cookie','true');
	});
	
	$(document).ready(function() {
		if(!localStorage.getItem('cookie')){
			$('#cookies').modal('show');
			
		}else{
			$('.modal-cookies').css({'display':'none'});
		}
	})
</script>

<script>
        $(document).ready(function(){
            if($('.phone_with_ddd').mask)
                $('.phone_with_ddd').mask('(00) 00000-0000');

            if($('.phone_with_ddd').mask)
            $('.date-mask').mask('00/00/0000');
        });

        (function () {
            $.validator.messages = $.extend({}, $.validator.messages, {
                required: '<?= __tr("This field is required.") ?>',
                remote: '<?= __tr("Please fix this field.") ?>',
                email: '<?= __tr("Please enter a valid email address.") ?>',
                url: '<?= __tr("Please enter a valid URL.") ?>',
                date: '<?= __tr("Please enter a valid date.") ?>',
                dateISO: '<?= __tr("Please enter a valid date (ISO).") ?>',
                number: '<?= __tr("Please enter a valid number.") ?>',
                digits: '<?= __tr("Please enter only digits.") ?>',
                equalTo: '<?= __tr("Please enter the same value again.") ?>',
                maxlength: $.validator.format('<?= __tr("Please enter no more than {0} characters.") ?>'),
                minlength: $.validator.format('<?= __tr("Please enter at least {0} characters.") ?>'),
                rangelength: $.validator.format('<?= __tr("Please enter a value between {0} and {1} characters long.") ?>'),
                range: $.validator.format('<?= __tr("Please enter a value between {0} and {1}.") ?>'),
                max: $.validator.format('<?= __tr("Please enter a value less than or equal to {0}.") ?>'),
                min: $.validator.format('<?= __tr("Please enter a value greater than or equal to {0}.") ?>'),
                step: $.validator.format('<?= __tr("Please enter a multiple of {0}.") ?>')
            });
        })();
</script>
<?= __yesset([
    'dist/js/common-app.*.js'
], true) ?>
<script>
    __Utils.setTranslation({
        'processing': "<?= __tr('processing') ?>",
        'uploader_default_text': "<span class='filepond--label-action'><?= __tr('Drag & Drop Files or Browse') ?></span>",
        'gif_no_result': "<?= __tr('Result Not Found') ?>",
        "message_is_required": "<?= __tr('Message is required') ?>",
        "sticker_name_label": "<?= __tr('Stickers') ?>"
    });

    var userLoggedIn = '<?= isLoggedIn() ?>',
        enablePusher = '<?= getStoreSettings('allow_pusher') ?>';

    if (userLoggedIn && enablePusher) {
        var userUid = '<?= getUserUID() ?>',
            pusherAppKey = '<?= getStoreSettings('pusher_app_key') ?>',
            __pusherAppOptions = {
                cluster: '<?= getStoreSettings('pusher_app_cluster_key') ?>',
                forceTLS: true,
            };

    }
</script>
<!-- Include Audio Video Call Component -->
@include('messenger.audio-video')
<!-- /Include Audio Video Call Component -->
<script>
    //check user loggedIn or not
    if (userLoggedIn && enablePusher) {
        //subscribe pusher notification
        subscribeNotification('event.user.notification', pusherAppKey, userUid, function (responseData) {
            //get notification list
            var requestData = responseData.getNotificationList,
                getNotificationList = requestData.notificationData,
                getNotificationCount = requestData.notificationCount;
            //update notification count
            __DataRequest.updateModels({
                'totalNotificationCount': getNotificationCount, //total notification count
            });
            //check is not empty
            if (!_.isEmpty(getNotificationList)) {
                var template = _.template($("#lwNotificationListTemplate").html());
                $("#lwNotificationContent").html(template({
                    'notificationList': getNotificationList,
                }));
            }
            //check is not empty
            if (responseData) {
                switch (responseData.type) {
                    case 'user-likes':
                        if (responseData.showNotification != 0) {
                            showSuccessMessage(responseData.message);
                        }
                        break;
                    case 'user-gift':
                        if (responseData.showNotification != 0) {
                            showSuccessMessage(responseData.message);
                        }
                        break;
                    case 'profile-visitor':
                        if (responseData.showNotification != 0) {
                            showSuccessMessage(responseData.message);
                        }
                        break;
                    case 'user-login':
                        if (responseData.showNotification != 0) {
                            showSuccessMessage(responseData.message);
                        }
                        break;
                    default:
                        showSuccessMessage(responseData.message);
                        break;
                }
            }
        });

        subscribeNotification('event.user.chat.messages', pusherAppKey, userUid, function (responseData) {
            // Message chat
            if (responseData.requestFor == 'MESSAGE_CHAT') {
                if (currentSelectedUserUid == responseData.toUserUid) {
                    __Messenger.appendReceivedMessage(responseData.type, responseData.message, responseData.createdOn);
                }

                // Set user message count
                if (responseData.userId != currentSelectedUserId) {
                    var incomingMsgEl = $('.lw-incoming-message-count-' + responseData.userId),
                        messageCount = 1;
                    if (!_.isEmpty(incomingMsgEl.text())) {
                        messageCount = parseInt(incomingMsgEl.text()) + 1;
                    }
                    incomingMsgEl.text(messageCount);
                    // Show notification of incoming messages
                    if (responseData.showNotification) {
                        showSuccessMessage(responseData.notificationMessage);
                    }
                }
            }

            // Message request
            if (responseData.requestFor == 'MESSAGE_REQUEST') {
                if (responseData.userId == currentSelectedUserId) {
                    handleMessageActionContainer(responseData.messageRequestStatus, false);
                    if (!_.isEmpty(responseData.message)) {
                        __Messenger.appendReceivedMessage(responseData.type, responseData.message, responseData.createdOn);
                    }
                } else {
                    if (responseData.showNotification) {
                        showSuccessMessage(responseData.notificationMessage);
                    }
                }
            }

        });
    };

    //for cookie terms 
    function showCookiePolicyDialog() {
        if (__Cookie.get('cookie_policy_terms_accepted') != '1') {
            $('#lwCookiePolicyContainer').show();
        } else {
            $('#lwCookiePolicyContainer').hide();
        }
    };

    showCookiePolicyDialog();

    $("#lwCookiePolicyButton").on('click', function () {
        __Cookie.set('cookie_policy_terms_accepted', '1', 1000);
        showCookiePolicyDialog();
    });

    // Get messenger chat data
    function getChatMessenger(url, isAllChatMessenger) {
        var $allMessageChatButtonEl = $('#lwAllMessageChatButton'),
            $lwMessageChatButtonEl = $('#lwMessageChatButton');
        // check if request for all messenger 
        if (isAllChatMessenger) {
            var isAllMessengerChatLoaded = $allMessageChatButtonEl.data('chat-loaded');
            if (!isAllMessengerChatLoaded) {
                $allMessageChatButtonEl.attr('data-chat-loaded', true);
                $lwMessageChatButtonEl.attr('data-chat-loaded', false);
                fetchChatMessages(url);
            }
        } else {
            var isMessengerLoaded = $lwMessageChatButtonEl.data('chat-loaded');
            if (!isMessengerLoaded) {
                $lwMessageChatButtonEl.attr('data-chat-loaded', true);
                $allMessageChatButtonEl.attr('data-chat-loaded', false);
                fetchChatMessages(url);
            }
        }
    };

    // Fetch messages from server
    function fetchChatMessages(url) {
        $('#lwChatDialogLoader').show();
        $('#lwMessengerContent').hide();
        __DataRequest.get(url, {}, function (responseData) {
            $('#lwChatDialogLoader').hide();
            $('#lwMessengerContent').show();
        });
    };

</script>
@stack('appScripts')