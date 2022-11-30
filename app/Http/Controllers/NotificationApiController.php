<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Yantrana\Base\BaseController;
use Illuminate\Support\Facades\Log;
use App\Yantrana\Components\Payment\Controllers\PreOrder;

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

        if(env('PAGSEGURO_AMBIENTE') == 'sandbox'){
            $baseUrl = "https://ws.sandbox.pagseguro.uol.com.br";
        }

        $reponse_code_notification = $request->get('notificationCode');

        $notifiCationApi = "$baseUrl/v3/transactions/notifications/$reponse_code_notification?email=$emailCode&token=$envCode";
        
        Log::info($reponse_code);

        return $reponse_code;
    }

    public function teste()
    {
        $baseUrl = "https://ws.pagseguro.uol.com.br";
        $envCode = "BBE92E17D2814E1AAA2A3EFB6EBAA7FD";
        $emailCode = "delfim.neto44@gmail.com";

        if(env('PAGSEGURO_AMBIENTE') == 'sandbox'){
            $baseUrl = "https://ws.sandbox.pagseguro.uol.com.br";
        }

        $notifiCationApi = "$baseUrl/v3/transactions/notifications/2EE0C5-0DF1ACF1ACF3-7774DB9FAFB3-B96F3B?email=$emailCode&token=$envCode";

        $simpleGet = file_get_contents($notifiCationApi);

        if($simpleGet){
            $simpleXml = simplexml_load_string($simpleGet);
            $json = json_encode($simpleXml);
            $array = json_decode($json,TRUE);
 
            $typeOfPayment = $array['paymentMethod']["type"];
            $refernce = $array['reference'];
            $newStatus = $array['status'];
            $refernceCode = str_replace("Reff", "", $refernce);
            
            $OrderFromDb = PreOrder::where('id', "24")->get();
            $OrderFromDb[0]->payment_type = $typeOfPayment;
            
            if($OrderFromDb && $newStatus == 3){
                $OrderFromDb[0]->status_order_code_id = 3;
                $OrderFromDb[0]->save();
            }           

        }

        return view('test.test', ["aqui" => $json]);
    }
    
}
