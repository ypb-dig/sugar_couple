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

            // It's slicing the string and getting off the Reff part from the reference code
            $referenceCode = str_replace("Reff", "", $reference);
            
            //Gets the order in the DB and reattribute the current status code
            $OrderFromDb = PreOrder::where('id', "4")->get();

            // It's passing the type of payment to DB
            $OrderFromDb[0]->payment_type = $typeOfPayment;

            $isBigger = $newStatus <= 3;

            // dd($isBigger);
            
            // Checking if has Order with the passed status code and if the status code is approved
            if($OrderFromDb && $newStatus <= 3){
                // Passing the news status code to DB
                $OrderFromDb[0]->status_order_code_id = $newStatus;
            }

            $OrderFromDb[0]->save();
        }
        

        return $notifiCationApi;
    }

    public function teste()
    {

        $baseUrl = "https://ws.pagseguro.uol.com.br";
        $envCode = env('PAGSEGURO_TOKEN');
        $emailCode = env('PAGSEGURO_EMAIL');
        $notificationCode = "ADFC8D8251D651D608EBB4C6FFB08D5ED214";

        if(env('PAGSEGURO_AMBIENTE') == 'sandbox'){
            $baseUrl = "https://ws.sandbox.pagseguro.uol.com.br";
        }

        $notifiCationApi = "$baseUrl/v3/transactions/notifications/$notificationCode?email=$emailCode&token=$envCode";

        dd($notifiCationApi);

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

            // It's slicing the string and getting off the Reff part from the reference code
            $referenceCode = str_replace("Reff", "", $reference);
            
            //Gets the order in the DB and reattribute the current status code
            $OrderFromDb = PreOrder::where('id', "4")->get();

            // It's passing the type of payment to DB
            $OrderFromDb[0]->payment_type = $typeOfPayment;
            
            // Checking if has Order with the passed status code and if the status code is approved
            if($OrderFromDb && $newStatus <= 3){
                // Passing the news status code to DB
                $OrderFromDb[0]->status_order_code_id = $newStatus;
            }

            $OrderFromDb[0]->save();
        }
        
        $pre_orders = DB::table('pre_orders')->get();
        return view('test.test', ["pre_orders" => $pre_orders]);
    }
    
}
