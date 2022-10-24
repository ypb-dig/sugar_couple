<?php
/*
* FilterEngine.php - Main component file
*
* This file is part of the Filter component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Filter;

use Carbon\Carbon;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\UserSetting\Repositories\UserSettingRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;
use App\Yantrana\Support\CommonTrait;
use App\Yantrana\Components\UserSetting\UserSettingEngine;
use App\Yantrana\Components\Filter\Interfaces\FilterEngineInterface;
use Request;

class FilterEngine extends BaseEngine implements FilterEngineInterface 
{
    /**
     * @var  UserSettingRepository $userSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;

     /**
     * @var CommonTrait - Common Trait
     */
    use CommonTrait;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;
    
    /**
     * @var  UserSettingEngine $userSettingEngine - UserSetting Engine
     */
    protected $userSettingEngine;

    /**
      * Constructor
      * @param  UserSettingRepository $userSettingRepository - UserSetting Repository
      * @return  void
      *-----------------------------------------------------------------------*/
    function __construct(
        UserSettingRepository $userSettingRepository,
        UserRepository $userRepository,
        UserSettingEngine $userSettingEngine
    )
    {
        $this->userSettingRepository = $userSettingRepository;
        $this->userRepository        = $userRepository;
        $this->userSettingEngine     = $userSettingEngine;
	}

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function prepareApiBasicFilterData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }
        
        $inputData = array_merge([
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
            'orderby' => getUserSettings('orderby'),

        ], $inputData);

        $inputData['looking_for'] = getAllowedGenders();


        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        if(isset($inputData["lng"]) && isset($inputData["lat"])){
            $current_lat = $inputData["lat"];
            $current_lng = $inputData["lng"];  
        }

        if(isset($current_lat)){
            $inputData['latitude'] = $current_lat;
            $inputData['longitude'] = $current_lng;
        } else {
            $inputData['latitude'] = $latitude;
            $inputData['longitude'] = $longitude;
        }


        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge($toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()])));
        
        // Get filter collection data
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount);
      
        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->first_name.' '.$filter->last_name,
                    'profileImage'  => $profilePictureUrl,
                    'gender'        => $gender,
                    'dob'           => $filter->dob,
                    'userAge'       => $userAge,
                    'countryName'   => $filter->countryName,
                    'city'          => $filter->city,
                    'neighborhood'  => $filter->neighborhood,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'     => isPremiumUser($filter->user_id),
                    'detailString'  => implode(", ", array_filter([$userAge, $gender]))
                ];
            }
        }
        
        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('api.user.find_matches.read.support_data');
 
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '?min_age='.getUserSettings('min_age');
        } 
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age='.getUserSettings('max_age');
        } 
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance='.getUserSettings('distance');
        }
        if (!str_contains($fullUrl, 'orderby')) {
            $fullUrl .= '&orderby='.getUserSettings('orderby');
        }
        if(isset($inputData['latitude']) && isset($inputData['longitude'])){
            $fullUrl .= '&lat=' . $inputData['latitude'] . '&lng='.$inputData['longitude'];
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        $distanceUnit = 'Miles';
        if (getStoreSettings('distance_measurement') == '6371') {
            $distanceUnit = 'KM';
        }

        $basicFilterData = [
            'looking_for'       => $inputData['looking_for'],
            'min_age'           => getUserSettings('min_age'),
            'max_age'           => getUserSettings('max_age'),
            'distance'          => getUserSettings('distance'),
            'genderList'        => configItem('user_settings.gender'),
            'minAgeList'        => configItem('user_settings.min_age'),
            'maxAgeList'        => configItem('user_settings.max_age'),
            'distanceUnit'      => $distanceUnit
        ];
        
        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl.'&page='.$currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total(),
            'basicFilterData'        => $basicFilterData
        ]);
    }

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function processFilterData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());
       
        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }
		
        $inputData = array_merge([
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
            'username_f' => getUserSettings('username_f'),
            'orderby' => getUserSettings('orderby'),

        ], $inputData);
       
        $gender = getUserGender();


        $inputData['looking_for'] = getAllowedGenders();

        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        if(isset($inputData["lng"]) && isset($inputData["lat"])){
            $current_lat = $inputData["lat"];
            $current_lng = $inputData["lng"];  
        }

        if(isset($current_lat)){
            $inputData['latitude'] = $current_lat;
            $inputData['longitude'] = $current_lng;
        } else {
            $inputData['latitude'] = $latitude;
            $inputData['longitude'] = $longitude;
        }

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = [];//$getLikeDislikeData->pluck('to_users__id')->toArray();
        // Users that should not be listed
        $noListUsers = getFilteredOutUsersIds();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
		$likedCollection = $this->userRepository->fetchUserLikeData(1, false);
		//pluck people like ids
		$peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
		//get people likes me data
		$userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
		//pluck people like me ids
		$mutualLikeIds = [];//$userLikedMeData->pluck('userId')->toArray();
		
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge($noListUsers, $toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()])));
        
        // Get filter collection data
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount);
      
        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
				$gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->first_name.' '.$filter->last_name,
                    'profileImage'  => $profilePictureUrl,
					'gender' 		=> $gender,
					'dob' 			=> $filter->dob,
					'userAge'		=> $userAge,
                    'countryName' 	=> $filter->countryName,
                    'city'          => $filter->city,
                    'neighborhood'  => $filter->neighborhood,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
					'isPremiumUser'		=> isPremiumUser($filter->user_id),
					'detailString'	=> implode(", ", array_filter([$userAge, $gender]))
                ];
            }
		}
		
        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.find_matches');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '?min_age='.getUserSettings('min_age');
        } 
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age='.getUserSettings('max_age');
        } 
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance='.getUserSettings('distance');
        }
        if (!str_contains($fullUrl, 'username_f')) {
            $fullUrl .= '&username_f='.getUserSettings('username_f');
        }
        if(isset($inputData['latitude']) && isset($inputData['longitude'])){
            $fullUrl .= '&lat=' . $inputData['latitude'] . '&lng='.$inputData['longitude'];
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }
		
        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl.'&page='.$currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function prepareRandomUserData($inputData)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());
      
        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $gender = getUserGender();
        $inputData = array_merge([
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
            'username_f' => getUserSettings('username_f'),

        ], $inputData);
        
        $inputData['looking_for'] = getAllowedGenders();

        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // Users that should not be listed
        $noListUsers = getFilteredOutUsersIds();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
		$likedCollection = $this->userRepository->fetchUserLikeData(1, false);
		//pluck people like ids
		$peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
		//get people likes me data
		$userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
		//pluck people like me ids
		$mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
		
        //array merge of unique users ids
		$ignoreUserIds = array_values(array_unique(array_merge($noListUsers, $toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()])));

		//fetch filter booster user data
		$boosterUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignoreUserIds, 'boosterUser');
	
		//pluck booster user ids
		$boosterUserIds = $boosterUser->pluck('user_id')->toArray();
			
		$totalRandomUser = getStoreSettings('booster_user_count') + getStoreSettings('premium_user_count') + getStoreSettings('normal_user_count');
		$randomBoosterUserCount = getStoreSettings('booster_user_count');
		
		//check is not empty and booster user length greater than or equal to 4 
		//then fetch 4 booster random user
		if (!__isEmpty($boosterUser) and $randomBoosterUserCount > 0 and $boosterUser->count() >= $randomBoosterUserCount) {
			$randomBoosterUser = $boosterUser->random($randomBoosterUserCount)->toArray();
			$totalRandomUser = $totalRandomUser - count($randomBoosterUser);
		
		//check is not empty and booster user length less than 4 
		//then total booster length count record
		} else if (!__isEmpty($boosterUser) and $randomBoosterUserCount > 0 and $boosterUser->count() < $randomBoosterUserCount) {
			$randomBoosterUser = $boosterUser->random($boosterUser->count())->toArray();
			$totalRandomUser = $totalRandomUser - count($randomBoosterUser);
		
		//if it is empty booster user then pass on blank array or total fetch user count
		} else {
			$randomBoosterUser = [];
			$totalRandomUser = $totalRandomUser - 0;
		}
	
		//array merge of unique users ids / or ignore booster filter user ids
		$ignoreBoosterUserIds = array_values(array_unique(array_merge($ignoreUserIds, $boosterUserIds)));

		//fetch filter premium user data
		$premiumUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignoreBoosterUserIds, 'premiumUser');
		
		//pluck premium user ids
		$premiumUserIds = $premiumUser->pluck('user_id')->toArray();
		
		$randomPremiumUserCount = getStoreSettings('premium_user_count');
		//check is not empty and premium user length greater than or equal to 4 
		//then fetch 4 premium random user
		if (!__isEmpty($premiumUser) and $randomPremiumUserCount > 0 and $premiumUser->count() >= $randomPremiumUserCount) {
			$randomPremiumUser = $premiumUser->random($randomPremiumUserCount)->toArray();
			$totalRandomUser = $totalRandomUser - count($randomPremiumUser);
		
		//check is not empty and premium user length less than 4 
		//then total premium length count record
		} else if (!__isEmpty($premiumUser) and $randomPremiumUserCount > 0 and $premiumUser->count() < $randomPremiumUserCount) {
			$randomPremiumUser = $premiumUser->random($premiumUser->count())->toArray();
			$totalRandomUser = $totalRandomUser - count($randomPremiumUser);
			
		//if it is empty booster user then pass on blank array or total fetch user count
		} else {
			$randomPremiumUser = [];
			$totalRandomUser = $totalRandomUser - 0;
		}
		
		//array merge of unique users ids / or ignore booster Premium filter user ids
		$ignorePremiumUserIds = array_values(array_unique(array_merge($ignoreUserIds, $ignoreBoosterUserIds, $premiumUserIds)));
		//fetch filter premium user data
		$normalUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignorePremiumUserIds, 'normalUser');
		
		//check is not empty then fetch total count random user
		if (!__isEmpty($normalUser) and $totalRandomUser > 0 and $normalUser->count() >= $totalRandomUser) {
			$randomNormalUser = $normalUser->random($totalRandomUser)->toArray();
		//check is not empty and normal user length less than 4 
		//then total normal length count record
		} else if (!__isEmpty($normalUser) and $totalRandomUser > 0 and $normalUser->count() < $totalRandomUser) {
			$randomNormalUser = $normalUser->random($normalUser->count())->toArray();
		//else fetch blank array
		} else {
			$randomNormalUser = [];
		}
		
		//get merge of fetch booster, premium and standard user data
		$filterDataCollection = array_merge($randomBoosterUser, $randomPremiumUser, $randomNormalUser);
		
        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {
				
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter['user_uid']]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter['profile_picture'])) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter['profile_picture']);
                    }
                }

                $userAge = isset($filter['dob']) ? Carbon::parse($filter['dob'])->age : null;
				$gender = isset($filter['gender']) ? configItem('user_settings.gender', $filter['gender']) : null;

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter['user_id'],
                    'username'      => $filter['username'],
                    'fullName'      => $filter['first_name'].' '.$filter['last_name'],
                    'profileImage'  => $profilePictureUrl,
					'gender' 		=> $gender,
					'dob' 			=> $filter['dob'],
					'userAge'		=> $userAge,
                    'countryName' 	=> $filter['countryName'],
                    'city'          => $filter['city'],
                    'neighborhood'  => $filter['neighborhood'],
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter['user_authority_updated_at']),
					'isPremiumUser'		=> isPremiumUser($filter['user_id']),
					'detailString'	=> implode(", ", array_filter([$userAge, $gender]))
                ];                
            }
        }

        return $this->engineReaction(1, [
            'filterData' => $filterData
        ]);
    }
}