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
        dd($request);
        $reponse_code = $request->get('notificationCode');
        $reponse_code = response()->json($reponse_code, 201);
        
        return $reponse_code;
    }
    
}
