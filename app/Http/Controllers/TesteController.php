<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\teste_req;
use Illuminate\Support\Facades\Log;

class TesteController extends Controller
{
    function reqPostTeste( Request $request)
    {   
        $request->all();
        $string = $request->texto;
        $num = $request->numb;

        Log::info($request->all());
    }
}
