<?php
/*
* PremiumPlanEngine.php - Main component file
*
* This file is part of the Premium Plan User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User;

use Carbon\Carbon;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\User\Repositories\{UserRepository};
use App\Yantrana\Components\UserSetting\Repositories\UserSettingRepository;
use Illuminate\Http\Request;

use App\Yantrana\Support\CommonTrait;
class PremiumPlanEngine extends BaseEngine 
{	
	/**
     * @var UserRepository - User Repository
     */
	protected $userRepository;

	 /**
     * @var CommonTrait - Common Trait
     */
	use CommonTrait;

	 /**
      * Constructor
      * @param UserRepository  $userRepository  - User Repository
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(UserRepository $userRepository, UserSettingRepository $userSettingRepository, Request $request)
    {
		$this->userRepository        	= $userRepository;
		$this->userSettingRepository    = $userSettingRepository;
		$this->request        			= $request;

	}

	/**
     * Prepare Buy Premium Plan User Data.
     *
     *
     *---------------------------------------------------------------- */
    public function preparePremiumPlanUserData()
    {
		$premiumPlanCollection = getStoreSettings('plan_duration');
		$premiumFeaturesCollection = getStoreSettings('feature_plans');
		$premiumPlans = $premiumPlanData = $premiumFeatureData = [];

        // check if user premium plan exists
        if (!__isEmpty($premiumPlanCollection)) {
			$premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
			$planDurationConfig = config('__settings.items.premium-plans');
			$defaultPlanDuration = $planDurationConfig['plan_duration']['default'];
			$premiumPlanData = combineArray($defaultPlanDuration, $premiumPlans);

			if ($this->request->session()->has('cupom') && $this->request->session()->has('discount_percentage'))
			{
				$plan = $this->request->session()->get('discount_plan');
				$discount_percentage = $this->request->session()->get('discount_percentage');

			    foreach($premiumPlanData as $key => $value){
			    	if(preg_match("/$plan$/", $key) || $key == $plan){
			    		if($discount_percentage == 100){
			    			$premiumPlanData[$key]['price'] = 0;
			    		} else {
				    		$discount_value = ($premiumPlanData[$key]['price'] / 100) * $discount_percentage;
				    		$premiumPlanData[$key]['price'] = $premiumPlanData[$key]['price'] - $discount_value;
				    	}
			    	}
			    }

				// echo '<pre>';
				// // var_dump($premiumPlanCollection);
				// var_dump($this->request->session()->has('cupom'));
				// var_dump($this->request->session()->has('discount_percentage'));
				// var_dump($premiumPlanData);
			}
		}

		// check if user premium features exists
		if (!__isEmpty($premiumFeaturesCollection)) {
			$premiumFeature = is_array($premiumFeaturesCollection) ? $premiumFeaturesCollection : json_decode($premiumFeaturesCollection, true);
			// Get settings from config
        	$featurePlanConfig = config('__settings.items.premium-feature');
			$defaultFeaturePlans = $featurePlanConfig['feature_plans']['default'];
			$premiumFeatureData = combineArray($defaultFeaturePlans, $premiumFeature);
		}

		$userSubscription = $this->userRepository->fetchUserSubscription();
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

		$userSubscriptionData = [];
		if (!__isEmpty($userSubscription) and !__isEmpty($premiumPlans) and !__isEmpty($premiumPlanData)) {
			$planData = $premiumPlanData[$userSubscription->plan_id];
			$expiryAt = isset($userSubscription->expiry_at) ? formatDate($userSubscription->expiry_at, 'd/m/Y H:m') : 'N/A';
			
			$userSubscriptionData = [
				"_id" => $userSubscription->_id,
				"_uid" => $userSubscription->_uid,
				"created_at" => formatDate($userSubscription->created_at, 'd/m/Y H:m'),
				"users__id" => $userSubscription->users__id,
				"expiry_at" => $expiryAt,
				"credit_wallet_transactions__id" => $userSubscription->credit_wallet_transactions__id,
				"debitedCredits" => $userSubscription->credits,
				"plan_id" => $userSubscription->plan_id,
				"planTitle" => $planData['title'],
				'planPrice' => $planData['price']
			];
		}
		
		return $this->engineReaction(1, [
            'premiumPlanData' => [
				'isPremiumUser' 		=> isPremiumUser(),
				'userSubscriptionData' 	=> $userSubscriptionData,
				'premiumPlans' 			=> $premiumPlanData,
				'premiumFeature' 		=> $premiumFeatureData,
			],
			'userProfile'				=> $userProfile,
        ]);
	}

	/**
     * Process buy user premium plan.
     *
     *-----------------------------------------------------------------------*/
    public function processBuyPremiumPlan($inputData)
    {	
		//buy premium plan request
		$buyPremiumPlanRequest = $this->userRepository->processTransaction(function() use ($inputData) {
			$premiumPlanCollection = getStoreSettings('plan_duration');
			//if user already a premium user then throw error
			if (isPremiumUser()) {
				return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Your are already buy premium plan.'));
			}
			
			// check if user premium plan exists
			if (!__isEmpty($inputData['select_plan'])) {
				var_dump($premiumPlanCollection);
				$premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
				$selectedPlan = $premiumPlans[$inputData['select_plan']];
				//check if plan exist
				if (!__isEmpty($selectedPlan)) {
					//fetch user credits data
					$totalUserCredits = totalUserCredits();
					
					//if premium plan credit price greater then total user credits then show error message
					if ($selectedPlan['price'] > $totalUserCredits) {
						return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Your credit ballance is too low, please purchase credits.'));
					}

					$expiryTime = null;
					$currentDateTime = Carbon::now();
					// get expiry time on current selected plan
					switch ($inputData['select_plan']) {
						case 'one_day':
							$expiryTime = $currentDateTime->add(1, 'day');
						break;
						case 'one_week':
							$expiryTime = $currentDateTime->add(7, 'day');
						break;
						case 'one_month':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'half_year':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'life_time':
							$expiryTime = $currentDateTime->addYears(100);
						break;
						// Gold SDD/SMM
						case 'gold_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'gold_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'gold_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'gold_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;
						// Plantium SDD/SMM
						case 'plantium_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'plantium_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'plantium_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'plantium_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;

						// Gold SBB
						case 'gold_baby_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'gold_baby_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'gold_baby_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'gold_baby_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;
						// Plantium SBB
						case 'plantium_baby_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'plantium_baby_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'plantium_baby_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'plantium_baby_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;							
					}

					//credit wallet store data
					$creditWalletStoreData = [
						'status' => 1,
						'users__id'=> getUserID(),
						'credits' => '-'.''.$selectedPlan['price']
					];

					//store credit wallet data and user subscription data
					if ($creditWalledId = $this->userRepository->storeCreditWalletTransaction($creditWalletStoreData)) {	
						//user subscription store data
						$storeSubscriptionData = [
							'status' => 1,
							'users__id' => getUserID(),
							'expiry_at' => $expiryTime,
							'plan_id'	=> $inputData['select_plan'],
							'credit_wallet_transactions__id' => $creditWalledId
						];
						//store user subscription data
						if ($this->userRepository->storeUserSubscription($storeSubscriptionData)) {
							return $this->userRepository->transactionResponse(1, ['show_message' => true], __tr('Buy Premium Plan successfully.'));
						}
					}
					//error response
					return $this->userRepository->transactionResponse(1, ['show_message' => true], __tr('Something went wrong, please contact to administrator.'));
				} else {
					//error response
					return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Selected plan not exists.'));
				}
			} else {
				//error response
				return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Please select plan first.'));
			}
		});

		//response
		return $this->engineReaction($buyPremiumPlanRequest);
	}

	/**
     * Process buy user premium plan.
     *
     *-----------------------------------------------------------------------*/
    public function processBuyPremiumPlanPaypal($planId)
    {	
		//buy premium plan request
		$buyPremiumPlanRequest = $this->userRepository->processTransaction(function() use ($planId) {
			$premiumPlanCollection = getStoreSettings('plan_duration');
			//if user already a premium user then throw error
			if (isPremiumUser()) {
				return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Your are already buy premium plan.'));
			}
			
			// check if user premium plan exists
			if (!__isEmpty($planId)) {
				$premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
				$selectedPlan = $premiumPlans[$planId];


				//check if plan exist
				if (!__isEmpty($selectedPlan)) {

					$expiryTime = null;
					$currentDateTime = Carbon::now();
					// get expiry time on current selected plan
					switch ($planId) {
						case 'one_day':
							$expiryTime = $currentDateTime->add(1, 'day');
						break;
						case 'one_week':
							$expiryTime = $currentDateTime->add(7, 'day');
						break;
						case 'one_month':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'half_year':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'life_time':
							$expiryTime = $currentDateTime->addYears(100);
						break;
						// Gold SDD/SMM
						case 'gold_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'gold_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'gold_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'gold_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;
						// Plantium SDD/SMM
						case 'plantium_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'plantium_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'plantium_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'plantium_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;

						// Gold SBB
						case 'gold_baby_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'gold_baby_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'gold_baby_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'gold_baby_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;
						// Plantium SBB
						case 'plantium_baby_1':
							$expiryTime = $currentDateTime->addMonths(1);
						break;
						case 'plantium_baby_3':
							$expiryTime = $currentDateTime->addMonths(3);
						break;
						case 'plantium_baby_6':
							$expiryTime = $currentDateTime->addMonths(6);
						break;
						case 'plantium_baby_12':
							$expiryTime = $currentDateTime->addMonths(12);
						break;							
					}

					//credit wallet store data
					$creditWalletStoreData = [
						'status' => 1,
						'users__id'=> getUserID(),
						'credits' => 0
					];

					//store credit wallet data and user subscription data
					if ($creditWalledId = $this->userRepository->storeCreditWalletTransaction($creditWalletStoreData)) {	
						//user subscription store data
						$storeSubscriptionData = [
							'status' => 1,
							'users__id' => getUserID(),
							'expiry_at' => $expiryTime,
							'plan_id'	=> $planId,
							'credit_wallet_transactions__id' => $creditWalledId
						];
						//store user subscription data
						if ($this->userRepository->storeUserSubscription($storeSubscriptionData)) {
							return $this->userRepository->transactionResponse(1, ['show_message' => true], __tr('Buy Premium Plan successfully.'));
						}
					}
					//error response
					return $this->userRepository->transactionResponse(1, ['show_message' => true], __tr('Something went wrong, please contact to administrator.'));
				} else {
					//error response
					return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Selected plan not exists.'));
				}
			} else {
				//error response
				return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Please select plan first.'));
			}
		});

		//response
		return $this->engineReaction($buyPremiumPlanRequest);
	}
}