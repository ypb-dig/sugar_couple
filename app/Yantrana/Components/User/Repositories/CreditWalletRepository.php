<?php
/*
* CreditWalletRepository.php - Repository file
*
* This file is part of the Credit Wallet User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\Repositories;
use DB;
use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\User\Models\{
    User as UserModel, UserAuthorityModel, CreditWalletTransaction
};
use App\Yantrana\Components\FinancialTransaction\Models\FinancialTransaction;
use Illuminate\Http\Request;

class CreditWalletRepository extends BaseRepository
{ 

     /**
      * Constructor
      * @param CreditWalletRepository  $creditWalletRepository  - User CreditWalletRepository
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(Request $request)
    {
        $this->request = $request;

    }

	 /**
     * fetch user wallet transaction list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchUserWalletTransactionList()
    {
        $dataTableConfig = [
        	'searchable' => []
        ];
        
		return CreditWalletTransaction::with('getUserGiftTransaction', 'getUserStickerTransaction','getUserBoostTransaction', 'getUserSubscriptionTransaction', 'getUserFinancialTransaction')
										->select(
											'_id',
											'_uid',
											'created_at',
											'credits',
											'financial_transactions__id',
											'credit_type'
										)
										->where('credit_wallet_transactions.users__id', getUserID())
										->dataTables($dataTableConfig)
										->toArray();
	}

     /**
     * fetch api user wallet transaction list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchApiUserWalletTransactionList()
    {
        $dataTableConfig = [
            'searchable' => []
        ];
        
        return CreditWalletTransaction::with('getUserGiftTransaction', 'getUserStickerTransaction','getUserBoostTransaction', 'getUserSubscriptionTransaction', 'getUserFinancialTransaction')
                                        ->select(
                                            '_id',
                                            '_uid',
                                            'created_at',
                                            'credits',
                                            'financial_transactions__id',
                                            'credit_type',
                                            'to_users__id'
                                        )
                                        ->where('credit_wallet_transactions.users__id', getUserID())
                                        ->customTableOptions($dataTableConfig);
    }

	 /**
     * fetch user transaction list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchUserTransactionListData($userId)
    {
        $dataTableConfig = [
        	'searchable' => []
        ];
        
		return FinancialTransaction::leftjoin('credit_wallet_transactions', 'financial_transactions._id', '=', 'credit_wallet_transactions.financial_transactions__id')
									->where('financial_transactions.users__id', $userId)
									->select(
										__nestedKeyValues([
											'financial_transactions' => [
												'_id',
												'_uid',
												'created_at',
												'updated_at',
												'amount',
												'users__id',
												'currency_code',
												'is_test',
												'status',
												'method',
												'__data'
											],
											'credit_wallet_transactions' => [
												'_id as walletId',
												'credit_type'
											]
										])
									)
									->dataTables($dataTableConfig)
									->toArray();
	}



    /**
     * Store new coupon using provided data.
     *
     * @param array $inputData
     *
     * @return mixed
     *---------------------------------------------------------------- */
    // Aqui está a lógica de conversão de moedas
    
    public function storePlanTransaction($inputData, $packageData)
    {
        $keyValues = [
            'status',
            'amount',
            'users__id',
            'method',
            'currency_code',
            'is_test',
            '__data'
        ];

        $financialTransaction = new FinancialTransaction;
       
        $credits = 0;

        if($inputData['amount'] && env('SUGAR_COIN_REAL', 0) != null){

            // get the user gender
            $gender = getUserGender();

            // Verfy if they are mammy or daddy
            if($gender == 1 or $gender == 2){
                
                // Receive 100% from payed value
                $credits += ($inputData['amount'] / 10) * env('SUGAR_COIN_REAL');
            }else{
                
                // Receive 10x from payed value with a plus of 100
                $credits += ($inputData['amount'] + 10) * env('SUGAR_COIN_REAL');
            }


            // if(($inputData['plan_uid'], 'gold') !== false){

                // Receive 10x from payed value with a plus of 100
            //     $credits += ($inputData['amount'] + 10) * env('SUGAR_COIN_REAL');

            // } else {
            //     // Receive 100% from payed value
            //     $credits += ($inputData['amount'] / 10) * env('SUGAR_COIN_REAL');
            // }
        }

        if($this->request->session()->has('cupom')){
            $inputData['method'] .= " - Using Cupom: " . $this->request->session()->get('cupom');
        }

        // Check if new User added
        if ($financialTransaction->assignInputsAndSave($inputData, $keyValues)) {
            //wallet transaction store data
            $keyValues = [
                'status'        => 1,
                'users__id'     => getUserID(),
                'credits'       => $credits, // todo: Calculate the credits earned with the plan
                'financial_transactions__id' => $financialTransaction->_id,
                'credit_type'   => 2 //Purchased
            ];

            $CreditWalletTransaction = new CreditWalletTransaction;
            // Check if new User added
            if ($CreditWalletTransaction->assignInputsAndSave([], $keyValues)) {
                return true;
            }
        }
        return false;   // on failed
    }

	/**
     * Store new coupon using provided data.
     *
     * @param array $inputData
     *
     * @return mixed
     *---------------------------------------------------------------- */
    public function storeTransaction($inputData, $packageData)
    {
		$keyValues = [
            'status',
            'amount',
            'users__id',
            'method',
            'currency_code',
			'is_test',
			'__data'
		];

		$financialTransaction = new FinancialTransaction;
       
        // Check if new User added
        if ($financialTransaction->assignInputsAndSave($inputData, $keyValues)) {
			//wallet transaction store data
			$keyValues = [
				'status' 		=> 1,
				'users__id'		=> getUserID(),
				'credits' 		=> (int) $packageData['credits'],
				'financial_transactions__id' => $financialTransaction->_id,
				'credit_type' 	=> 2 //Purchased
			];

			$CreditWalletTransaction = new CreditWalletTransaction;
            // Check if new User added
			if ($CreditWalletTransaction->assignInputsAndSave([], $keyValues)) {
				return true;
			}
        }
        return false;   // on failed
	}

    /**
     * Store new coupon using provided data.
     *
     * @param array $inputData
     *
     * @return mixed
     *---------------------------------------------------------------- */
    public function addCredits($credits, $userId)
    {
        $keyValues = [
            'status',
            'amount',
            'users__id',
            'method',
            'currency_code',
            'is_test',
            '__data',
        ];

        $inputData = [
            'credits' => $credits,
            'status' => 2,
            'amount' => 0,
            'users__id' => $userId,
            'method' => 'Bonus',
            'currency_code' => 'BRL',
            'is_test' => 0,
            '__data' => '',
        ];

        $financialTransaction = new FinancialTransaction;
       
        // Check if new User added
        if ($financialTransaction->assignInputsAndSave($inputData, $keyValues)) {
            //wallet transaction store data
            $keyValues = [
                'status'        => 1,
                'users__id'     => $userId,
                'credits'       => (int) $inputData['credits'],
                'financial_transactions__id' => $financialTransaction->_id,
                'credit_type'   => 1 //Bonuses
            ];

            $CreditWalletTransaction = new CreditWalletTransaction;
            // Check if new User added
            if ($CreditWalletTransaction->assignInputsAndSave([], $keyValues)) {
                return true;
            }
        }
        return false;   // on failed
    }

	/**
     * Store new coupon using provided data.
     *
     * @param array $inputData
     *
     * @return mixed
     *---------------------------------------------------------------- */
    public function storeWalletTransaction($inputData)
    {
		$keyValues = [
            'status',
            'users__id',
            'credits' => $inputData['credits'],
            'financial_transactions__id',
			'credit_type'
		];

		$CreditWalletTransaction = new CreditWalletTransaction;
       
        // Check if new User added
        if ($CreditWalletTransaction->assignInputsAndSave($inputData, $keyValues)) {
            return $CreditWalletTransaction;
        }

        return false;   // on failed
	}
}