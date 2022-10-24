<?php
/*
* MessengerEngine.php - Main component file
*
* This file is part of the Messenger component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Messenger;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Base\BaseMailer;
use Auth;
use YesSecurity;
use PushBroadcast;
use Carbon\Carbon;
use App\Yantrana\Components\Messenger\Repositories\MessengerRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;
use App\Yantrana\Components\Item\Repositories\ManageItemRepository;
use App\Yantrana\Components\User\Repositories\CreditWalletRepository;
use App\Yantrana\Components\Media\MediaEngine;
use App\Yantrana\Components\Messenger\Interfaces\MessengerEngineInterface;
use App\Yantrana\Support\CommonTrait;
use App\Yantrana\Components\UserSetting\Repositories\UserSettingRepository;
use \Illuminate\Support\Facades\URL;

class MessengerEngine extends BaseEngine implements MessengerEngineInterface 
{   
     
    /**
     * @var  MessengerRepository $messengerRepository - Messenger Repository
     */
    protected $messengerRepository;
    
    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;
    
    /**
     * @var BaseMailer - Base Mailer
     */
    protected $baseMailer;

     /**
     * @var ManageItemRepository - ManageItem Repository
     */
    protected $manageItemRepository;
    
    /**
     * @var  CreditWalletRepository $creditWalletRepository - CreditWallet Repository
     */
    protected $creditWalletRepository;
        
    /**
     * @var  MediaEngine $mediaEngine - Media Engine
     */
	protected $mediaEngine;

     /**
     * @var  UserSettingRepository $userSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;
	
	 /**
     * @var CommonTrait - Common Trait
     */
    use CommonTrait;

    /**
      * Constructor
      *
      * @param  MessengerRepository $messengerRepository - Messenger Repository
      * @param UserRepository  $userRepository  - User Repository
      * @param BaseMailer  $baseMailer  - Base Mailer
      * @param ManageItemRepository $manageItemRepository - ManageItem Repository
      * @param  CreditWalletRepository $creditWalletRepository - CreditWallet Repository
      * @param  MediaEngine $mediaEngine - Media Engine
      * @param  UserSettingRepository $userSettingRepository - UserSetting Repository
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(
        MessengerRepository $messengerRepository,
        UserRepository $userRepository,
        BaseMailer  $baseMailer,
        ManageItemRepository $manageItemRepository,
        CreditWalletRepository $creditWalletRepository,
        UserSettingRepository $userSettingRepository,
        MediaEngine $mediaEngine
    )
    {
        $this->baseMailer                   = $baseMailer;
        $this->messengerRepository      = $messengerRepository;
        $this->userRepository           = $userRepository;
        $this->manageItemRepository     = $manageItemRepository;
        $this->creditWalletRepository 	= $creditWalletRepository;
        $this->mediaEngine              = $mediaEngine;
        $this->userSettingRepository    = $userSettingRepository;
    }

    /**
      * Prepare Conversation List
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareConversationList($specificUserId = null)
    {
        $userDetails = getUserAuthInfo();
        if (\__isEmpty($specificUserId)) {            
            $userId = array_get($userDetails, 'profile._id');
            $messengerUserCollection = $this->messengerRepository->fetchMessengerUsers($userId);
        } else {
            $messengerUserCollection = $this->userRepository->fetchUsersWithProfiles([$specificUserId]);
        }
        
        $messengerUsers = $currentUserData = [];

        // check if messenger users exists
        if (!\__isEmpty($messengerUserCollection)) {
            foreach($messengerUserCollection as $user) {
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                if (!\__isEmpty($user->profile_picture)) {
                    $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $user->profile_picture);
                }
                $messengerUsers[] = [
                    'user_id'           => $user->user_id,
                    'user_uid'          => $user->user_uid,
                    'user_full_name'    => $user->first_name.' '.$user->last_name,
                    'profile_picture'   => $profilePictureUrl,
                    'about_me'          => $user->about_me,
                    'is_online'         => $this->getUserOnlineStatus($user->updated_at)
                ];
            }
        }

        // get folder path of logged in user
        $loggedInUserProfilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => array_get($userDetails, 'profile._uid')]);
        $currentUserProfilePictureUrl = noThumbImageURL();
        // Check if current user profile picture is available
        if (!__isEmpty(array_get($userDetails, 'profile.profile_picture'))) {
            $currentUserProfilePictureUrl = getMediaUrl($loggedInUserProfilePictureFolderPath, array_get($userDetails, 'profile.profile_picture'));
        }
        // Prepare data for current logged in user
        $currentUserData = [
            'logged_in_user_full_name' => array_get($userDetails, 'profile.full_name'),
            'logged_in_user_profile_picture' => $currentUserProfilePictureUrl,
            'logged_in_user_about_me' => array_get($userDetails, 'profile.about_me')
        ];
        
        return $this->engineReaction(1, [
            'currentUserData'   => $currentUserData,
            'messengerUsers'    => $messengerUsers
        ]);
    }

    /**
      * Prepare User Conversation
      *
      * @param number $userId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareUserMessage($userId)
    {
        $userDetails = $this->userRepository->fetchWithProfile($userId);
        // Check if user exists
        if (\__isEmpty($userId)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }

        // Get profile picture folder path
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $userDetails->_uid]);
        $profilePictureUrl = noThumbImageURL();
        if (!\__isEmpty($userDetails->profile_picture)) {
            $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $userDetails->profile_picture);
        }

        $messageRequestStatus = 'SEND_NEW_MESSAGE';
        $enableAudioVideoLinks = false;
        // Fetch Message Request
        $messageRequest = $this->messengerRepository->fetchMessageRequest($userId);
        // Check if message request Exists
        if (!\__isEmpty($messageRequest)) {
            switch ($messageRequest->type) {
                case 9: // Chat Invitation
                    if ($messageRequest->from_users__id == getUserID()) {
                        $messageRequestStatus = 'MESSAGE_REQUEST_SENT';
                    } else {
                        $messageRequestStatus = 'MESSAGE_REQUEST_RECEIVED';
                    }                    
                    break;
                
                case 10: // Accept
                    $enableAudioVideoLinks = true;
                    $messageRequestStatus = 'MESSAGE_REQUEST_ACCEPTED';
                    break;
                
                case 11: // Decline
                    if ($messageRequest->from_users__id == getUserID()) {
                        $messageRequestStatus = 'MESSAGE_REQUEST_DECLINE_BY_USER';
                    } else {
                        $messageRequestStatus = 'MESSAGE_REQUEST_DECLINE';
                    }
                    break;
            }
        }
        
        $userAge = isset($userDetails->dob) ? Carbon::parse($userDetails->dob)->age : null;


        // Prepare user data
        $userData = [
            'user_id' => $userDetails->_id,
            'user_uid' => $userDetails->_uid,
            'username' => $userDetails->username,
            'full_name' => $userDetails->first_name.' '.$userDetails->last_name,
            'about_me' => $userDetails->about_me,
            'age'      => $userAge,
            'address'      =>  $userDetails->fullAddress,
            'profile_picture_image' => $profilePictureUrl,
            'messageRequestStatus' => $messageRequestStatus,
            'enableAudioVideoLinks' => $enableAudioVideoLinks
        ];
        // Fetch message collection
        $messageCollection = $this->messengerRepository->fetchConversations($userId);
        $userConversations = [];
        // check if messages exists
        if (!__isEmpty($messageCollection)) {
            foreach ($messageCollection as $messageChat) {
                $message = $messageChat->message;
                if ($messageChat->type == 2) {
                    $messengerFolderPath = getPathByKey('messenger_file', ['{_uid}' => $messageChat->_uid]);
                    $message = getMediaUrl($messengerFolderPath, $message);
                }
                
                $userConversations[] = [
                    'chat_id' => $messageChat->_id,
                    'message' => $message,
                    'created_on' => $this->formatDateTimeForMessage($messageChat->created_at),
                    'message_from' => $messageChat->message_from_first_name.' '.$messageChat->message_from_last_name,
                    'message_to' => $messageChat->message_to_first_name.' '.$messageChat->message_to_last_name,
                    'is_message_received' => ($messageChat->message_from_user_id == $userId) ? true : false,
                    'type'  => $messageChat->type,
                ];
            }
        }

        $userDetails = getUserAuthInfo();
        // get folder path of logged in user
        $loggedInUserProfilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => array_get($userDetails, 'profile._uid')]);
        $currentUserProfilePictureUrl = noThumbImageURL();
        // Check if current user profile picture is available
        if (!__isEmpty(array_get($userDetails, 'profile.profile_picture'))) {
            $currentUserProfilePictureUrl = getMediaUrl($loggedInUserProfilePictureFolderPath, array_get($userDetails, 'profile.profile_picture'));
        }

        $userMessagesData = [
            'userData' => $userData,
            'userConversations' => $userConversations,
            'loggedInUserProfilePicture' => $currentUserProfilePictureUrl
        ];

        // Check if request for mobile data
        if (isMobileAppRequest()) {
            $userMessagesData['mobileAppData'] = [
                'allowGiphy' => getStoreSettings('allow_giphy'),
                'giphyKey' => getStoreSettings('giphy_key')
            ];
        }
        
        return $this->engineReaction(1, $userMessagesData);
    }

    /**
      * Format date time for message
      *
      * @param obj $dateTime
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    protected function formatDateTimeForMessage($dateTime = null)
    {
        // check if date time not exists
        if (__isEmpty($dateTime)) {
            $dateTime = Carbon::now();
        }

        return Carbon::parse($dateTime)->format('j F Y g:i A');
    }

    /**
      * Process Send Message to the user
      *
      * @param number $userId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function processSendMessage($inputData, $userId)
    {
        $transactionResponse = $this->messengerRepository->processTransaction(function() use ($inputData, $userId) {
            $userDetails = $this->userRepository->fetchWithProfile($userId);
            // Check if user exists
            if (__isEmpty($userId)) {
                return $this->messengerRepository->transactionResponse(18, [
                    'show_message' => true,
                    'storedData' => $inputData
                ], __tr('User does not exists.'));
            }

            // check if messenger type is 2 (File Upload)
            if ($inputData['type'] == 2) {
                $file = $inputData['filepond'];
                $fileOriginalName = $file->getClientOriginalName();
                $fileExtension    = $file->getClientOriginalExtension();
                $fileBaseName     = str_slug(basename($fileOriginalName, '.'.$fileExtension));
                $fileName         = $fileBaseName.".$fileExtension";
                $inputData['message'] = $fileName;
            }

            $isMessageRequestReceived = false;
            // Fetch message request 
            $messageRequest = $this->messengerRepository->fetchMessageRequest($userId);
            
            // Check if message request not exists
            // Then store initial message request
            if (\__isEmpty($messageRequest)) {
                notificationLog('Requisição de mensagem do usuário(a) '.' '.getUserAuthInfo('profile.full_name'), route('user.profile_view', ['username' => getUserAuthInfo('profile.username')]), null, $userDetails->_id);
                $initialMessageGeneratedUid = YesSecurity::generateUid();
                $isMessageRequestReceived = true;
                $initialMessageRequest = [
                    [
                        'status' => 1, // Sent
                        'message' => 'Message Request',
                        'type' => 9,
                        'from_users__id' => getUserID(),
                        'to_users__id' => $userDetails->_id,
                        'users__id' => getUserID(),
                        'integrity_id' => $initialMessageGeneratedUid
                    ],
                    [
                        'status' => 1, // Sent
                        'message' => 'Message Request',
                        'type' => 9,
                        'from_users__id' => getUserID(),
                        'to_users__id' => $userDetails->_id,
                        'users__id' => $userDetails->_id,
                        'integrity_id' => $initialMessageGeneratedUid
                    ]
                ];
                // Initial message request store in DB
                $this->messengerRepository->storeMessage($initialMessageRequest);

                //user full name
                $userFullName = $userDetails->first_name.' '.$userDetails->last_name;
                $loggedInUserFullName = Auth::user()->first_name.' '.Auth::user()->last_name;

                //contact email data
                $emailData = [
                    'firstName' => $userFullName,
                    'visitorName' => $loggedInUserFullName,
                    'url' => URL::to('/')
                ];
                
                // check if email send to member
                if($this->baseMailer->notifyToUser('Você tem uma Nova Mensagem', 'account.newmessage', $emailData, $userDetails->email)){}

            } elseif ($messageRequest->type == 11) { // Message request decline
                return $this->messengerRepository->transactionResponse(2, [
                    'show_message' => true,
                    'storedData' => $inputData
                ], __tr('Requisição de mensagem recusada.'));
            }
            
            $userChatGeneratedUid = YesSecurity::generateUid();
            $message = $inputData['message'];
            // Prepare Message store data
            $chatData = [
                [
                    'status' => 1, // Sent
                    'message' => $message,
                    'type' => $inputData['type'],
                    'from_users__id' => getUserID(),
                    'to_users__id' => $userDetails->_id,
                    'users__id' => getUserID(),
                    'items__id' => array_get($inputData, 'item_id'),
                    'integrity_id' => $userChatGeneratedUid
                ],
                [
                    'status' => 1, // Sent
                    'message' => $message,
                    'type' => $inputData['type'],
                    'from_users__id' => getUserID(),
                    'to_users__id' => $userDetails->_id,
                    'users__id' => $userDetails->_id,
                    'items__id' => array_get($inputData, 'item_id'),
                    'integrity_id' => $userChatGeneratedUid
                ]
            ];
            // check if message is stored in db
            if ($addedMessagesUid = $this->messengerRepository->storeMessage($chatData)) {
                // check if message send by file upload
                if ($inputData['type'] == 2) {
                    $uploadedFileData = [];
                    $isFileUploaded = false;
                    foreach($addedMessagesUid as $messageUid) {
                        $messengerFolderPath = getPathByKey('messenger_file', ['{_uid}' => $messageUid]);
                        $uploadedFile = $this->mediaEngine->processUpload($inputData, $messengerFolderPath, 'messenger');
                        
                        if ($uploadedFile['reaction_code'] == 1) {
                            $isFileUploaded = true;
                            $message = $uploadedFile['data']['path'];
                            $uploadedFileData = [
                                'type' => $inputData['type'],
                                'message' => $uploadedFile['data']['path'],
                                'unique_id' => $inputData['unique_id']
                            ];
                        } else {
                            $uploadedFileData = [
                                'type' => $inputData['type'],
                                'message' => $uploadedFile['message'],
                                'unique_id' => $inputData['unique_id']
                            ];
                        }
                    }
                    // check if file not uploaded
                    if (!$isFileUploaded) {
                        return $this->messengerRepository->transactionResponse(2, [
                            'show_message' => true,
                            'storedData' => $inputData
                        ], $uploadedFileData['message']);
                    }
                    $inputData = $uploadedFileData;
                }
                
                $createdOn = $this->formatDateTimeForMessage();
                $inputData['created_on'] = $createdOn;

                // Send push notification to user
                PushBroadcast::notifyViaPusher('event.user.chat.messages' ,[
                    'type'    				=> $inputData['type'],
                    'userId'                => getUserID(),
                    'userUid' 				=> $userDetails->_uid,
                    'message' 				=> $message,
                    'createdOn'             => $createdOn,
                    'toUserUid'             => getUserUID(), //$userDetails->_uid,
                    'messageRequestStatus'  => $isMessageRequestReceived 
                                                ? 'MESSAGE_REQUEST_RECEIVED'
                                                : 'SEND_NEW_MESSAGE',
                    'requestFor'            => $isMessageRequestReceived
                                                ? 'MESSAGE_REQUEST'
                                                : 'MESSAGE_CHAT',
                    'showNotification' 		=> (getUserSettings('show_message_notification', $userDetails->_id) == 1) ? true : false,
                    'notificationMessage'   => __tr('Nova mensagem de __fullName__.', [
                                                    '__fullName__' => getUserAuthInfo('profile.full_name')
                                                ])
                ]);

                return $this->messengerRepository->transactionResponse(1, [
                    'storedData' => $inputData
                ], __tr('Message sent.'));
            }
            
            return $this->messengerRepository->transactionResponse(2, null, __tr('Something went wrong on server.'));
        });
        
        return $this->engineReaction($transactionResponse);
    }

    /**
      * Process accept / decline message request
      *
      * @param arr $inputData
      * @param number $userId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function processAcceptDeclineMessageRequest($inputData, $userId)
    {
        $currentLoggedInUserId = getUserID();
        $pendingMessageRequestCollection = $this->messengerRepository->fetchPendingMessageData($userId, $currentLoggedInUserId);
        // Check if pending message request collection exists
        if (!\__isEmpty($pendingMessageRequestCollection) 
            and $pendingMessageRequestCollection->count() == 2) {
            foreach ($pendingMessageRequestCollection as $message) {
                $messageUpdateData[] = [
                    '_id' => $message->_id,
                    'type' => ($inputData['message_request_status'] == 1)
                                ? 10 // Accept
                                : 11 // Reject
                ];
            }
            if ($this->messengerRepository->updateMessages($messageUpdateData)) {
                $message = __tr('Requisição de mensagem aceita. Agora vocês podem conversar um com o outro.');
                $type = 10;
                $messageRequestStatus = 'MESSAGE_REQUEST_ACCEPTED';
                if ($inputData['message_request_status'] == 2) {
                    $message = __tr('Message request rejected. ');
                    $type = 11;
                    $messageRequestStatus = 'MESSAGE_REQUEST_DECLINE_BY_USER';
                }
                
                $userDetails = $this->userRepository->fetchWithProfile($userId);
                $loggedInUserFullName = getUserAuthInfo('profile.full_name');

                // Send push notification to user
                PushBroadcast::notifyViaPusher('event.user.chat.messages' ,[
                    'type'    				=> $type,
                    'userId'                => $currentLoggedInUserId,
                    'userUid' 				=> $userDetails->_uid,
                    'message' 				=> '',
                    // 'createdOn'             => $createdOn,
                    'toUserUid'             => $userDetails->_uid,
                    'messageRequestStatus'  => $messageRequestStatus,
                    'requestFor'            => 'MESSAGE_REQUEST',
                    'showNotification' 		=> getUserSettings('show_message_notification', $userDetails->_id),
                    'notificationMessage'   => ($type == 10)
                                                ? __tr('Requisição de mensagem aceita por __fullName__.', [
                                                    '__fullName__' => $loggedInUserFullName
                                                ])
                                                : __tr('Requisição de mensagem rejeitado por __fullName__.', [
                                                    '__fullName__' => $loggedInUserFullName
                                                ])
                ]);
                
                return $this->engineReaction(1, ['show_message' => true], $message);
            }
        }
        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
      * Process delete message
      * @param number $userId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function processDeleteMessage($chatId)
    {
        $messageChatData = $this->messengerRepository->fetchById($chatId);
        
        // Check if message dta exists
        if (\__isEmpty($messageChatData)) {
            return $this->engineReaction(18, null, __tr('Message does not exists.'));
        }

        // Check if message type is upload
        if ($messageChatData->type == 2) {
            $messengerFolderPath = getPathByKey('messenger_file', ['{_uid}' => $messageChatData->_uid]);
            $this->mediaEngine->delete($messengerFolderPath, $messageChatData->message);
        }
        
        // Check if message deleted successfully
        if ($this->messengerRepository->deleteMessage($messageChatData)) {
            return $this->engineReaction(1, null, __tr('Message deleted successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Message not deleted.'));
    }

    /**
      * Process delete message
      *
      * @param arr $inputData
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function processDeleteAllMessages($inputData)
    {
        $toUserId = $inputData['to_user_id'];
        $messageCollection = $this->messengerRepository->fetchMyMessages($toUserId);

        // Loop over messages
        foreach($messageCollection as $messageChatData) {
            if ($messageChatData->type == 2) {
                $messengerFolderPath = getPathByKey('messenger_file', ['{_uid}' => $messageChatData->_uid]);
                $this->mediaEngine->delete($messengerFolderPath, $messageChatData->message);
            }
        }
        // Check if messages deleted
        if ($this->messengerRepository->deleteAllMessages($messageCollection->pluck('_id'))) {
            return $this->engineReaction(1, null, __tr('All messages deleted successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
      * Prepare Stickers
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareStickers()
    {
        $isPremiumUser = isPremiumUser();
        $stickerCollection = $this->manageItemRepository->fetchStickers($isPremiumUser);
        
        $stickers = [];
        // check if stickers exists
        if (!\__isEmpty($stickerCollection)) {
            foreach ($stickerCollection as $sticker) {
                $stickerImageUrl = '';
                $stickerImageFolderPath = getPathByKey('sticker_image', ['{_uid}' => $sticker->_uid]);
                $stickerImageUrl = getMediaUrl($stickerImageFolderPath, $sticker->file_name);
                $formattedPremiumPrice = $sticker->premium_price. ' Credits';
                $formattedNormalPrice = $sticker->normal_price. ' Credits';
                $isFree = false;
                if ($isPremiumUser) {
                    $isFree = ($sticker->premium_price == 0) ? true : false;
                } else {
                    $isFree = ($sticker->normal_price == 0) ? true : false;
                }
                $stickers[] = [
                    'id'                => $sticker->_id,
                    'image_url'         => $stickerImageUrl,
                    'title'             => $sticker->title,
                    'formatted_price'   => $isPremiumUser
                                            ? $formattedPremiumPrice
                                            : $formattedNormalPrice,
                    'is_free'           => $isFree,
                    'is_purchased'      => (!__isEmpty($sticker->items__id))
                                            ? true : false
                ];
            }
        }
        
        return $this->engineReaction(1, [
            'stickers' => $stickers
        ]);
    }

    /**
      * Process Buy Stickers
      *
      * @param array $inputData
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function processBuySticker($inputData)
    {
        $transactionResponse = $this->messengerRepository->processTransaction(function() use($inputData) {
            $stickerId = $inputData['sticker_id'];
            $userId = getUserID();
            $isPremiumUser = isPremiumUser();
            // Fetch sticker
            $stickerData = $this->manageItemRepository->fetch($stickerId);
            // Check if sticker exists
            if (\__isEmpty($stickerData)) {
                return $this->messengerRepository->transactionResponse(2, ['show_message' => true], __tr('Sticker does not exists.'));
            }
            // Get User sticker
            $userItem = $this->manageItemRepository->fetchByUserAndItemId($userId, $stickerId);
            // check if user already purchase this item
            if (!\__isEmpty($userItem)) {
                return $this->messengerRepository->transactionResponse(2, ['show_message' => true], __tr('You are already purchase this sticker.'));
            }
            // fetch user credits
            $totalUserCredits = totalUserCredits();
            // check if current user is premium user
            if ($isPremiumUser) {
                $stickerPrice = $stickerData->premium_price;
            } else {
                $stickerPrice = $stickerData->normal_price;
            }
            
            // check if sticker price is not greater than available credits
            if ($stickerData->normal_price > $totalUserCredits) {
                return $this->messengerRepository->transactionResponse(2, ['show_message' => true], __tr('Your credit ballance is too low, please purchase credits.'));
            }
            $isStickerPurchase = false;
            // Prepare store credit wallet transaction data
            $storeCreditWalletTransaction = [
                'status' => 1,
                'users__id' => $userId,
                'credits' => '-'.$stickerPrice
            ];
            // check if credit wallet transaction is stored
            if ($newCreditWallet = $this->creditWalletRepository->storeWalletTransaction($storeCreditWalletTransaction)) {
                $isStickerPurchase = true;            
            }
            // Prepare store use item data
            $storeUserItemData = [
                'users__id' => $userId,
                'items__id' => $stickerData->_id,
                'price'     => $stickerData->normal_price,
                'credit_wallet_transactions__id' => $newCreditWallet->_id
            ];
            // check if user item stored
            if ($this->manageItemRepository->storeUserItem($storeUserItemData)) {
                $isStickerPurchase = true;
            }
            // check if credit wallet added
            if ($isStickerPurchase) {
                return $this->messengerRepository->transactionResponse(1, [
                    'show_message' => true,
                    'availableCredits' => totalUserCredits()
                ], __tr('Sticker purchased successfully.'));
            }
            
            return $this->messengerRepository->transactionResponse(2, ['show_message' => true], __tr('Sticker not purchased.'));
        });
        
        return $this->engineReaction($transactionResponse);
	}

    /**
      * Process Call Token Data
      *
      * @param number $userUId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareApiUserCallerCallData($userUId, $type)
    {
        //get user details
        $user = $this->userRepository->fetch($userUId);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        //get user online status
        $userOnlineStatus = $this->getUserOnlineStatus($user->userAuthorityUpdatedAt);
        
        // Check if user exists
        if (!__isEmpty($userOnlineStatus) and $userOnlineStatus == 3) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User seems to be offline.'));
        }
         // fetch User details
        $receiverProfile = $this->userSettingRepository->fetchUserProfile($user->_id);
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->_uid]);
        $profilePictureUrl = noThumbImageURL();
        // Check if user profile exists
        if (!__isEmpty($receiverProfile)) {
            if (!__isEmpty($receiverProfile->profile_picture)) {
                $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $receiverProfile->profile_picture);
            }
        }


        $loggedInUser = Auth::user();
        //loggedIn user name
        $loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
        //Set agora App Id or Agora App Certificate key Set
        $agoraAppId = null;
        $agoraAppCertificateKey = null;
        //check agora enable or not
        if (getStoreSettings('allow_pusher') and getStoreSettings('allow_agora')) {
            $agoraAppId = getStoreSettings('agora_app_id');
            $agoraAppCertificateKey = getStoreSettings('agora_app_certificate_key');
        } else {
            //error response
            return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong, please contact to administrator.'));
        }
        
        # appID: The App ID issued to you by Agora. Apply for a new App ID from 
        #        Agora Dashboard if it is missing from your kit. See Get an App ID.
        # appCertificate:   Certificate of the application that you registered in 
        #                  the Agora Dashboard. See Get an App Certificate.
        # channelName:Unique channel name for the AgoraRTC session in the string format
        # userAccount: The user account. 
        # role: Role_Rtm_User = 1
        # privilegeExpireTs: represented by the number of seconds elapsed since 
        #                    1/1/1970. If, for example, you want to access the
        #                    Agora Service within 10 minutes after the token is 
        #                    generated, set expireTimestamp as the current 
        #                    timestamp + 600 (seconds)./
        $channel = sha1($user->_uid.$loggedInUser->_uid.\uniqid('', true));
        //generate random token for call verification
        $token = \RtmTokenBuilder::buildToken($agoraAppId, $agoraAppCertificateKey, $channel, $loggedInUser->_uid, 1, time() + 500000);
        //set Call type
        $callType = 1;
        $callTypeTitle = 'Audio Call';
        //set Call type
        if ($type == 'audio') {
            $callTypeTitle = 'Audio Call';
            $callType   = 1;
        } else if ($type == 'video') {
            $callTypeTitle = 'Video Call';
            $callType   = 2;
        }

        return $this->engineReaction(1, [
            'userFullName'      => $user->first_name.' '.$user->last_name,
            'receiverUserUid'   => $user->_uid,
            'callerUserUid'     => $loggedInUser->_uid,            
            'token'             => $token,
            'channel'           => $channel,
            'callType'          => $callType,
            'callTypeTitle'     => $callTypeTitle,
            'receiverProfileImg'=> $profilePictureUrl
        ]);
    }

    /**
      * Process Call Token Data
      *
      * @param number $userUId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function processReceiverJoinCall($requestData)
    {
        $callInitializeData = $requestData['callInitializeData'];
        
        //get user details
        $user = $this->userRepository->fetch($callInitializeData['receiverUserUid']);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        $loggedInUser = Auth::user();
        //loggedIn user name
        $loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;

        // fetch User details
        $callerProfile = $this->userSettingRepository->fetchUserProfile($loggedInUser->_id);
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $loggedInUser->_uid]);
        // Check if user profile exists
        if (!__isEmpty($callerProfile)) {
            if (!__isEmpty($callerProfile->profile_picture)) {
                $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $callerProfile->profile_picture);
            }
        }

        //push data to pusher
        PushBroadcast::notifyViaPusher('event.call.notification' ,[
            'type'                  => 'caller-calling',
            'userUid'               => $user->_uid,
            'receiverUserUid'       => $user->_uid,
            'token'                 => $callInitializeData['token'],
            'channel'               => $callInitializeData['channel'],
            'subject'               => __tr('User Call'),
            'callType'              => $callInitializeData['callType'],
            'callTypeTitle'         => $callInitializeData['callTypeTitle'],
            'callerUserUid'         => $loggedInUser->_uid,
            'callerName'            => $loggedInUserName,
            'message'               => $loggedInUserName.__tr(' is Calling You. '),
            'messageType'           => __tr('success'),
            'callerProfilePicture'  => $profilePictureUrl
        ]);

        return $this->engineReaction(1, [
            'userFullName'      => $user->first_name.' '.$user->last_name,
            'receiverUserUid'   => $user->_uid,
            'callerUserUid'     => $loggedInUser->_uid,            
            'token'             => $callInitializeData['token'],
            'channel'           => $callInitializeData['channel'],
            'callType'          => $callInitializeData['callType'],
            'callTypeTitle'     => $callInitializeData['callTypeTitle']
        ]);
    }
	
	/**
      * Process Call Token Data
      *
      * @param number $userUId
      *
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareUserCallerCallData($userUId, $type)
    {
		//get user details
		$user = $this->userRepository->fetch($userUId);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
		}
		//get user online status
		$userOnlineStatus = $this->getUserOnlineStatus($user->userAuthorityUpdatedAt);
		
		// Check if user exists
        if (!__isEmpty($userOnlineStatus) and $userOnlineStatus == 3) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User seems to be offline.'));
		}

		$loggedInUser = Auth::user();
		//loggedIn user name
		$loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
		//Set agora App Id or Agora App Certificate key Set
		$agoraAppId = null;
		$agoraAppCertificateKey = null;
		//check agora enable or not
		if (getStoreSettings('allow_pusher') and getStoreSettings('allow_agora')) {
			$agoraAppId = getStoreSettings('agora_app_id');
			$agoraAppCertificateKey = getStoreSettings('agora_app_certificate_key');
		} else {
			//error response
			return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong, please contact to administrator.'));
		}
		
		# appID: The App ID issued to you by Agora. Apply for a new App ID from 
		#        Agora Dashboard if it is missing from your kit. See Get an App ID.
		# appCertificate:	Certificate of the application that you registered in 
		#                  the Agora Dashboard. See Get an App Certificate.
		# channelName:Unique channel name for the AgoraRTC session in the string format
		# userAccount: The user account. 
		# role: Role_Rtm_User = 1
		# privilegeExpireTs: represented by the number of seconds elapsed since 
		#                    1/1/1970. If, for example, you want to access the
		#                    Agora Service within 10 minutes after the token is 
		#                    generated, set expireTimestamp as the current 
		#                    timestamp + 600 (seconds)./
		$channel = sha1($user->_uid.$loggedInUser->_uid.\uniqid('', true));
		//generate random token for call verification
		$token = \RtmTokenBuilder::buildToken($agoraAppId, $agoraAppCertificateKey, $channel, $loggedInUser->_uid, 1, time() + 500000);
		//set Call type
		$callType = 1;
		$callTypeTitle = 'Audio Call';
		//set Call type
		if ($type == 'audio') {
			$callTypeTitle = 'Audio Call';
			$callType	= 1;
		} else if ($type == 'video') {
			$callTypeTitle = 'Video Call';
			$callType	= 2;
		}

		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.notification' ,[
			'type'    				=> 'caller-calling',
            'userUid' 				=> $user->_uid,
			'receiverUserUid' 		=> $user->_uid,
			'token'					=> $token,
            'channel'				=> $channel,
			'subject' 				=> __tr('User Call'),
            'callType'				=> $callType,
            'callTypeTitle'			=> $callTypeTitle,
            'callerUserUid'         => $loggedInUser->_uid,
            'callerName'            => $loggedInUserName,
			'message' 				=> $loggedInUserName.__tr(' is Calling You. '),
			'messageType' 			=> __tr('success')
		]);

		return $this->engineReaction(1, [
			'userFullName' 		=> $user->first_name.' '.$user->last_name,
			'receiverUserUid' 	=> $user->_uid,
            'callerUserUid'     => $loggedInUser->_uid,            
			'token' 			=> $token,
            'channel'			=> $channel,
            'callType'			=> $callType,
            'callTypeTitle'		=> $callTypeTitle
		]);
	}

	/**
      * Prepare caller reject call
      * 
      * @param number $receiverUserUid
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareCallerRejectCall($receiverUserUid)
    {
		//get user details
		$user = $this->userRepository->fetch($receiverUserUid);
	
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
		}
		$loggedInUser = Auth::user();
		//loggedIn user name
		$loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.reject.notification' ,[
			'type'    				=> 'caller-reject-call',
			'userUid' 				=> $user->_uid,
			'subject' 				=> __tr('Caller Reject Call'),
            'callerName'            => $loggedInUserName,
			'message' 				=> __tr('Disconnect Call.'),
			'messageType' 			=> __tr('success')
		]);

		return $this->engineReaction(1, null);
	}

	/**
      * Prepare receiver reject call
      * 
      * @param number $callerUserUid
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareReceiverRejectCall($callerUserUid)
    {
		//get user details
		$user = $this->userRepository->fetch($callerUserUid);
	
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
		}
		$loggedInUser = Auth::user();
		//loggedIn user name
		$loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.reject.notification' ,[
			'type'    				=> 'receiver-reject-call',
			'userUid' 				=> $user->_uid,
			'subject' 				=> __tr('Receiver Reject Call'),
            'receiverName'          => $loggedInUserName,
			'message' 				=> __tr('Disconnect Call.'),
			'messageType' 			=> __tr('success')
		]);
		return $this->engineReaction(1, null);
	}

	/**
      * Prepare caller call errors
      * 
      * @param number $receiverUserUid
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareCallerCallErrors($receiverUserUid)
    {
		//get user details
		$user = $this->userRepository->fetch($receiverUserUid);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
		}
		$loggedInUser = Auth::user();
		//loggedIn user name
		$loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.error.notification' ,[
			'type'    				=> 'caller-error',
			'userUid' 				=> $user->_uid,
			'subject' 				=> __tr('Caller Errors'),
            'callerName'            => $loggedInUserName,
			'message' 				=> __tr('Disconnect Call.'),
			'messageType' 			=> __tr('errors')
		]);
		return $this->engineReaction(1, null);
	}

	/**
      * Prepare receiver call errors
      * 
      * @param number $callerUserUid
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareReceiverCallErrors($callerUserUid)
    {
		//get user details
		$user = $this->userRepository->fetch($callerUserUid);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
		}
		$loggedInUser = Auth::user();
		//loggedIn user name
		$loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.error.notification' ,[
			'type'    				=> 'receiver-error',
			'userUid' 				=> $user->_uid,
			'subject' 				=> __tr('Receiver Errors'),
            'receiverName'          => $loggedInUserName,
			'message' 				=> __tr('Disconnect Call.'),
			'messageType' 			=> __tr('errors')
		]);
		return $this->engineReaction(1, null);
	}
	
	/**
      * Prepare receiver call busy errors
      * 
      * @param number $callerUserUid
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareReceiverCallBusy($callerUserUid)
    {
		//get user details
		$user = $this->userRepository->fetch($callerUserUid);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
		}
		$loggedInUser = Auth::user();
		//loggedIn user name
		$loggedInUserName = $loggedInUser->first_name.' '.$loggedInUser->last_name;
		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.error.notification' ,[
			'type'    				=> 'receiver-busy',
			'userUid' 				=> $user->_uid,
			'subject' 				=> __tr('Receiver Errors'),
            'receiverName'          => $loggedInUserName,
			'message' 				=> __tr('Disconnect Call.'),
			'messageType' 			=> __tr('errors')
		]);
		return $this->engineReaction(1, null);
	}
	
		/**
      * Prepare receiver call accept
      * 
      * @param number $receiverUserUid
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareReceiverCallAccept($receiverUserUid)
    {
		//get user details
		$user = $this->userRepository->fetch($receiverUserUid);
        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
		}
		
		//loggedIn user name
		$loggedInUserName = $user->first_name.' '.$user->last_name;
		//push data to pusher
		PushBroadcast::notifyViaPusher('event.call.accept.notification' ,[
			'type'    				=> 'receiver-accept-call',
			'userUid' 				=> $user->_uid,
			'subject' 				=> __tr('Receiver Accept Call'),
            'receiverName'          => $loggedInUserName,
			'message' 				=> __tr('Call Already Connected.'),
			'messageType' 			=> __tr('errors')
		]);
		return $this->engineReaction(1, null);
    }
    
    /**
      * Prepare Messenger Log
      * 
      * @return  void
      *-----------------------------------------------------------------------*/
    public function prepareMessengerLog()
    {
        $messengerLogCollection = $this->messengerRepository->fetchMessengerLogData();
		
        $requireColumns = [
            '_id',
            '_uid',
            'type',
            'message' => function($chatData) {
                if ($chatData['type'] == 2) {
                    $messengerFolderPath = getPathByKey('messenger_file', ['{_uid}' => $chatData['_uid']]);
                    return getMediaUrl($messengerFolderPath, $chatData['message']);
                }
                return $chatData['message'];
            },
            'sender_profile_image' => function($chatData) {
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $chatData['message_from_user_uid']]);
                if (!\__isEmpty($chatData['message_from_user_profile_picture'])) {
                    return getMediaUrl($profilePictureFolderPath, $chatData['message_from_user_profile_picture']);
                }
                return noThumbImageURL();
            },
            'sender' => function($chatData) {
                return $chatData['message_from_first_name'].' '.$chatData['message_from_last_name'];
            },
            'receiver_profile_image' => function($chatData) {
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $chatData['message_to_user_uid']]);
                if (!\__isEmpty($chatData['message_to_user_profile_picture'])) {
                    return getMediaUrl($profilePictureFolderPath, $chatData['message_to_user_profile_picture']);
                }
                return noThumbImageURL();
            },
            'receiver' => function($chatData) {
                return $chatData['message_to_first_name'].' '.$chatData['message_to_last_name'];
            },
            'send_on' => function($chatData) {
                return $this->formatDateTimeForMessage($chatData['created_at']);
            }
        ];

        return $this->dataTableResponse($messengerLogCollection, $requireColumns);
    }
}