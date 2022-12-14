<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Yantrana\Base\BaseController;
use Illuminate\Support\Facades\Log;
use App\Yantrana\Components\Payment\Controllers\PreOrder;
use Illuminate\Support\Facades\DB;

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

try {
    \PagSeguro\Library::initialize();
} catch (Exception $e) {
    die($e);
}

class NotificationApiController extends Controller
{
    public function notificationStatus(Request $request)
    {
        $baseUrl = "https://ws.pagseguro.uol.com.br";
        $envCode = env('PAGSEGURO_TOKEN');
        $emailCode = env('PAGSEGURO_EMAIL');
        $notificationCode = $request->get('notificationCode');

        if(env('PAGSEGURO_AMBIENTE') == 'sandbox'){
            $baseUrl = "https://ws.sandbox.pagseguro.uol.com.br";
        }

        $notifiCationApi = "$baseUrl/v3/transactions/notifications/$notificationCode?email=$emailCode&token=$envCode";

        $simpleGet = file_get_contents($notifiCationApi);

        if($simpleGet){
            $simpleXml = simplexml_load_string($simpleGet);
            $json = json_encode($simpleXml);
            $array = json_decode($json,TRUE);
 
            // Get the type of payment to pass to DB and get after to know if is "Boleto"
            $typeOfPayment = $array['paymentMethod']["type"];

            // Geting the status and reference code
            $reference = $array['reference'];
            $newStatus = $array['status'];
            $code = $array['code'];

            // It's slicing the string and getting off the Reff part from the reference code
            $referenceCode = str_replace("Reff ", "", $reference);
            
            //Gets the order in the DB and reattribute the current status code
            $OrderFromDb = PreOrder::where('id', $referenceCode)->get();

            // It's passing the type of payment to DB
            $OrderFromDb[0]->payment_type = $typeOfPayment;
            $OrderFromDb[0]->code = $code;

            $isBigger = $newStatus <= 3;
            
            // Checking if has Order with the passed status code and if the status code is approved
            if($OrderFromDb && $newStatus <= 3){
                // Passing the news status code to DB
                $OrderFromDb[0]->status_order_code_id = $newStatus;
            }
            // saving all data in db with the new status code
            $OrderFromDb[0]->save();
        }
        

        return $notifiCationApi;
    }

    public function getUserBoleto(Request $request, $userUid){

        $userPreOrder = PreOrder::where('user_uid', $userUid)->get()->toArray();
        // usar depois na verificação para pegar os pagamentos do tipo boleto
        $boletoCode = 2;

		if($userPreOrder){

            foreach ($userPreOrder as $key => $value) {
				
                $isBoleto = $value["payment_type"] == $boletoCode;

                $isBoletoPayed =  $value["status_order_code_id"] == 3;
                                
                if($isBoleto && $isBoletoPayed){
                    $data = $value;
                    return response()->json($data);
                }
            }
        }
        return response()->json("Nothing found");
    }

    public function setPaymentStatus(Request $request, bool $payed)
    {

        return response()->json(['message' => $payed], 200);
    }
}
