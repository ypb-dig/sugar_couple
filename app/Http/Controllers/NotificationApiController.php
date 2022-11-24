<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Yantrana\Base\BaseController;
use Illuminate\Support\Facades\Log;

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
        $reponse_code = $request->get('notificationCode');
        
        Log::info($reponse_code);

        return "OLÁ Estou aqui";
    }
    
}
