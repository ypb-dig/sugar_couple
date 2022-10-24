<?php
/*
* ConfigurationRequest.php - Request file
*
* This file is part of the Configuration component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Configuration\Requests;

use App\Yantrana\Base\BaseRequest;
use Illuminate\Http\Request;

class ConfigurationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the user register request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        $requestData = new Request;
        $inputData = $this->all();
        
        $pageType = request()->pageType;
        
        $rules = [];
        // check validation via page type
        switch ($pageType) {
            case 'general':
                $rules = [
                    'name'              => 'required',
                    'business_email'    => 'required|email',
                    'contact_email'     => 'required|email'
                ];
            break;
        
            case 'user':
                $rules = [
                    'activation_required_for_new_user' => 'required'
                ];
			break;

			case 'cupom':
                $rules = [
                    'cupom_name' => 'required|min:5|max:45|unique:cupom,name',
                    'cupom_percentage' => 'required',
                    'cupom_plan' => 'required'

                ];
			break;
			
			case 'credit-package':
				$formType = $requestData::input('form_type');
				if ($formType == 'currency_form') {
					$rules = [
						'currency'                      => 'required',
						'currency_symbol'               => 'required',
						'currency_value'                => 'required',
						'round_zero_decimal_currency'   => 'required'
					];
				} else {
                    $uid = $inputData['uid'];
                    foreach ($inputData['credit_packages']['package_data'][$uid] as $key => $value) {
                        $rules['credit_packages.package_data.'.$uid.'.'.$key] = 'required';
                    }
                    
				}
				
			break;
		
			case 'payment':
                $enablePaypal = $inputData['enable_paypal'];
                $enableStripe = $inputData['enable_stripe'];
                $enableRazorpay = $inputData['enable_razorpay'];
               
                // check if paypal checkout is enable
                if ($enablePaypal) {
                    $paypalTestMode = $inputData['use_test_paypal_checkout'];
                    // Check if paypal test mode is enable
                    if ($paypalTestMode and !$inputData['paypal_test_keys_exist']) {
                        $rules = [
                            'paypal_checkout_testing_client_id'  => 'required',
                            'paypal_checkout_testing_secret_key' => 'required'
                        ];
                    } elseif (!$paypalTestMode and !$inputData['paypal_live_keys_exist']) {
                        $rules = [
                            'paypal_checkout_live_client_id'  => 'required',
                            'paypal_checkout_live_secret_key' => 'required'
                        ];
                    }
                }
                 
                // check if stripe payment enable
                if ($enableStripe) {
                    $stripeTestMode = $inputData['use_test_stripe'];
                    // Check if stripe test mode is enable
                    if ($stripeTestMode and !$inputData['stripe_test_keys_exist']) {
                        $rules = [
                            'stripe_testing_secret_key'  => 'required',
                            'stripe_testing_publishable_key' => 'required'
                        ];
                    } elseif (!$stripeTestMode and !$inputData['stripe_live_keys_exist']) {
                        $rules = [
                            'stripe_live_secret_key'  => 'required',
                            'stripe_live_publishable_key' => 'required'
                        ];
                    }
                }


                // check if razorpay payment enable
                if ($enableRazorpay) {
                    $razorpayTestMode = $inputData['use_test_razorpay'];
                    // Check if stripe test mode is enable
                    if ($razorpayTestMode and !$inputData['razorpay_test_keys_exist']) {
                        $rules = [
                            'razorpay_testing_key'  => 'required',
                            'razorpay_testing_secret_key' => 'required'
                        ];
                    } elseif (!$razorpayTestMode and !$inputData['razorpay_live_keys_exist']) {
                        $rules = [
                            'razorpay_live_key'  => 'required',
                            'razorpay_live_secret_key' => 'required'
                        ];
                    }
                }
               
			break;
			
			case 'social-login':
				$allFacebookLogin = $inputData['allow_facebook_login'];
				$allGoogleLogin = $inputData['allow_google_login'];
				//if facebook login are enable then add required validation
				if ($allFacebookLogin and !$inputData['facebook_keys_exist']) {
					$rules = [
						'facebook_client_id'  => 'required',
						'facebook_client_secret' => 'required'
					];
				}
				//if google login are enable then add required validation
				if ($allGoogleLogin and !$inputData['google_keys_exist']) {
					$rules = [
						'google_client_id'  => 'required',
						'google_client_secret' => 'required'
					];
				}
			break;

			case 'integration':
				$allowPusher = $inputData['allow_pusher'];
				$allowAgora = $inputData['allow_agora'];
				$allowGoogleMap = $inputData['allow_google_map'];
				$allowGiphy = $inputData['allow_giphy'];
				
				//apply pusher validation message
				if ($allowPusher and !$inputData['pusher_keys_exist']) {
					$rules = [
						'pusher_app_id'  			=> 'required',
						'pusher_app_key' 			=> 'required',
						'pusher_app_secret' 		=> 'required',
						'pusher_app_cluster_key' 	=> 'required'
					];
				}
				//apply agora validation message
				if ($allowAgora and !$inputData['agora_keys_exist']) {
					$rules = [
						'agora_app_id'  			=> 'required',
						'agora_app_certificate_key' => 'required',
					];
				}
				//apply google map validation message
				if ($allowGoogleMap and !$inputData['google_map_keys_exist']) {
					$rules = [
						'google_map_key'  			=> 'required'
					];
				}
				//apply giphy validation message
				if ($allowGiphy and !$inputData['giphy_keys_exist']) {
					$rules = [
						'giphy_key'  			=> 'required'
					];
				}
			break;

            case 'email':

	          	//driver specific rules
	          	$driverRules = [];

	          	if ($inputData['use_env_default_email_settings'] != "1") {

		          	//default rules
		          	$rules = [
						'mail_from_address'	=> "required|email",
						'mail_from_name'	=> "required",
						'mail_driver'		=> "required"
		          	];

		          	//for driver specific rules
		          	switch ($inputData['mail_driver']) {

			          	case 'smtp':
			          		$driverRules = [
								'smtp_mail_host'				=>	"required",
								'smtp_mail_port'				=>	"required",
								'smtp_mail_encryption'			=>	"required",
								'smtp_mail_username'			=>	"required",
								'smtp_mail_password_or_apikey'	=>	"required",
							];
			          		break;

			          	case 'sparkpost':
			          		$driverRules = [	
								'sparkpost_mail_password_or_apikey'	=>	"required"
							];
		          		break;

		          		case 'mailgun':
			          		$driverRules = [
								'mailgun_domain'	=>	"required"
							];
		          		break;
			          	
			          	default:
			          		$driverRules = [];
		          		break;
		          	}
	          	}

	          	$rules = array_merge($rules, $driverRules);
          	break;

            default:
				$rules = [];
            break;
        }
        
        return $rules;
    }


    /**
     * Get the validation rules that apply to the user register request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function messages()
    {

        return [           
            'cupom_name.required' => "O Nome do cupom é obrigatório.",
            'cupom_plan.required' => "O Plano do cupom é obrigatório.",

            'cupom_name.min' => "O nome do cupom deve ter pelo menos 5 caracteres e no máximo 45",
            'cupom_name.max' => "O nome do cupom deve ter pelo menos 5 caracteres e no máximo 45",

            'cupom_name.unique' => "O nome deste cupom já esta sendo utilizado.",
            'cupom_percentage.required' => "O Percentual de desconto é obrigatório."
        ];
    }
}
