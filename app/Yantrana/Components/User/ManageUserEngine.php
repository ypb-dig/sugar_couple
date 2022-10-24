<?php

/*
* ManageUserEngine.php - Main component file
*
* This file is part of the User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\User\Repositories\{ManageUserRepository, CreditWalletRepository};
use App\Yantrana\Support\Country\Repositories\CountryRepository;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Yantrana\Support\CommonTrait;
use App\Yantrana\Components\Media\MediaEngine;
use App\Yantrana\Base\BaseMailer;
use \Illuminate\Support\Facades\URL;


class ManageUserEngine extends BaseEngine 
{   
	/**
	* @var CommonTrait - Common Trait
	*/
    use CommonTrait;

    /**
     * @var  ManageUserRepository $manageUserRepository - ManageUser Repository
     */
    protected $manageUserRepository;

    /**
     * @var  CountryRepository $countryRepository - Country Repository
     */
    protected $countryRepository;
    
    /**
     * @var  Faker $faker - Faker
     */
	protected $faker;
    
    /**
     * @var BaseMailer - Base Mailer
     */
    protected $baseMailer;

	 /**
     * @var  CreditWalletRepository $creditWalletRepository - CreditWallet Repository
     */
	protected $creditWalletRepository;

    /**
     * @var  MediaEngine $mediaEngine - MediaEngine
     */
    protected $mediaEngine;

    /**
      * Constructor
      *
      * @param  ManageUserRepository $manageUserRepository - ManageUser Repository
      * @param  CountryRepository $countryRepository - Country Repository
	  * @param  Faker $faker - Faker
	  * @param  MediaEngine $mediaEngine - MediaEngine
      * @param  CreditWalletRepository $creditWalletRepository - CreditWallet Repository
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(ManageUserRepository $manageUserRepository, CountryRepository $countryRepository, Faker $faker, CreditWalletRepository $creditWalletRepository, MediaEngine $mediaEngine, BaseMailer  $baseMailer)
    {
        $this->baseMailer               = $baseMailer;
        $this->manageUserRepository 	= $manageUserRepository;
        $this->countryRepository 		= $countryRepository;
		$this->faker 					= $faker;
		$this->creditWalletRepository 	= $creditWalletRepository;
        $this->mediaEngine 				= $mediaEngine;
    }


    /**
     * Re-send activation email.
     *
     * @param int $status
     *
     *---------------------------------------------------------------- */
    public function resendActivationEmail($uid)
    {

        $transactionResponse = $this->manageUserRepository->processTransaction(function() use ($uid){

            $user = $this->manageUserRepository->fetchUser($uid);

            $emailData = [
                'fullName' => $user->first_name,
                'email' => $user->email,
                'expirationTime' => configItem('account.expiry'),
                'activation_url' => URL::temporarySignedRoute('user.account.activation', Carbon::now()->addHours(configItem('account.expiry')), ['userUid' => $user->_uid])
            ];
            // check if email send to member
            if ($this->baseMailer->notifyToUser(__tr('Your account created successfully, to activate your account please check your email.'), 'account.activation', $emailData, $user->email)) {
                return $this->manageUserRepository->transactionResponse(1, ['show_message' => true], __tr('Email de ativação reenviado com sucesso.'));
            }

            return $this->manageUserRepository->transactionResponse(2, ['show_message' => true], __tr('Erro ao tentar reenviar email de ativação.'));
        });
        
        return $this->engineReaction($transactionResponse);

    }


    /**
     * Prepare User Data table list.
     *
     * @param int $status
     *
     *---------------------------------------------------------------- */
    public function prepareUsersDataTableList($status)
    {
       	$userCollection = $this->manageUserRepository->fetchUsersDataTableSource($status);

       	$requireColumns = [
			'_id',
			'_uid',
			'first_name',
			'last_name',
			'full_name',
			'created_at' => function($key) {
			    return formatDate($key['created_at'], 'd/m/Y ');
			},
			'status',
			'email',
			'username',
			'is_fake',
			'is_verified' => function($key) {

				if (isset($key['is_verified']) and $key['is_verified'] == 1) {
					return true;
				}
				return false;
			},
			'profile_picture' => function($key) {

				if (isset($key['profile_picture']) and !__isEmpty($key['profile_picture'])) {
					$imagePath = getPathByKey('profile_photo', [ '{_uid}' => $key['_uid'] ]);
					return getMediaUrl($imagePath, $key['profile_picture']);
				}

				return noThumbImageURL();
			},
			'profile_url' => function($key) {
			    return route('user.profile_view', ['username' => $key['username'] ]);
			},
            'gender' => function($key){
                $gender = isset($key['gender']) ? configItem('user_settings.gender', $key['gender']) : null;
                return $gender;

            },
            'looking_for' => function($key){
                $gender = isset($key['looking_for']) ? configItem('user_settings.gender', $key['looking_for']) : null;
                return $gender;

            },
			'user_roles__id'
        ];

        return $this->dataTableResponse($userCollection, $requireColumns);
    }

    /**
     * Prepare User photos Data table list.
     *
     * @param int $status
     *
     *---------------------------------------------------------------- */
    public function userPhotosDataTableList()
    {
       	$userCollection = $this->manageUserRepository->fetchUserPhotos();

       	$requireColumns = [
			'_id',
			'_uid',
			'first_name',
			'last_name',
			'full_name',
			'profile_image' => function($key) {

				if (isset($key['image_name'])) {
					$path = getPathByKey('user_photos', [ '{_uid}' => $key['_uid'] ]);
					return getMediaUrl($path, $key['image_name']);
				} else if (isset($key['profile_picture'])) {
					$path = getPathByKey('profile_photo', [ '{_uid}' => $key['_uid'] ]);
					return getMediaUrl($path, $key['profile_picture']);
				} else if (isset($key['cover_picture'])) {
					$path = getPathByKey('cover_photo', [ '{_uid}' => $key['_uid'] ]);
					return getMediaUrl($path, $key['cover_picture']);
				}

				return null;
			},
			'updated_at' => function($key) {
				return formatDate($key['updated_at'], "l jS F Y g:i A");
			},
			'type' => function($key) {
				if (isset($key['image_name'])) {
					return 'photo';
				} else if (isset($key['profile_picture'])) {
					return 'profile';
				} else if (isset($key['cover_picture'])) {
					return 'cover';
				}
				return null;
			},
			'profile_url' => function($key) {
			    return route('user.profile_view', ['username' => $key['username'] ]);
			},
			"deleteImageUrl" => function($key) {

				if (isset($key['image_name'])) {
					return route('manage.user.write.photo_delete', [
						'userUid' => $key['_uid'],
						'type' => 'photo',
						'profileOrPhotoUid' => $key['user_photo_id']
					]);
				} else if (isset($key['profile_picture'])) {
					return route('manage.user.write.photo_delete', [
						'userUid' => $key['_uid'],
						'type' => 'profile',
						'profileOrPhotoUid' => $key['user_profile_id']
					]);
				} else if (isset($key['cover_picture'])) {
					return route('manage.user.write.photo_delete', [
						'userUid' => $key['_uid'],
						'type' => 'cover',
						'profileOrPhotoUid' => $key['user_profile_id']
					]);
				} 
			}
        ];

        return $this->dataTableResponse($userCollection, $requireColumns);
    }

    /**
     * Prepare User List.
     *
     * @param int $status
     *
     *---------------------------------------------------------------- */
    public function prepareUserList($status)
    {
        $userCollection = $this->manageUserRepository->fetchList($status);
        $userData = [];
        // check if user collection exists
        if (!__isEmpty($userCollection)) {
            foreach($userCollection as $user) {
                $userData[] = [
                    'uid'   => $user->_uid,
                    'full_name' => $user->first_name.' '.$user->last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'created_on' => formatDate($user->created_at, 'd/m/Y '),
                ];
            }
        }
        return $this->engineReaction(1, [
            'userData' => $userData
        ]);
    }

    /**
     * Prepare User List.
     *
     * @param array $inputData
     *
     *---------------------------------------------------------------- */
    public function processAddUser($inputData)
    {

        $inputData['status'] = 1; // Always active

        $transactionResponse = $this->manageUserRepository->processTransaction(function() use($inputData) {
            // Store user
            $newUser = $this->manageUserRepository->storeUser($inputData);
            // Check if user not stored successfully
            if (!$newUser) {
                return $this->manageUserRepository->transactionResponse(2, ['show_message' => true], __tr('User not added.'));
            }
            $userAuthorityData = [
                'user_id' => $newUser->_id,
                'user_roles__id' => 2
            ];

            if($inputData['permission']){
              $userAuthorityData['user_roles__id'] = $inputData['permission'];
            }

            // Add user authority
            if ($this->manageUserRepository->storeUserAuthority($userAuthorityData)) {                
                return $this->manageUserRepository->transactionResponse(1, ['show_message' => true], __tr('User added successfully.'));
            }
            // Send failed server error message
            return $this->manageUserRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server.'));
        });
        
        return $this->engineReaction($transactionResponse);
    }

    /**
     * Prepare User edit data.
     *
     * @param array $userUid
     *
     *---------------------------------------------------------------- */
    public function prepareUserEditData($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        $userData = [
            'uid'               => $userDetails->_uid,
            'first_name'        => $userDetails->first_name,
            'last_name'         => $userDetails->last_name,
            'email'             => $userDetails->email,
            'username'          => $userDetails->username,
            'password'          => $userDetails->password,
            'confirm_password'  => $userDetails->confirm_password,
            'designation'       => $userDetails->designation,
            'mobile_number'     => $userDetails->mobile_number,
            'status'            => $userDetails->status
        ];

        return $this->engineReaction(1, [
            'userData' => $userData
        ]);
    }

    /**
     * Process User Update.
     *
     * @param string $userUid
     * @param array $inputData
     *
     *---------------------------------------------------------------- */
    public function processUserUpdate($userUid, $inputData) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        // Prepare Update User data
        $updateData = [
            'first_name'        => $inputData['first_name'],
            'last_name'         => $inputData['last_name'],
            'email'             => $inputData['email'],
            'username'          => $inputData['username'],
            'designation'       => array_get($inputData, 'designation'),
            'mobile_number'     => $inputData['mobile_number'],
            'status'            => array_get($inputData, 'status', 2)
        ];
        
        if(array_get($inputData, 'credits', false)){// GIve user credits
            $this->creditWalletRepository->addCredits(array_get($inputData, 'credits', 0), $userDetails->_id);
        }

        // check if user updated 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
            // Adding activity log for update user
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user info updated.');
            return $this->engineReaction(1, ['show_message' => true], __tr('User updated successfully.'));
        }

        if(array_get($inputData, 'credits', false)){
            return $this->engineReaction(1, ['show_message' => true], __tr('Creditos adicionados com sucesso.'));
        }

        return $this->engineReaction(14, ['show_message' => true], __tr('Nothing updated.'));
    }

    /**
     * Process Soft Delete User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processSoftDeleteUser($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        // Prepare Update User data
        $updateData = [
            'status' => 5
        ];
        
        // check if user soft deleted 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
            // Add activity log for user soft deleted
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user soft deleted.');
            return $this->engineReaction(1, ['userUid' => $userDetails->_uid, 'show_message' => true], __tr('User soft deleted successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }

    /**
     * Process Soft Delete User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processPermanentDeleteUser($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        // // check if user soft deleted first
        // if ($userDetails->status != 5) {
        //     return $this->engineReaction(2, ['show_message' => true], __tr('To delete user permanently you have to soft delete first.'));
        // }
        // check if user deleted 
        if ($this->manageUserRepository->deleteUser($userDetails)) {
            // Add activity log for user permanent deleted
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user permanent deleted.');
            return $this->engineReaction(1, ['userUid' => $userDetails->_uid, 'show_message' => true], __tr('User permanent deleted successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }

    /**
     * Process Restore User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processUserRestore($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        // Prepare Update User data
        $updateData = [
            'status' => 1
        ];
        
        // check if restore deleted 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
            // Add activity log for user restored
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user restored.');
            return $this->engineReaction(1, ['userUid' => $userDetails->_uid, 'show_message' => true], __tr('User restore successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }

    /**
     * Process Block User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processBlockUser($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        // Prepare Update User data
        $updateData = [
            'status' => 3 // Blocked
        ];
        
        // check if user blocked 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
            // Add activity log for user blocked
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user blocked.');
            return $this->engineReaction(1, ['userUid' => $userDetails->_uid, 'show_message' => true], __tr('User blocked successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }

    /**
     * Process Unblock User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processUnblockUser($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        // Prepare Update User data
        $updateData = [
            'status' => 1 // Active
        ];
        
        // check if user soft deleted 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
            // Add activity log for user unblocked
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user unblocked.');
            return $this->engineReaction(1, ['userUid' => $userDetails->_uid, 'show_message' => true], __tr('User unblocked successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }

    /**
     * Prepare User edit data.
     *
     * @param array $userUid
     *
     *---------------------------------------------------------------- */
    public function prepareUserDetails($userUid) 
    {
        $user = $this->manageUserRepository->fetchUser($userUid);
        // check if user details exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        $userDetails = [
            'full_name'         => $user->first_name.' '.$user->last_name,
            'email'             => $user->email,
            'username'          => $user->username,
            'designation'       => $user->designation,
            'mobile_number'     => $user->mobile_number
        ];

        return $this->engineReaction(1, [
            'userDetails' => $userDetails
        ]);
    }

    /**
     * prepare Fake User Generator Options.
     *
     *---------------------------------------------------------------- */
    public function prepareFakeUserOptions() 
    {
    	//user options
    	$userSettings = configItem('user_settings');
    	$fakerGeneratorOptions = configItem('fake_data_generator');

    	//countries
    	$countries = $this->countryRepository->fetchAll();
    	$countryIds = $countries->pluck('id')->toArray();

        return $this->engineReaction(1, [
        	'gender' => array_merge(['random' => "Random"], $userSettings['gender']),
        	'languages' =>  array_merge(['random' => "Random"], $userSettings['preferred_language']),
        	'default_password' => $fakerGeneratorOptions['default_password'],
        	'recordsLimit' => $fakerGeneratorOptions['records_limits'],
        	'countries' => array_merge(array(['id' => 'random', 'name' => "Random"]), $countries->toArray()),
        	'randomData' => [
        		'country' => array_rand($countryIds),
        		'gender'  => array_rand(($userSettings['gender'])),
        		'language'  => array_rand(($userSettings['preferred_language']))
        	],
        	'ageRestriction' => configItem('age_restriction')
        ]);
    }

    /**
     * prepare Fake User Generator Options.
     *
     *---------------------------------------------------------------- */
    public function processGenerateFakeUser($options) 
    {
    	$transactionResponse = $this->manageUserRepository->processTransaction(function() use($options) {

    		$countries = $this->countryRepository->fetchAll()->pluck('id')->toArray();

    		//for page number
    		if (__isEmpty(session('fake_user_api_page_no')) or (session('fake_user_api_page_no') >= 9)) {
    			session(['fake_user_api_page_no' => 1]);
    		} else {
    			$page = session('fake_user_api_page_no');
    			session(['fake_user_api_page_no' => $page + 1 ]);
    		}

		 	$page = session('fake_user_api_page_no');

    		//get All photo ids
    		$photoIds = collect(getPhotosFromAPI($page))->pluck('id')->toArray();
    		//user options
    		$userSettings = configItem('user_settings');

    		$specificationConfig = $this->getUserSpecificationConfig();

    		$usersAdded = $authoritiesAdded = $profilesAdded = $creditWallets = $specsAdded = false;
    		$users = [];
    		$creditWalletStoreData = [];

    		//for users
    		for ($i = 0; $i < $options['number_of_users']; $i++) {
    			//random timezone
    			$timezone =  $this->faker->timezone;
				$createdDate = Carbon::now()->addMinutes($i + 1);

    			$users[] = 	[
			        'first_name' 	=> $this->faker->firstname,
			        'last_name' 	=> $this->faker->lastname,
			        'email' 		=> $this->faker->unique()->safeEmail,
			        'username' 		=> $this->faker->unique()->userName,
			        'created_at' 	=> $createdDate,
			        'updated_at' 	=> $createdDate,
			        'password' 		=> bcrypt($options['default_password']),
			        'status' 		=> 1,
			        'mobile_number' => $this->faker->e164PhoneNumber,
			        'timezone' 		=> $timezone,
			        'is_fake' 		=> 1
				];
				unset($createdDate);
    		}
			
            // Store users
            $addedUsersIds = $this->manageUserRepository->storeMultipleUsers($users);

            //check if users added
            if ($addedUsersIds) {
            	$usersAdded = true;
            	$authorities = $profiles = $specifications = [];
				// for authority
				foreach ($addedUsersIds as $key => $addedUserID) {
					$createdDate = Carbon::now()->addMinutes($key + 1);
					//authorities
					$authorities[] = [
				    	'created_at' => $createdDate,
				        'updated_at' => $createdDate,
				        'status' => 1,
				        'users__id' => $addedUserID,
				        'user_roles__id' => 2,
				    ];

				    //random age
				    $age = rand($options['age_from'], $options['age_to']);
					
				    $country = $options['country'];
				    
		    		//check if coutry is random or not set
		    		if ($options['country'] == 'random' or __isEmpty($options['country'])) {
		    			$randomKey = array_rand($countries);
		    			$country = $countries[$randomKey];
		    		}

		    		//check if gender is random or not set
		    		$gender = $options['gender'];
		    		if ($options['gender'] == 'random' or __isEmpty($options['gender'])) {
		    			$gender = array_rand($userSettings['gender']);
		    		}

		    		//check if language is random or not set
		    		$language = $options['language'];
		    		if ($options['language'] == 'random' or __isEmpty($options['language'])) {
		    			$language = array_rand($userSettings['preferred_language']);
		    		}

				    //for profiles
				    $profiles[] = [
				    	'created_at' 		=> $createdDate,
				        'updated_at' 		=> $createdDate,
				        'users__id' 		=> $addedUserID,
				        'countries__id' 	=> $country,
				        'gender' 			=> $gender,
				        'profile_picture' 	=> strtr("https://i.picsum.photos/id/__imageID__/360/360.jpg", ['__imageID__' => array_rand($photoIds) ]),
				        'cover_picture' 	=> strtr("https://i.picsum.photos/id/__imageID__/820/360.jpg", ['__imageID__' => array_rand($photoIds) ]),
				        'dob' 				=> Carbon::now()->subYears($age)->format('Y-m-d'),
				        'city' 				=> $this->faker->city,
				        'about_me'			=> $this->faker->text(rand(50, 500)),
				        'work_status'		=> array_rand($userSettings['work_status']),
				        'education' 		=> array_rand($userSettings['educations']),
				        'is_verified' 		=> rand(0, 1),
				        'location_latitude' 	=> $this->faker->latitude,
				        'location_longitude' 	=> $this->faker->longitude,
				        'preferred_language' 	=> $language,
				        'relationship_status' 	=> array_rand($userSettings['relationship_status'])
				    ];
					unset($createdDate);
				    //check enable bonus credits for new user
					if (getStoreSettings('enable_bonus_credits')) {
						$creditWalletStoreData[] = [
							'status' 	=> 1,
							'users__id' => $addedUserID,
							'credits' 	=> getStoreSettings('number_of_credits'),
							'credit_type' => 1 //Bonuses
						];
					}

		    		if (!__isEmpty($specificationConfig['groups'])) {
						foreach ($specificationConfig['groups'] as $key => $group) {
							if (in_array($key, ["looks", "personality", "lifestyle"])) {
								if (!__isEmpty($group['items'])) {
									foreach ($group['items'] as $key2 => $item) {
										$specifications[] = [
											'type'                  => 1,
											'status'                => 1,
											'specification_key'     => $key2,
											'specification_value'   => array_rand($item['options']),
											'users__id'             => $addedUserID
										];
									}
								}
							}
						}
		    		}
				}
				
				//check if authorities added
    			if ($this->manageUserRepository->storeUserAuthorities($authorities)) {
    				$authoritiesAdded = true;
    			}

    			//check if profiles added
    			if ($this->manageUserRepository->storeUserProfiles($profiles)) {
    				$profilesAdded = true;
    			}

    			//check if profiles added
    			if (!__isEmpty($specifications)) {
					$this->manageUserRepository->storeUserSpecifications($specifications);
				}

    			if (!__isEmpty($creditWalletStoreData)) {
	    			//store user credit transaction data
					$this->manageUserRepository->storeCreditWalletTransactions($creditWalletStoreData);
    			}
            }

            //if all data inserted
            if ($usersAdded and $authoritiesAdded and $profilesAdded) {
            	return $this->manageUserRepository->transactionResponse(1, ['show_message' => true], __tr('Fake users added successfully.'));
            }
           
            // // Send failed server error message
            return $this->manageUserRepository->transactionResponse(2, ['show_message' => true], __tr('Fake users not added.'));

        });
        
        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process Block User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processVerifyUserProfile($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);

        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        $profileAddedAndVerified = $profileVerified = false;

        $profile = $this->manageUserRepository->fetchUserProfile($userDetails->_id);

        // check if profile is empty , if true then create profile
        if (__isEmpty($profile)) {
        	if ($this->manageUserRepository->storeUserProfile([ "users__id" => $userDetails->_id, 'is_verified' => 1 ])) {
        		$profileAddedAndVerified = true;
        	}
        } else {
        	if ($this->manageUserRepository->updateUserProfile($profile, [ 'is_verified' => 1 ])) {
        		$profileVerified = true;
        	}
        }

        // check if user added and verified  
        if ($profileAddedAndVerified or $profileVerified) {
            // Add activity log for user blocked
            activityLog($userDetails->first_name.' '.$userDetails->last_name.' user verified.');
            return $this->engineReaction(1, ['userUid' => $userDetails->_uid], __tr('User verified successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
	}

     /**
     * Process Aproval User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processApprovalUserProfile($userUid) 
    {
        $userDetails = $this->manageUserRepository->fetchUser($userUid);

        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        // Prepare Update User data
        $updateData = [
            'status' => 1 // Active
        ];
        
        // check if user soft deleted 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
           // Add activity log for user blocked
            activityLog('Cadastro do usuário ' . $userDetails->first_name.' '.$userDetails->last_name.' aprovado.');

            $emailData = [
                'fullName' => $userDetails->first_name,
                'email' => $userDetails->email
            ];

            // check if email send to member
            if ($this->baseMailer->notifyToUser('Sua conta foi aprovada com sucesso.', 'account.approved', $emailData, $userDetails->email)) {
            }


            return $this->engineReaction(1, ['show_message' => true, 'userUid' => $userDetails->_uid], __tr('Cadastro aprovado.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }
	
     /**
     * Process Reject User.
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processRejectUserProfile($userUid) 
    { $userDetails = $this->manageUserRepository->fetchUser($userUid);

        // check if user details exists
        if (__isEmpty($userDetails)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }
        
        // Prepare Update User data
        $updateData = [
            'status' => 8 // Active
        ];
        
        // check if user soft deleted 
        if ($this->manageUserRepository->updateUser($userDetails, $updateData)) {
            // Add activity log for user blocked
            activityLog('Cadastro do usuário ' . $userDetails->first_name.' '.$userDetails->last_name.' rejeitado.');

            $emailData = [
                'fullName' => $userDetails->first_name,
                'email' => $userDetails->email
            ];

            // check if email send to member
            if ($this->baseMailer->notifyToUser('Sua conta não foi aprovada.', 'account.rejected', $emailData, $userDetails->email)) {
            }

            return $this->engineReaction(1, ['show_message' => true, 'userUid' => $userDetails->_uid], __tr('Cadastro rejeitado.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }
	/**
     * get manage  user transaction list data.
     *
     * @param $userUid
     * @return object
     *---------------------------------------------------------------- */
    public function getUserTransactionList($userUid)
    {	
		$user = $this->manageUserRepository->fetchUser($userUid);
		//if user not exist
		if(__isEmpty($user)) {
			return $this->engineReaction(2, null, __tr('User does not exist.'));
		}

		$transactionCollection = $this->creditWalletRepository->fetchUserTransactionListData($user->_id);
		
        $requireColumns = [
            '_id',
            '_uid',
            'created_at' => function($key) {
                return formatDate($key['created_at'], 'd/m/Y ');
            },
            'updated_at' => function($key) {
                return formatDate($key['updated_at'], 'd/m/Y ');
            },
            'status',
			'formattedStatus' => function($key) {
                return configItem('payments.status_codes', $key['status']);
			},
			'amount',
			'formattedAmount' => function($key) {
                return priceFormat($key['amount'], true, true);
			},
			'method',
			'currency_code',
			'is_test',
			'formattedIsTestMode' => function($key) {
                return configItem('payments.payment_checkout_modes', $key['is_test']);
			},
			'credit_type',
			'formattedCreditType' => function($key) {
                return configItem('payments.credit_type', $key['credit_type']);
			},
			'__data',
			'packageName' => function($key) {
				//check is not Empty
				if (!__isEmpty($key['__data']) and !__isEmpty($key['__data']['packageName'])) {
					return $key['__data']['packageName'];
				}
				return 'N/A';
			}
        ];

        return $this->dataTableResponse($transactionCollection, $requireColumns);
	}

    /**
     * Delete photo, cover or profile of user .
     *
     * @param string $userUid
     *
     *---------------------------------------------------------------- */
    public function processUserPhotoDelete($userUid, $type, $profileOrPhotoUid) 
    {
    	$transactionResponse = $this->manageUserRepository->processTransaction(function() use($userUid, $type, $profileOrPhotoUid) {

	        $userDetails = $this->manageUserRepository->fetchUser($userUid);

	        // check if user details exists
	        if (__isEmpty($userDetails)) {
	            return $this->manageUserRepository->transactionResponse(18, null, __tr('User does not exists.'));
	        }

	        //if type is photo
	        if ($type == 'photo') {

	        	$userPhoto = $this->manageUserRepository->getUsersPhoto($userDetails->_id, $profileOrPhotoUid);
	        	$imagePath = getPathByKey('user_photos', [ '{_uid}' => $userDetails->_uid ]);

	        	//if deleted 
	        	if ($this->manageUserRepository->deleteUserPhoto($userPhoto)) {
	        		$this->mediaEngine->processDeleteFile($imagePath, $userPhoto->file);
	        		return $this->manageUserRepository->transactionResponse(1,['show_message' => true], __tr('Photo removed successfully.'));
	        	}

	        } else if ($type == 'profile') {

	        	$profile = $this->manageUserRepository->fetchUserProfile($userDetails->_id);

	        	//if deleted 
	        	if ($this->manageUserRepository->updateUserProfile($profile, ['profile_picture' => null])) {

	        		//check if url
	        		if (!isImageUrl($profile->profile_picture)) {
	        			$imagePath = getPathByKey('profile_photo', [ '{_uid}' => $userDetails->_uid ]);
	        			$this->mediaEngine->processDeleteFile($imagePath, $profile->profile_picture);
	        		}
	        		// Add activity log for user soft deleted
	            	activityLog($userDetails->first_name.' '.$userDetails->last_name.' user profile photo deleted.');

	            	return $this->manageUserRepository->transactionResponse(1,['show_message' => true], __tr('Photo removed successfully.'));
	        	}

	        } else if ($type == 'cover') {
	        	$profile = $this->manageUserRepository->fetchUserProfile($userDetails->_id);

	        	//if deleted 
	        	if ($this->manageUserRepository->updateUserProfile($profile, ['cover_picture' => null])) {

	        		//check if url
	        		if (!isImageUrl($profile->profile_picture)) {

	        			$imagePath = getPathByKey('cover_photo', [ '{_uid}' => $userDetails->_uid ]);

	        			$this->mediaEngine->processDeleteFile($imagePath, $profile->cover_picture);
	        		}
	        		// Add activity log for user soft deleted
	            	activityLog($userDetails->first_name.' '.$userDetails->last_name.' user cover photo soft deleted.');

	            	return $this->manageUserRepository->transactionResponse(1,['show_message' => true], __tr('Photo removed successfully.'));
	        	}
	        }

	        return $this->manageUserRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server.'));
        });

        return $this->engineReaction($transactionResponse);

    }
}