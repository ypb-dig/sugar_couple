<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Lw-Dating Routes 
|--------------------------------------------------------------------------
*/

Route::post('notificationstatus/', [
    'as' => 'pagseguro.notification',
    'uses' => 'NotificationApiController@notificationStatus'
]);

Route::get ('/getuserstatusboleto/{userUid}', [
    'as' => 'get.user.status.boleto',
    'uses' => 'NotificationApiController@getUserBoleto'
]);

Route::post('setuserstatusboleto/', [
    'as' => 'set.user.status.boleto.payed',
    'uses' => 'NotificationApiController@setPaymentStatus'
]);

Route::get('teste/', [
    'as' => 'pagseguro.notification.teste',
    'uses' => 'NotificationApiController@teste'
]);

Route::group([
    'namespace' => '\App\Yantrana\Components',
], function () {
    
    Route::get('/change-language/{localeID}', [
        'as' => 'locale.change',
        'uses' => 'Home\Controllers\HomeController@changeLocale',
	]);
	
	// contact view
	Route::get('/contact', [
		'as' => 'user.read.contact',
		'uses' => 'User\Controllers\UserController@getContactView'
	]);
	
	// process contact form
	Route::post('/post-contact', [
		'as' => 'user.contact.process',
		'uses' => 'User\Controllers\UserController@contactProcess',
	]);

	// page preview
    Route::get('/page/{pageUId}/{title}', [
        'as' => 'page.preview',
        'uses' => 'Home\Controllers\HomeController@previewPage',
    ]);

    // Get privacy page view
    Route::get('/privacy', [
        'as' => 'privacy',
        'uses' => 'Home\Controllers\HomeController@privacyPage'
    ]);

    // Get terms page view
    Route::get('/terms', [
        'as' => 'terms',
        'uses' => 'Home\Controllers\HomeController@termsPage'
    ]);

    // Get plans page view
    Route::get('/plans', [
        'as' => 'plans',
        'uses' => 'Home\Controllers\HomeController@plansPage'
    ]);

    // Get landing page view
    Route::get('/', [
        'as' => 'landing_page',
        'uses' => 'Home\Controllers\HomeController@landingPage'
    ]);

    Route::get('/images', [
        'as' => 'blurred.images',
        'uses' => 'Home\Controllers\HomeController@blurredImages'
    ]);

    // Get status
    Route::get('/{userUid}/online/status', [
        'as' => 'user.online.status',
        'uses' => 'User\Controllers\UserController@getUserOnlineStatus'
    ]);

    /*
    User Components Public Section Related Routes
    ----------------------------------------------------------------------- */
    Route::group(['middleware' => 'guest'], function () {

        Route::group([
            'namespace' => 'Home\Controllers'
        ], function () {
    
            // Process search from landing page
            Route::post('/search-matches', [
                'as' => 'search_matches',
                'uses' => 'HomeController@searchMatches'
            ]);
        });

        Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'user',
            ], function () {

            // login
            Route::get('/login', [
                'as' => 'user.login',
                'uses' => 'UserController@login',
            ]);
            
            // login process
            Route::post('/login-process', [
                'as' => 'user.login.process',
                'uses' => 'UserController@loginProcess',
            ]);
            
            // User Registration
            Route::get('/sign-up', [
                'as' => 'user.sign_up',
                'uses' => 'UserController@signUp',
            ]);

           // User Registration
            Route::get('/sign-up-success', [
                'as' => 'user.sign_up_success',
                'uses' => 'UserController@signUpSuccess',
            ]);
            
            // User Registration Process
            Route::post('/sign-up-process', [
                'as' => 'user.sign_up.process',
                'uses' => 'UserController@signUpProcess'
            ]);

            // forgot password view
            Route::get('/forgot-password', [
                'as' => 'user.forgot_password',
                'uses' => 'UserController@forgotPasswordView',
            ]);

            // forgot password process
            Route::post('/forgot-password-process', [
                'as' => 'user.forgot_password.process',
                'uses' => 'UserController@processForgotPassword',
            ]);

            // reset password
            Route::get('/reset-password', [
                'as' => 'user.reset_password',
                'uses' => 'UserController@restPasswordView',
            ]);

            // reset password process
            Route::post('/reset-password-process/{reminderToken}', [
                'as' => 'user.reset_password.process',
                'uses' => 'UserController@processRestPassword',
            ]);
            
            // Account Activation
            Route::get('/{userUid}/account-activation', [
                'as' => 'user.account.activation',
                'uses' => 'UserController@accountActivation',
			])->middleware('signed');

        });
    });
    
    /*
    User Social Access Components Public Section Related Routes
    ----------------------------------------------------------------------- */
    Route::group([
        'namespace' => 'User\Controllers',
        'prefix'    => 'user/social-login',
    ], function () {

        // social user login
        Route::get('/request/{provider}', [
            'as'   => 'social.user.login',
            'uses' => 'SocialAccessController@redirectToProvider',
        ]);

        // social user login callback
        Route::get('/response/{provider}', [
            'as'   => 'social.user.login.callback',
            'uses' => 'SocialAccessController@handleProviderCallback',
        ]);
    });

    /*
    After Authentication Accessible Routes
    -------------------------------------------------------------------------- */

    Route::group(['middleware' => 'auth'], function () {

        // Pag Seguro
        Route::post('checkout', [
            'as' => 'pagseguro.checkout',
            'uses' => 'Payment\Controllers\PagseguroController@checkout',
        ]);

        Route::get('pre_order', [
            'as' => 'pagseguro.pre_order',
            'uses' => 'Payment\Controllers\PagseguroController@pre_order',
        ]);

        // Home page for logged in user
        Route::get('/home', [
            'as' => 'home_page',
            'uses' => 'Home\Controllers\HomeController@homePage',
        ]);

        // Get User Profile view
        Route::get('/@{username}', [
            'as' => 'user.profile_view',
            'uses' => 'User\Controllers\UserController@getUserProfile'
        ]);
        // Get user profile data
        Route::get('/{username}/get-user-profile-data', [
            'as' => 'user.get_profile_data',
            'uses' => 'User\Controllers\UserController@getUserProfileData'
        ]);
        // View photos settings
        Route::get('/@{username}/photos', [
            'as' => 'user.photos_setting',
            'uses' => 'UserSetting\Controllers\UserSettingController@getUserPhotosSetting',
        ]);

        /*
        Filter Components Public Section Related Routes
        ----------------------------------------------------------------------- */
        Route::group([
            'namespace' => 'Filter\Controllers',
        ], function () {
            // Show Find Matches View
            Route::get('/find-matches', [
                'as' => 'user.read.find_matches',
                'uses' => 'FilterController@getFindMatches',
            ]);
        });

        /*
         * User Section 
        ----------------------------------------------------------------------- */
        Route::group([
            'prefix' => 'user'
        ], function() {
            /*
            User Component Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers'
            ], function () {

        // Manage User transaction list
                Route::get('/{userUid}/manage-user-transaction-list', [
                    'as' => 'manage.user.read.transaction_list',
                    'uses' => 'ManageUserController@manageUserTransactionList',
                ]);

            	// Get user profile data
		        Route::get('/update-profile-wizard', [
		            'as' => 'user.update_profile.wizard',
		            'uses' => 'UserController@loadProfileUpdateWizard'
		        ]);

		        // Get user profile data
		        Route::get('/check-profile-updated', [
		            'as' => 'user.profile.wizard_completed',
		            'uses' => 'UserController@checkProfileUpdateWizard'
		        ]);

		        // Get user profile data
		        Route::post('/finish-wizard', [
		            'as' => 'user.profile.finish_wizard',
		            'uses' => 'UserController@finishWizard'
		        ]);

                // logout
                Route::get('/logout', [
                    'as' => 'user.logout',
                    'uses' => 'UserController@logout',
                ]);
                
                // change password view
                Route::get('/change-password', [
                    'as' => 'user.change_password',
                    'uses' => 'UserController@changePasswordView',
                ]);
                
                // User Change Password Process
                Route::post('/change-password-process', [
                    'as' => 'user.change_password.process',
                    'uses' => 'UserController@processChangePassword'
                ]);

                // change email view
                Route::get('/change-email', [
                    'as' => 'user.change_email',
                    'uses' => 'UserController@changeEmailView',
                ]);
                
                // User Change Email Process
                Route::post('/change-email-process', [
                    'as' => 'user.change_email.process',
                    'uses' => 'UserController@processChangeEmail'
				]);
				
				// New Email Activation
				Route::get('/{userUid}/{newEmail}/new-email-activation', [
					'as' => 'user.new_email.activation',
					'uses' => 'UserController@newEmailActivation',
				]);

				// Get User Profile view
				Route::get('/update-email-success', [
					'as' => 'user.new_email.read.success',
					'uses' => 'UserController@updateEmailSuccessView'
				]);
				
				// User Like Dislike route
                Route::post('/{toUserUid}/{like}/user-like-dislike', [
                    'as' => 'user.write.like_dislike',
                    'uses' => 'UserController@userLikeDislike'
				]);
				
				// Get User My like view
                Route::get('/liked', [
                    'as' => 'user.my_liked_view',
                    'uses' => 'UserController@getMyLikeView'
				]);

				// Get User My Dislike view
                Route::get('/disliked', [
                    'as' => 'user.my_disliked_view',
                    'uses' => 'UserController@getMyDislikedView'
				]);

				// Get who liked me users
                Route::get('/who-liked-me', [
                    'as' => 'user.who_liked_me_view',
                    'uses' => 'UserController@getWhoLikedMeView'
				]);

				// Get mutual likes users
                Route::get('/mutual-likes', [
                    'as' => 'user.mutual_like_view',
                    'uses' => 'UserController@getMutualLikeView'
				]);

				// Get profile visitors users
                Route::get('/visitors', [
                    'as' => 'user.profile_visitors_view',
                    'uses' => 'UserController@getProfileVisitorView'
				]);

				// post User send gift
                Route::post('/{sendUserUId}/send-gift', [
                    'as' => 'user.write.send_gift',
                    'uses' => 'UserController@userSendGift'
				]);

                // post User send gift
                Route::post('/{id}/checked-as-viewed', [
                    'as' => 'user.write.viewed_gift',
                    'uses' => 'UserController@checkViewedGift'
                ]);

				// post report user
                Route::post('/{sendUserUId}/report-user', [
                    'as' => 'user.write.report_user',
                    'uses' => 'UserController@reportUser'
				]);

				// post User send gift
                Route::post('/block-user', [
                    'as' => 'user.write.block_user',
                    'uses' => 'UserController@blockUser'
				]);

				// block user list
                Route::get('/blocked-users', [
                    'as' => 'user.read.block_user_list',
                    'uses' => 'UserController@blockUserList'
				]);

				// post un-block user
                Route::post('/{userUid}/unblock-user', [
                    'as' => 'user.write.unblock_user',
                    'uses' => 'UserController@processUnblockUser'
				]);

				// post un-block user
                Route::post('/boost-profile', [
                    'as' => 'user.write.boost_profile',
                    'uses' => 'UserController@processBoostProfile'
				]);

                // block user list
                Route::get('/get-booster-info', [
                    'as' => 'user.read.booster_data',
                    'uses' => 'UserController@getBoosterInfo'
                ]);
                
                // Permanent delete account
                Route::post('/delete-account', [
                    'as' => 'user.write.delete_account',
                    'uses' => 'UserController@deleteAccount'
				]);
            });

            // User Settings related routes
            Route::group([
                'namespace' => 'UserSetting\Controllers',
                'prefix' => 'settings'
            ], function () {
				// View settings
                Route::get('/{pageType}', [
                    'as' => 'user.read.setting',
                    'uses' => 'UserSettingController@getUserSettingView',
				]);
				 // Process Configuration Data
                Route::post('/{pageType}/process-user-setting-store', [
                    'as' => 'user.write.setting',
                    'uses' => 'UserSettingController@processStoreUserSetting',
                ]);
                // Process Configuration Data
                Route::post('/{pageType}/process-user-setting-delete', [
                    'as' => 'user.delete.setting',
                    'uses' => 'UserSettingController@processDeleteUserSetting',
                ]);

                // Process basic settings
                Route::post('/process-basic-settings', [
                    'as' => 'user.write.basic_setting',
                    'uses' => 'UserSettingController@processUserBasicSetting',
                ]);

                // Process basic settings
                Route::post('/process-update-profile-wizard', [
                    'as' => 'user.write.update_profile_wizard',
                    'uses' => 'UserSettingController@profileUpdateWizard',
                ]);

                // Process location / maps data
                Route::post('/process-location-data', [
                    'as' => 'user.write.location_data',
                    'uses' => 'UserSettingController@processLocationData',
                ]);
                // Store User Profile Image
                Route::post('/upload-profile-image', [
                    'as' => 'user.upload_profile_image',
                    'uses' => 'UserSettingController@uploadProfileImage'
                ]);
                // Store User Cover Image
                Route::post('/upload-cover-image', [
                    'as' => 'user.upload_cover_image',
                    'uses' => 'UserSettingController@uploadCoverImage'
                ]);
                // Process User Profile 
                Route::post('/process-profile-setting', [
                    'as' => 'user.write.profile_setting',
                    'uses' => 'UserSettingController@processUserProfileSetting',
                ]);
                // Upload multiple hotos
                Route::post('/upload-photos', [
                    'as' => 'user.upload_photos',
                    'uses' => 'UserSettingController@uploadPhotos'
				]);
                // delete photo
                Route::post('/{photoUid}/delete-photos', [
                    'as' => 'user.upload_photos.write.delete',
                    'uses' => 'UserSettingController@deleteUserPhotos'
                ]);
            });

            // User Messenger related routes
            Route::group([
                'namespace' => 'Messenger\Controllers',
                'prefix' => 'messenger'
            ], function () {
                // Get All Conversation
                Route::get('/', [
                    'as' => 'user.read.messenger',
                    'uses' => 'MessengerController@show',
                ]);
                // Get All Conversation
                Route::get('/all-conversation', [
                    'as' => 'user.read.all_conversation',
                    'uses' => 'MessengerController@getAllConversation',
                ]);
                // Get Specific Conversation 
                Route::get('/{specificUserId}/individual-conversation', [
                    'as' => 'user.read.individual_conversation',
                    'uses' => 'MessengerController@getIndividualConversation',
                ]);
                // Get Conversation List
                Route::get('/{userId}/get-user-conversation', [
                    'as' => 'user.read.user_conversation',
                    'uses' => 'MessengerController@getUserConversation',
                ]);
                // Send message
                Route::post('/{userId}/process-send-message', [
                    'as' => 'user.write.send_message',
                    'uses' => 'MessengerController@sendMessage',
                ]);
                // Accept / Decline Message request
                Route::post('/{userId}/process-accept-decline-message-request', [
                    'as' => 'user.write.accept_decline_message_request',
                    'uses' => 'MessengerController@acceptDeclineMessageRequest',
                ]);
                // Delete Single Chat
                Route::post('/{chatId}/{userId}/delete-message', [
                    'as' => 'user.write.delete_message',
                    'uses' => 'MessengerController@deleteMessage',
				]);
				// Get Call Token Data
                Route::post('/{userUId}/{type}/call-initialize', [
                    'as' => 'user.write.caller.call_initialize',
                    'uses' => 'MessengerController@callerCallInitialize',
				]);
                // Get Call Token Data
                Route::post('/join-call', [
                    'as' => 'user.write.receiver.join_call',
                    'uses' => 'MessengerController@receiverJoinCallRequest',
                ]);
				// Caller Call Reject
                Route::get('/{receiverUserUid}/caller-reject-call', [
                    'as' => 'user.write.caller.reject_call',
                    'uses' => 'MessengerController@callerRejectCall',
				]);
				// Receiver Call Reject
                Route::get('/{callerUserUid}/receiver-reject-call', [
                    'as' => 'user.write.receiver.reject_call',
                    'uses' => 'MessengerController@receiverRejectCall',
				]);
				// Caller call errors
                Route::get('/{receiverUserUid}/caller-errors', [
                    'as' => 'user.write.caller.error',
                    'uses' => 'MessengerController@callerCallErrors',
				]);
				// Receiver call errors
                Route::get('/{callerUserUid}/receiver-errors', [
                    'as' => 'user.write.receiver.error',
                    'uses' => 'MessengerController@receiverCallErrors',
				]);
				// Receiver call accept
                Route::post('/{receiverUserUid}/receiver-call-accept', [
                    'as' => 'user.write.receiver.call_accept',
                    'uses' => 'MessengerController@receiverCallAccept',
				]);
				// Receiver call errors
                Route::get('/{callerUserUid}/receiver-busy-call', [
                    'as' => 'user.write.receiver.call_busy',
                    'uses' => 'MessengerController@receiverCallBusy',
                ]);
                // Delete all chat conversation 
                Route::post('/{userId}/delete-all-message', [
                    'as' => 'user.write.delete_all_messages',
                    'uses' => 'MessengerController@deleteAllMessages',
                ]);
                // Get Stickers
                Route::get('/get-stickers', [
                    'as' => 'user.read.get_stickers',
                    'uses' => 'MessengerController@getStickers',
                ]);
                // Buy Sticker
                Route::post('/process-buy-sticker', [
                    'as' => 'user.write.buy_stickers',
                    'uses' => 'MessengerController@buySticker',
                ]);
			});
			
			// User Notification related routes
            Route::group([
                'namespace' => 'Notification\Controllers',
                'prefix' => 'notifications'
            ], function () {
				// Get mutual likes users
                Route::get('/', [
                    'as' => 'user.notification.read.view',
                    'uses' => 'NotificationController@getNotificationView'
				]);

				// Get mutual likes users
                Route::get('/notification-list', [
                    'as' => 'user.notification.read.list',
                    'uses' => 'NotificationController@getNotificationList'
				]);

				// Post Read All Notification
                Route::post('/read-all-notification', [
                    'as' => 'user.notification.write.read_all_notification',
                    'uses' => 'NotificationController@readAllNotification'
				]);
			});

			// User Encounter related routes
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'encounters'
            ], function () {
				// Get users encounter view
                Route::get('/', [
                    'as' => 'user.read.encounter.view',
                    'uses' => 'UserEncounterController@getUserEncounterView'
				]);

				// User Like Dislike route
                Route::post('/{toUserUid}/{like}/user-encounter-like-dislike', [
                    'as' => 'user.write.encounter.like_dislike',
                    'uses' => 'UserEncounterController@userEncounterLikeDislike'
				]);

				// Skip Encounter User
                Route::post('/{toUserUid}/skip-encounter-user', [
                    'as' => 'user.write.encounter.skip_user',
                    'uses' => 'UserEncounterController@skipEncounterUser'
				]);
			});

			 /*
            Manage Premium Plan User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                    'namespace' => 'User\Controllers',
                    'prefix' => 'premium',
                ], function () {
                // User Premium Plan View
                Route::get('/', [
                    'as' => 'user.premium_plan.read.view',
                    'uses' => 'PremiumPlanController@getPremiumPlanView',
				]);

				// buy premium plans
                Route::post('/buy-plans', [
                    'as' => 'user.premium_plan.write.buy_premium_plan',
                    'uses' => 'PremiumPlanController@buyPremiumPlans',
				]);

				 // User Premium Plan Buy Successfully
                Route::get('/success', [
                    'as' => 'user.premium_plan.read.success_view',
                    'uses' => 'PremiumPlanController@getPremiumPlanSuccessView',
				]);
			});
			
			/*
        	Credit wallet User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
				'namespace' => 'User\Controllers',
				'prefix' => 'credit-wallet',
			], function () {

                //Cupom process
                Route::post('/payment-cupom', [
                    'as' => 'api.user.credit_wallet.apply.payment_cupom',
                   'uses' => 'CreditWalletController@paymentCupom',
                ]);

				// User Credit-wallet View
				Route::get('/', [
					'as' => 'user.credit_wallet.read.view',
					'uses' => 'CreditWalletController@creditWalletView',
				]);

				// Public User Wallet transaction list
				Route::get('/user-wallet-transaction-list', [
					'as' => 'user.credit_wallet.read.wallet_transaction_list',
					'uses' => 'CreditWalletController@getUserWalletTransactionList',
				]);
				
				// paypal transaction complete
				Route::post('/{packageUid}/paypal-transaction-complete', [
					'as' => 'user.credit_wallet.write.paypal_transaction_complete',
					'uses' => 'CreditWalletController@paypalTransactionComplete',
				]);

                // paypal transaction complete
                Route::post('/{planId}/paypal-plan-transaction-complete', [
                    'as' => 'user.credit_wallet.write.paypal_plan_transaction_complete',
                    'uses' => 'CreditWalletController@paypalPlanTransactionComplete',
                ]);

                // papagseguroypal transaction complete
                Route::post('/{planId}/pagseguro-plan-transaction-complete', [
                    'as' => 'user.credit_wallet.write.pagseguro_plan_transaction_complete',
                    'uses' => 'CreditWalletController@pagseguroPlanTransactionComplete',
                ]);

                Route::get('/{planId}/pagseguro-plan-transaction-complete-dois', [
                    'as' => 'user.credit_wallet.write.pagseguro_plan_transaction_complete_boleto',
                    'uses' => 'CreditWalletController@pagseguroPlanTransactionCompleteBoleto',
                ]);               
				
				// stripe checkout routes
				Route::post('/payment-process', [
					'as' => 'user.credit_wallet.write.payment_process',
					'uses' => 'CreditWalletController@paymentProcess',
				]);
				
				// stripe success callback routes
				Route::get('/stripe-callback', [
					'as' => 'user.credit_wallet.write.stripe.callback_url',
					'uses' => 'CreditWalletController@stripeCallbackUrl',
				]);
				
				// stripe checkout cancel url
				Route::get('/stripe-cancel', [
					'as' => 'user.credit_wallet.write.stripe.cancel_url',
					'uses' => 'CreditWalletController@stripeCancelCallback',
				]);

				// razorpay checkout
				Route::post('/razorpay-checkout', [
					'as' => 'user.credit_wallet.write.razorpay.checkout',
					'uses' => 'CreditWalletController@razorpayCheckout',
				]);
            });
		});		
        /*
         * User Section End here
        ----------------------------------------------------------------------- */

        /*
         * Manage / Admin Section 
        ----------------------------------------------------------------------- */
        Route::group([
            'middleware' => 'admin.auth',
            'prefix' => 'admin'
        ], function() {

            /*
            Manage User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                    'namespace' => 'User\Controllers',
                    'prefix' => 'manage/user',
                ], function () {
                // Manage User List
                Route::get('/{status}/list', [
                    'as' => 'manage.user.view_list',
                    'uses' => 'ManageUserController@userList',
                ]);

                // Manage User Photos List
                Route::get('/photos', [
                    'as' => 'manage.user.photos_list',
                    'uses' => 'ManageUserController@userPhotosView',
                ]);

                // Manage User Photos List
                Route::get('/photos-list', [
                    'as' => 'manage.user.read.photos_list',
                    'uses' => 'ManageUserController@userPhotosList',
                ]);

                // Delete User photo
                Route::post('/{userUid}/{type}/{profileOrPhotoUid}/process-delete-photo', [
                    'as' => 'manage.user.write.photo_delete',
                    'uses' => 'ManageUserController@processUserPhotoDelete',
                ]);

                // Manage User List
                Route::get('/{status}/users-list', [
                    'as' => 'manage.user.read.list',
                    'uses' => 'ManageUserController@userDataTableList',
                ]);

                // Add New User
                Route::get('/add', [
                    'as' => 'manage.user.add',
                    'uses' => 'ManageUserController@addNewUserView',
                ]);
                // Add New User Process
                Route::post('/process-add', [
                    'as' => 'manage.user.write.create',
                    'uses' => 'ManageUserController@processAddNewUser',
                ]);                
                // Edit User
                Route::get('/{userUid}/edit', [
                    'as' => 'manage.user.edit',
                    'uses' => 'ManageUserController@editUser',
                ]);
                // Update User
                Route::post('/{userUid}/process-update', [
                    'as' => 'manage.user.write.update',
                    'uses' => 'ManageUserController@processUpdateUser',
                ]);
                // Re-send activation email
                Route::post('/{userUid}/resend-activation-email', [
                    'as' => 'manage.user.write.resend_activation_email',
                    'uses' => 'ManageUserController@resendActivationEmail',
                ]);
                // Soft Delete User
                Route::post('/{userUid}/process-soft-delete', [
                    'as' => 'manage.user.write.soft_delete',
                    'uses' => 'ManageUserController@processUserSoftDelete',
                ]);
                // Permanent  Delete User
                Route::post('/{userUid}/process-permanent-delete', [
                    'as' => 'manage.user.write.permanent_delete',
                    'uses' => 'ManageUserController@processUserPermanentDelete',
                ]);
                // Restore User
                Route::post('/{userUid}/process-restore-user', [
                    'as' => 'manage.user.write.restore_user',
                    'uses' => 'ManageUserController@processRestoreUser',
                ]);
                // Blocked User
                Route::post('/{userUid}/process-block-user', [
                    'as' => 'manage.user.write.block_user',
                    'uses' => 'ManageUserController@processUserBlock',
                ]);
                // Unblocked User
                Route::post('/{userUid}/process-unblock-user', [
                    'as' => 'manage.user.write.unblock_user',
                    'uses' => 'ManageUserController@processUserUnblock',
                ]);
                // Show User Details
                Route::get('/{userUid}/details', [
                    'as' => 'manage.user.read.details',
                    'uses' => 'ManageUserController@getUserDetails',
                ]);

                // Verify user profile
                Route::post('/{userUid}/verify-profile', [
                    'as' => 'manage.user.write.verify',
                    'uses' => 'ManageUserController@processVerifyUserProfile',
				]);

                // Aprove user profile
                Route::post('/{userUid}/approve-profile', [
                    'as' => 'manage.user.write.approve',
                    'uses' => 'ManageUserController@processApproveUserProfile',
                ]);

                // Reject user profile
                Route::post('/{userUid}/reject-profile', [
                    'as' => 'manage.user.write.reject',
                    'uses' => 'ManageUserController@processRejectUserProfile',
                ]);
				
				// Manage User transaction list
                Route::get('/{userUid}/manage-user-transaction-list', [
                    'as' => 'manage.user.read.transaction_list',
                    'uses' => 'ManageUserController@manageUserTransactionList',
                ]);
			});
			
			/*
            Manage Credit Package Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'CreditPackage\Controllers',
                'prefix' => 'manage/credit-package',
            ], function () {
                //list
                Route::get('/list', [
                    'as' => 'manage.credit_package.read.list',
                    'uses' => 'CreditPackageController@getCreditPackageList',
				]);
				
				// Package add view
                Route::get('/add-package', [
                    'as' => 'manage.credit_package.add.view',
                    'uses' => 'CreditPackageController@packageAddView',
				]);
				
				// Package add
                Route::post('/add-package-process', [
                    'as' => 'manage.credit_package.write.add',
                    'uses' => 'CreditPackageController@addPackage',
				]);
				
				// Package edit view
                Route::get('/{packageUId}/edit-package', [
                    'as' => 'manage.credit_package.edit.view',
                    'uses' => 'CreditPackageController@packageEditView',
                ]);

                // Package edit process
                Route::post('/{packageUId}/edit-package-process', [
                    'as' => 'manage.credit_package.write.edit',
                    'uses' => 'CreditPackageController@editPackage',
				]);
				
				// Package delete view
                Route::post('/{packageUId}/delete-package', [
                    'as' => 'manage.credit_package.write.delete',
                    'uses' => 'CreditPackageController@processDeletePackage',
                ]);
           	});

            /*
            Manage Credit wallet User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'manage/fake-user',
            ], function () {
               
                // Add New User
                Route::get('/generate', [
                    'as' => 'manage.fake_users.read.generator_options',
                    'uses' => 'ManageUserController@fetchFakeUserOptions',
                ]);
                // Add New User Process
                Route::post('/generate-fake-users', [
                    'as' => 'manage.fake_users.write.create',
                    'uses' => 'ManageUserController@generateFakeUser',
                ]);
           	});

            /*
            Media Component Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Media\Controllers',
                'prefix'    => 'media',
            ], function () {
                // Temp Upload
                Route::post('/upload-temp-media', [
                    'as' => 'media.upload_temp_media',
                    'uses' => 'MediaController@uploadTempMedia',
				]);
				// Gift Temp Upload
                Route::post('/upload-gift-temp-media', [
                    'as' => 'media.gift.upload_temp_media',
                    'uses' => 'MediaController@uploadGiftTempMedia',
				]);
				// Sticker Temp Upload
                Route::post('/upload-sticker-temp-media', [
                    'as' => 'media.sticker.upload_temp_media',
                    'uses' => 'MediaController@uploadStickerTempMedia',
				]);
				// Package Temp Upload
                Route::post('/upload-package-temp-media', [
                    'as' => 'media.package.upload_temp_media',
                    'uses' => 'MediaController@uploadPackageTempMedia',
                ]);
                // Upload Logo
                Route::post('/upload-logo', [
                    'as' => 'media.upload_logo',
                    'uses' => 'MediaController@uploadLogo',
                ]);
                // Upload Small Logo
                Route::post('/upload-small-logo', [
                    'as' => 'media.upload_small_logo',
                    'uses' => 'MediaController@uploadSmallLogo',
                ]);
                // Upload Favicon
                Route::post('/upload-favicon', [
                    'as' => 'media.upload_favicon',
                    'uses' => 'MediaController@uploadFavicon',
                ]);
            });
            
            /*
            Dashboard Component Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Dashboard\Controllers'
            ], function () {
                // dashboard view
                Route::get('/', [
                    'as' => 'manage.dashboard',
                    'uses' => 'DashboardController@loadDashboardView',
                ]);   
            });
            
            /*
            Configuration Component Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Configuration\Controllers',
                'prefix'    => 'configuration',
            ], function () {

                // Clear Cache Everything
                Route::get('/clear-system-cache', [
                    'as' => 'manage.configuration.clear_cache',
                    'uses' => 'ConfigurationController@clearSystemCache',
                ]);
                
                // View Configuration View
                Route::get('/{pageType}', [
                    'as' => 'manage.configuration.read',
                    'uses' => 'ConfigurationController@getConfiguration',
                ]);

                // Process Configuration Data
                Route::post('/{pageType}/process-configuration-store', [
                    'as' => 'manage.configuration.write',
                    'uses' => 'ConfigurationController@processStoreConfiguration',
                ]);    

                // Process Configuration Data
                Route::post('/{pageType}/process-configuration-delete/{cupom}', [
                    'as' => 'manage.configuration.delete',
                    'uses' => 'ConfigurationController@processDeleteConfiguration',
                ]);            
			});
			
			/*
            Manage Financial transaction Components Manage Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                    'namespace' => 'FinancialTransaction\Controllers',
                    'prefix' => 'financial-transaction',
                ], function () {
				//Manage Financial transaction transaction View
                Route::get('/{transactionType}/list', [
                    'as' => 'manage.financial_transaction.read.view_list',
                    'uses' => 'FinancialTransactionController@financialTransactionViewList',
				]);

				// Financial transaction list
                Route::get('/{transactionType}/transaction-list', [
                    'as' => 'manage.financial_transaction.read.list',
                    'uses' => 'FinancialTransactionController@getTransactionList',
				]);
				
				// Delete all test transaction 
                Route::post('/delete-all-test-transaction', [
                    'as' => 'manage.financial_transaction.write.delete.all_transaction',
                    'uses' => 'FinancialTransactionController@deleteAllTestTransaction',
                ]);
			});
            
            /*
            Pages Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                    'namespace' => 'Pages\Controllers',
                    'prefix' => 'pages',
                ], function () {
                // pages view
                Route::get('/', [
                    'as' => 'manage.page.view',
                    'uses' => 'ManagePagesController@pageListView',
                ]);
                
                // pages view
                Route::get('/list', [
                    'as' => 'manage.page.list',
                    'uses' => 'ManagePagesController@getDatatableData',
                ]);

                // pages add view
                Route::get('/add', [
                    'as' => 'manage.page.add.view',
                    'uses' => 'ManagePagesController@pageAddView',
                ]);

                // pages add process
                Route::post('/page-add-process', [
                    'as' => 'manage.page.write.add',
                    'uses' => 'ManagePagesController@processAddPage',
                ]);

                // pages edit view
                Route::get('/{pageUId}/edit', [
                    'as' => 'manage.page.edit.view',
                    'uses' => 'ManagePagesController@pageEditView',
                ]);

                // pages edit process
                Route::post('/{pageUId}/page-edit-process', [
                    'as' => 'manage.page.write.edit',
                    'uses' => 'ManagePagesController@processEditPage',
                ]);

                // pages delete process
                Route::post('/{pageUId}/page-delete', [
                    'as' => 'manage.page.write.delete',
                    'uses' => 'ManagePagesController@delete',
                ]);
            });

            /*
            Gift Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                    'namespace' => 'Item\Controllers'
                ], function () {
                // Gift view
                Route::get('/gift', [
                    'as' => 'manage.item.gift.view',
                    'uses' => 'ManageGiftController@giftListView',
                ]);

                // Gift add view
                Route::get('/add-gift', [
                    'as' => 'manage.item.gift.add.view',
                    'uses' => 'ManageGiftController@giftAddView',
                ]);

                // Gift add
                Route::post('/add-gift-process', [
                    'as' => 'manage.item.gift.write.add',
                    'uses' => 'ManageGiftController@addGift',
                ]);

                // Gift edit view
                Route::get('/{giftUId}/edit-gift', [
                    'as' => 'manage.item.gift.edit.view',
                    'uses' => 'ManageGiftController@giftEditView',
                ]);

                // Gift edit process
                Route::post('/{giftUId}/edit-gift-process', [
                    'as' => 'manage.item.gift.write.edit',
                    'uses' => 'ManageGiftController@editGift',
                ]);

                // Gift delete view
                Route::post('/{giftUId}/delete-gift', [
                    'as' => 'manage.item.gift.write.delete',
                    'uses' => 'ManageGiftController@deleteGift',
                ]);

                // Sticker view
                Route::get('/sticker', [
                    'as' => 'manage.item.sticker.view',
                    'uses' => 'ManageStickerController@stickerListView',
				]);
				
				// Upload Sticker image
                Route::post('/upload-sticker-image', [
                    'as' => 'manage.item.sticker.write.upload_image',
                    'uses' => 'ManageStickerController@uploadStickerImage',
                ]);

                // Sticker add view
                Route::get('/add-sticker', [
                    'as' => 'manage.item.sticker.add.view',
                    'uses' => 'ManageStickerController@stickerAddView',
                ]);

                // Sticker add
                Route::post('/add-sticker-process', [
                    'as' => 'manage.item.sticker.write.add',
                    'uses' => 'ManageStickerController@addSticker',
                ]);

                // Sticker edit view
                Route::get('/{stickerUId}/edit-sticker', [
                    'as' => 'manage.item.sticker.edit.view',
                    'uses' => 'ManageStickerController@stickerEditView',
                ]);

                // Sticker edit process
                Route::post('/{stickerUId}/edit-sticker-process', [
                    'as' => 'manage.item.sticker.write.edit',
                    'uses' => 'ManageStickerController@editSticker',
                ]);

                // Sticker delete view
                Route::post('/{stickerUId}/delete-sticker', [
                    'as' => 'manage.item.sticker.write.delete',
                    'uses' => 'ManageStickerController@deleteSticker',
                ]);
            });

            /*
            User AbuseReport Component Manage Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'AbuseReport\Controllers',
                'prefix'    => 'abuse-report',
            ], function () {
                // abuse report view list
                Route::get('/{status}/list', [
                    'as' => 'manage.abuse_report.read.list',
                    'uses' => 'AbuseReportController@reportListView',
                ]);

                // abuse report moderated
                Route::post('/moderate-report', [
                    'as' => 'manage.abuse_report.write.moderated',
                    'uses' => 'AbuseReportController@reportModerated',
                ]);
            });

            /*
            Manage Translations
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Translation\Controllers',
                'prefix'    => 'translations',
            ], function () {

                Route::get('/', [
                    'as' => 'manage.translations.languages',
                    'uses' => 'TranslationController@languages',
                ]);

                // Store New Language
                Route::post('/process-language-store', [
                    'as' => 'manage.translations.write.language_create',
                    'uses' => 'TranslationController@storeLanguage',
                ]);

                // Update Language
                Route::post('/process-language-update', [
                    'as' => 'manage.translations.write.language_update',
                    'uses' => 'TranslationController@updateLanguage',
                ]);

                // Delete Language
                Route::post('/{languageId}/process-language-delete', [
                    'as' => 'manage.translations.write.language_delete',
                    'uses' => 'TranslationController@deleteLanguage',
                ]);

                Route::get('language/{languageId}', [
                    'as' => 'manage.translations.lists',
                    'uses' => 'TranslationController@lists',
                ]);

                Route::get('/scan/{languageId}/{preventReload?}', [
                    'as' => 'manage.translations.scan',
                    'uses' => 'TranslationController@scan',
                ]);

                Route::post('/update', [
                    'as' => 'manage.translations.update',
                    'uses' => 'TranslationController@update',
                ]);

                Route::get('/export/{languageId}', [
                    'as' => 'manage.translations.export',
                    'uses' => 'TranslationController@export',
                ]);

                Route::post('/import/{languageId}', [
                    'as' => 'manage.translations.import',
                    'uses' => 'TranslationController@import',
                ]);
            });
        });
    });
});