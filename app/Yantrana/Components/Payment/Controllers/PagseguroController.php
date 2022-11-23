<?php

namespace App\Yantrana\Components\Payment\Controllers;

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

\PagSeguro\Configuration\Configure::setEnvironment(env('PAGSEGURO_AMBIENTE')); //production or sandbox

\PagSeguro\Configuration\Configure::setAccountCredentials(
    /**
     * @see https://devpagseguro.readme.io/v1/docs/autenticacao#section-obtendo-suas-credenciais-de-conta
     *
     * @var string $accountEmail
     */
    env('PAGSEGURO_EMAIL'),
    /**
     * @see https://devpagseguro.readme.io/v1/docs/autenticacao#section-obtendo-suas-credenciais-de-conta
     *
     * @var string $accountToken
     */
    env('PAGSEGURO_TOKEN')
);

/**
 *
 * @see https://devpagseguro.readme.io/docs/endpoints-da-api#section-formato-de-dados-para-envio-e-resposta
 *
 * @var string $charset
 * @options=['UTF-8', 'ISO-8859-1']
 */
\PagSeguro\Configuration\Configure::setCharset('UTF-8');

/**
 * Path do arquivo de log, tenha certeza de que o php terá permissão para escrever no arquivo
 *
 * @var string $logPath
 */
\PagSeguro\Configuration\Configure::setLog(true, storage_path() . '/logs/pagseguro.log');

try {
    $response = \PagSeguro\Services\Session::create(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
    );
} catch (Exception $e) {
    die($e->getMessage());
}


class PagseguroController extends BaseController
{
    public function checkout(Request $request)
    {
        $user = getUserAuthInfo();
        $payment = new \PagSeguro\Domains\Requests\Payment();
        $payment->addItems()->withParameters(
            $request->get('itemId1'),
            $request->get('itemDescription1'),
            $request->get('itemAmount1'),
            $request->get('itemPrice1')
        );
        $payment->setCurrency("BRL");

        $payment->setReference("SUGAR_" . $user['profile']['_uid']);

        $payment->setShipping()->setAddressRequired()->withParameters('FALSE');

        if(preg_match("/\w+([, ]+\w+){1,2}/", $user['profile']['first_name'])){
            $payment->setSender()->setName($user['profile']['first_name']);
        }

        if(env('PAGSEGURO_AMBIENTE') == 'sandbox'){
            $payment->setSender()->setName('Luiz Martins');
            $payment->setSender()->setEmail('luiz@sandbox.pagseguro.com.br');
            $payment->setSender()->setPhone()->withParameters(
                11,
                56273440
            );
        } else {
            $payment->setSender()->setEmail($user['profile']['email']);
        }



        try {
            $onlyCheckoutCode = true;
            $result = $payment->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials(),
                $onlyCheckoutCode
            );
            $code = $result->getCode();
            return response()->json($code, 201);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function notification(Request $request)
    {
        $reponse_code = $request->get('notificationCode');
        
        Log::info($reponse_code);

        return $reponse_code;
    }
    
}