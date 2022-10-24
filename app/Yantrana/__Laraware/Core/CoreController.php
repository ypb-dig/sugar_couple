<?php

namespace App\Yantrana\__Laraware\Core;

use App\Http\Controllers\Controller;
use View;
/**
 * CoreController - 0.2.0 - 10 JUN 2019.
 * 
 *-------------------------------------------------------- */
abstract class CoreController extends Controller 
{

    /**
     * Force Secure output
     *
     * @var bool
     *----------------------------------------------------------------------- */
    protected $forceSecureResponse = false;

    /**
     * Load view helper
     *
     * @param string  $viewName    - View Name
     * @param array  $data         - Array of data if needed
     * 
     * @return array
     *-------------------------------------------------------------------------- */
    public function loadView($viewName, $data = [])
    {
        $output = View::make($viewName, $data)->render();

        if (env('APP_DEBUG', false) === false) {
            $filters = array(
                '/(?<!\S)\/\/\s*[^\r\n]*/'  => '',  // Remove comments in the form /* */
                '/\s{2,}/'                  => ' ', // Shorten multiple white spaces
                '/(\r?\n)/'                 => '',  // Collapse new lines
            );

            $output = preg_replace(
                array_keys($filters),
                array_values($filters),
                $output
            );
        } 

        $clogSessItemName = '__clog';
        if (!empty(config('app.'.$clogSessItemName, []))) {

            $responseData = [
                '__dd'              => true,
                '__clogType'        => 'NonAjax',
                $clogSessItemName   => config('app.'. $clogSessItemName),
            ];

            //reset the __clog items in session
            config(['app.' . $clogSessItemName => [] ]);
            $output = $output.'<script type="text/javascript">__globals.clog('.json_encode($responseData).');</script>';
        }

        return $output;
    }

    /*
      * Process response & send API response
      *
      * @param Integer  $engineReaction - Engine reaction 
      * @param Array    $responses      - Response Messages as per reaction code
      * @param Array    $data           - Additional Data for success
      * 
      * @return array
      *---------------------------------------------------------------- */
    public function processResponse($engineReaction, $messageResponses = [],
            $data = [],
            $appendEngineData = false)
    {
        // forced to be secured
        if($this->forceSecureResponse === true) {
            return __secureProcessResponse(
                $engineReaction, 
                $messageResponses, 
                $data, 
                $appendEngineData
            ); 
        }

        return __processResponse(
            $engineReaction, 
            $messageResponses, 
            $data, 
            $appendEngineData
        );
    }

    /*
      * Process response & send API encrypted response
      *
      * @param Integer  $engineReaction - Engine reaction 
      * @param Array    $responses      - Response Messages as per reaction code
      * @param Array    $data           - Additional Data for success
      * 
      * @return array
      *---------------------------------------------------------------- */
    public function secureProcessResponse($engineReaction, $messageResponses = [],
            $data = [],
            $appendEngineData = false)
    {
        return __secureProcessResponse(
            $engineReaction, 
            $messageResponses, 
            $data, 
            $appendEngineData
        );
    }
}