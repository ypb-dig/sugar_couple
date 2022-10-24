<?php
// Response Codes & other global configurations
$techConfig = require app_path('Yantrana/__Laraware/Config/tech-config.php');

$techAppConfig = [
	/* Feature User Count 
	------------------------------------------------------------------------- */
	'random_feature_user_count' => '12',

	/* Account related 
    ------------------------------------------------------------------------- */
    'account' => [
        'expiry'    				=> 24 * 2, // 48 Hours
        'password_reminder_expiry'  => 24 * 2, // hours
		'change_email_expiry'       => 24 * 2 // hours
	],

	/* Login Otp valid minutes
    ------------------------------------------------------------------------- */
    'otp_expiry' => 5,

    /* Email Config
    ------------------------------------------------------------------------- */
    'mail_from'         =>  [
        env('MAIL_FROM_ADD', 'no-reply@queromeudaddy.com.br'),
        env('MAIL_FROM_NAME', 'Serviço de E-Mail')
	],
	
	/* There is defined the key for social login providers
    ------------------------------------------------------------------------- */
    'social_login_driver' =>  [
        'via-facebook'  => 'facebook',
        'via-google' 	=> 'google',
    ],

    /* There is defined the key for social login providers
    ------------------------------------------------------------------------- */
    'social_login_driver_keys' =>  [
        'facebook'   => 'via-facebook',
        'google'     => 'via-google',
	],
	
	/* Status Code Multiple Uses
    ------------------------------------------------------------------------- */
    'status_codes' => [
        1 => __tr('Active'),
        2 => __tr('Inactive'),
        3 => __tr('Blocked'),
        4 => __tr('Não Ativada'),
        5 => __tr('Deleted'),
        6 => __tr('Suspended'),
        7 => __tr('On Hold'),
        8 => __tr('Completed'),
        9 => __tr('Invite')
	],

	/* User Online Status
    ------------------------------------------------------------------------- */
    'user_online_status' => [
        1 => __tr('Online'),
        2 => __tr('Idle'),
        3 => __tr('Offline')
	],
	
	/* User Wallet Transaction type
    ------------------------------------------------------------------------- */
    'user_transaction_type' => [
        1 => __tr('Buying Package'),
        2 => __tr('Gift'),
        3 => __tr('Sticker'),
        4 => __tr('Profile Boost'),
        5 => __tr('Premium Plan'),
        6 => __tr('Bonus Credits')
    ],

    /* Profile Update Wizard
	------------------------------------------------------------------------- */
    'profile_update_wizard' => [
    	'step_one' => [
			'profile_picture',
			// 'gender',
            'looking_for',
			// 'dob'
		],
		'step_two' => [
			'location_latitude',
			'location_longitude'
		]
    ],

	/* Payment Status Code Multiple Uses
	------------------------------------------------------------------------- */
	'payments' => [
		'payment_methods' => [
			1 => ('PayPal'),
			2 => ('Stripe'),
			3 => ('Razorpay'),
            4 => ('Paypal Checkout'),
            5 => ('PagSeguro')
		],
		'status_codes' => [
			1 => __tr('Awaiting Payment'), // PayPal IPN Payments
			2 => __tr('Completed'),
			3 => __tr('Payment Failed'),
			4 => __tr('Pending'),
			5 => __tr('Refunded')
		],
		'payment_checkout_modes' => [
			1 => __tr('Test'),
        	2 => __tr('Live')
		],
		'credit_type' => [
			1 => __tr('Bonuses'),
			2 => __tr('Purchased')
		]
	],

	/* Mail Drivers 
    ------------------------------------------------------------------------- */
    'mail_drivers' => [
        'smtp' => [
            'id' => 'smtp',
            'name' => 'SMTP',
            'config_data' => [
                'port'          =>  'smtp_mail_port',
                'host'          =>  'smtp_mail_host', 
                'username'      =>  'smtp_mail_username',
                'encryption'    =>  'smtp_mail_encryption',
                'password'      =>  'smtp_mail_password_or_apikey'
            ]
        ],
        'sparkpost' => [
            'id' => 'sparkpost',
            'name' => 'Sparkpost',
            'config_data' => [
                'sparkpost_mail_password_or_apikey'
            ]
        ],
        'mailgun' => [
            'id' => 'mailgun',
            'name' => 'Mailgun',
            'config_data' => [
                'mailgun_domain',
                'mailgun_mail_password_or_apikey',
                'mailgun_endpoint'
            ]
        ],
    ],

    /* Mail encryption types 
    ------------------------------------------------------------------------- */
    'mail_encryption_types' => [
        'ssl' => 'SSL',
        'tls' => 'TLS',
        'starttls' => 'STARTTLS',
    ],
	
	/* Report User Status Code Multiple Uses
    ------------------------------------------------------------------------- */
    'report_user_status_codes' => [
        1 => __tr('Awaiting'),
        2 => __tr('Accepted'),
        3 => __tr('Rejected')
    ],

    /* Define logo name of application
    ------------------------------------------------------------------------- */
    'logo_name' => 'logo.png',

    /* Define small logo name of application
    ------------------------------------------------------------------------- */
    'small_logo_name' => 'logo-short.png',

    /* Define favicon name of application
    ------------------------------------------------------------------------- */
    'favicon_name' => 'favicon.ico',

    /* Default paginate count
    ------------------------------------------------------------------------- */
    'paginate_count' => 10,

    /* Digital Ocean Keys
    ------------------------------------------------------------------------- */
    'current_filesystem_driver' => env('FILESYSTEM_DRIVER', 'public-media-storage'),
    'do_full_url' => env('DO_FULL_URL'),

    /* Messenger Items
    ------------------------------------------------------------------------- */
    'messenger' => [
        'types' => [
            1 => 'Text',
            2 => 'Uploaded File',
            3 => 'Emoji',
            4 => 'Audio Call Init',
            5 => 'Video Call Init',
            6 => 'Audio',
            7 => 'Video',
            8 => 'Giphy',
            9 => 'Chat Invitation',
            10 => 'Accept',
            11 => 'Decline',
            12 => 'Sticker'
        ],
        'statuses' => [
            1 => 'Sent',
            2 => 'Delivered',
            3 => 'Seen'
        ]
    ],

    /* User Settings / Profile related items
    ------------------------------------------------------------------------- */
    'fake_data_generator' => [
    	'records_limits' => 100,
    	'default_password' => 'pass1234'
    ],

    'age_restriction' => [
    	'minimum' => 18,
    	'maximum' => 150
    ],
    
    /* User Settings / Profile related items
    ------------------------------------------------------------------------- */
    'user_settings' => [
        // Search / Find Matches Pagination
        'search_pagination' => 12,
        'gender' => [
            1 => __tr('Sugar Daddy'),
            2 => __tr('Sugar Mommy'),
            3 => __tr('Sugar Baby (Girl)'),
            4 => __tr('Sugar Baby (Boy)'),

            // 3 => __tr('Secret')
        ],
        'preferred_language' => [
            1 => __tr('English'),
            // 2 => __tr('Arabic'),
            // 3 => __tr('Dutch'),
            // 4 => __tr('French'),
            // 5 => __tr('German'),
            6 => __tr('Italian'),
            7 => __tr('Portuguese'),
            8 => __tr('Russian'),
            9 => __tr('Spanish'),
            // 10 => __tr('Turkish'),
            // 11 => __tr('Urdu'),
            // 12 => __tr('Hindi'),
            // 13 => __tr('Marathi'),
            14 => __tr('Chinese'),
            15 => __tr('Japanese'),
            // 16 => __tr('Bengali'),
            // 17 => __tr('Persian'),
            18 => __tr('Korean'),
            // 19 => __tr('Tamil'),
            // 20 => __tr('Hausa'),
            // 21 => __tr('Indonesian'),
            // 22 => __tr('Panjabi')
        ],
        'relationship_status' => [
            1 => __tr('Single'),
            2 => __tr('Married'),
            3 => __tr('Divorced'),
            4 => __tr('Widow')
        ],
        'work_status' => [
            1 => __tr("Studying"),
            2 => __tr("Working"),
            3 => __tr("Looking for work"),
            4 => __tr("Retired"),
            5 => __tr("Self-Employed"),
            6 => __tr("Other")
        ],
        'educations' => [
            1 => __tr('Secondary school'),
            2 => __tr('ITI'),
            3 => __tr('College'),
            4 => __tr('University'),
            5 => __tr('Advanced degree'),
            6 => __tr('Other')
        ]
    ],
];

$appTechConfig = [];
if (file_exists(base_path('user-tech-config.php'))) {
    $appTechConfig = require base_path('user-tech-config.php');
}
return array_merge( $techConfig, $techAppConfig, $appTechConfig);