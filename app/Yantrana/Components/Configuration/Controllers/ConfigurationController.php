<?php
/*
* ConfigurationController.php - Controller file
*
* This file is part of the Configuration component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Configuration\Controllers;
use App\Yantrana\Support\CommonPostRequest;
use App\Yantrana\Base\BaseController; 
use App\Yantrana\Components\Configuration\Requests\ConfigurationRequest;
use App\Yantrana\Components\Configuration\ConfigurationEngine;
use Illuminate\Http\Request;

use Artisan;

class ConfigurationController extends BaseController 
{    
    /**
     * @var  ConfigurationEngine $configurationEngine - Configuration Engine
     */
    protected $configurationEngine;

    /**
      * Constructor
      *
      * @param  ConfigurationEngine $configurationEngine - Configuration Engine
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(ConfigurationEngine $configurationEngine)
    {
        $this->configurationEngine = $configurationEngine;
    }
    
    /**
     * Get Configuration Data.
     *
     * @param string $pageType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function getConfiguration($pageType) 
    {  
        $processReaction = $this->configurationEngine->prepareConfigurations($pageType);
        
        return $this->loadManageView('configuration.settings', $processReaction['data']);   
    }

     /**
     * Get Configuration Data.
     *
     * @param string $pageType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreConfiguration(ConfigurationRequest $request, $pageType) 
    {
        $processReaction = $this->configurationEngine->processConfigurationsStore($pageType, $request->all());
      
        return $this->responseAction($this->processResponse($processReaction, [], [], true));
    }

     /**
     * Get Configuration Data.
     *
     * @param string $pageType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processDeleteConfiguration(Request $request, $pageType, $cupom) 
    {
        $processReaction = $this->configurationEngine->processConfigurationsDelete($pageType, $request->all(), $cupom);
      
        return $this->responseAction($this->processResponse($processReaction, [], [], true));
    }


    /**
     * Clear system cache
     *
     * @param ManageItemAddRequest $request
     *
     * @return void
     *---------------------------------------------------------------- */
    public function clearSystemCache(ConfigurationRequest $request)
    {
        $homeRoute = route('manage.dashboard');
        $cacheClearCommands = array(
            'route:clear', 
            'config:clear', 
            'cache:clear', 
            'view:clear', 
            'clear-compiled', 
            'config:clear'
        );

        foreach ($cacheClearCommands as $cmd) {
            Artisan::call('' . $cmd . '');
        }
         if ($request->has('redirectTo')) {
            header('Location: '.base64_decode($request->get('redirectTo')));
        } else {
            header('Location: '.$homeRoute);
        }

        exit();
    }
}