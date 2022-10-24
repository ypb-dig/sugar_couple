<?php
/*
* HomeController.php - Controller file
*
* This file is part of the Home component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Home\Controllers;

use App\Yantrana\Base\BaseController; 
use App\Yantrana\Components\Home\HomeEngine;
use App\Yantrana\Components\User\UserEncounterEngine;
use App\Yantrana\Components\Filter\FilterEngine;
use App\Yantrana\Support\CommonUnsecuredPostRequest;
use App\Yantrana\Components\Pages\ManagePagesEngine;
use App\Yantrana\Components\User\PremiumPlanEngine;
use Illuminate\Http\Request;


class HomeController extends BaseController 
{    
    /**
     * @var  HomeEngine $homeEngine - Home Engine
     */
    protected $homeEngine;

    /**
     * @var  UserEncounterEngine $userEncounterEngine - UserEncounter Engine
     */
    protected $userEncounterEngine;
    
    /**
     * @var  FilterEngine $filterEngine - Filter Engine
     */
    protected $filterEngine;

    /**
     * @var  ManagePagesEngine $managepageEngine - Manage Pages Engine
     */
    protected $managepageEngine;

    /**
      * Constructor
      *
      * @param  HomeEngine $homeEngine - Home Engine
      * @param  ManagePagesEngine $managepageEngine - Manage Pages Engine
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(
        HomeEngine $homeEngine,
        UserEncounterEngine $userEncounterEngine,
        FilterEngine $filterEngine,
        ManagePagesEngine $managepageEngine,
        PremiumPlanEngine $premiumPlanEngine
    )
    {
        $this->homeEngine           = $homeEngine;
        $this->userEncounterEngine 	= $userEncounterEngine;
        $this->filterEngine         = $filterEngine;
        $this->managepageEngine         = $managepageEngine;
        $this->premiumPlanEngine = $premiumPlanEngine;

    }

    /**
     * View Home Page
     *---------------------------------------------------------------- */
    public function homePage()
    {
        // get encounter data
        $encounterData = $this->userEncounterEngine->getEncounterUserData();
        // For Random search use following function
        $basicSearchData = $this->filterEngine->prepareRandomUserData([], 12);
        // merge encounter data and basic data
        $processReaction = array_merge($encounterData['data'], $basicSearchData['data']);

        return $this->loadPublicView('home', $processReaction);
    }
    

    /**
     * ChangeLocale - It also managed from index.php.
     *---------------------------------------------------------------- */
    protected function changeLocale(CommonUnsecuredPostRequest $request, $localeId = null)
    {
        if (is_string($localeId)) {
            changeAppLocale($localeId);
        }
        if ($request->has('redirectTo')) {
            header('Location: '.base64_decode($request->get('redirectTo')));
            exit();
        }

        return __tr('Invalid Request');
    }

    /**
     * preview page
     *---------------------------------------------------------------- */
    public function previewPage($pageUid, $title)
    {
    	$processReaction = $this->managepageEngine->previewPage($pageUid);

        return $this->loadView('pages.preview', $processReaction['data']);
    }

    /**
     * preview landing page
     *---------------------------------------------------------------- */
    public function landingPage()
    {
        return $this->loadView('outer-home');
    }

    /**
     * preview privacy page
     *---------------------------------------------------------------- */
    public function privacyPage()
    {
        return $this->loadView('outer-privacy');
    }

    /**
     * preview terms page
     *---------------------------------------------------------------- */
    public function termsPage()
    {
        return $this->loadView('outer-terms');
    }
    /**
     * preview plans page
     *---------------------------------------------------------------- */
    public function plansPage()
    {
        $processReaction = $this->premiumPlanEngine->preparePremiumPlanUserData();
       
        //return $this->loadPublicView('outer-plans', $processReaction['data']);

        return $this->loadView('outer-plans', $processReaction['data']);
    }

    /**
     * Search Matches
     *---------------------------------------------------------------- */
    public function searchMatches(CommonUnsecuredPostRequest $request)
    {
        $inputData = $request->all();
        // Set user search data into session
        session()->put('userSearchData', [
            "looking_for"   => $inputData['looking_for'],
            "min_age"       => $inputData['min_age'],
            "max_age"       => $inputData['max_age']
        ]);

        return redirect()->route('user.sign_up');
    }

    public function blurredImages(Request $request){
            header('Content-Type: image/jpeg');

            if(!$request->has('path'))
                return;

            $file =  $request->query('path');
            $type = pathinfo($file, PATHINFO_EXTENSION);
            
            switch($type){
              case 'png':
                $image = imagecreatefrompng($file);
                break;
              case 'jpeg':
              case 'jpg':
                $image = imagecreatefromjpeg($file);
              default:
                $image = imagecreatefromjpeg($file);
            }

            /* Get original image size */
            list($w, $h) = getimagesize($file);

            /* Create array with width and height of down sized images */
            $size = array('sm'=>array('w'=>intval($w/4), 'h'=>intval($h/4)),
                           'md'=>array('w'=>intval($w/2), 'h'=>intval($h/2))
                          );                       

            /* Scale by 25% and apply Gaussian blur */
            $sm = imagecreatetruecolor($size['sm']['w'],$size['sm']['h']);
            imagecopyresampled($sm, $image, 0, 0, 0, 0, $size['sm']['w'], $size['sm']['h'], $w, $h);

            for ($x=1; $x <=5; $x++){
                imagefilter($sm, IMG_FILTER_GAUSSIAN_BLUR, 999);
            } 

            imagefilter($sm, IMG_FILTER_SMOOTH,99);
            imagefilter($sm, IMG_FILTER_BRIGHTNESS, 10);        

            /* Scale result by 200% and blur again */
            $md = imagecreatetruecolor($size['md']['w'], $size['md']['h']);
            imagecopyresampled($md, $sm, 0, 0, 0, 0, $size['md']['w'], $size['md']['h'], $size['sm']['w'], $size['sm']['h']);
            imagedestroy($sm);

                for ($x=1; $x <=1; $x++){
                    imagefilter($md, IMG_FILTER_GAUSSIAN_BLUR, 999);
                } 

            imagefilter($md, IMG_FILTER_SMOOTH,99);
            imagefilter($md, IMG_FILTER_BRIGHTNESS, 10);        

        /* Scale result back to original size */
        imagecopyresampled($image, $md, 0, 0, 0, 0, $w, $h, $size['md']['w'], $size['md']['h']);
        imagedestroy($md);  

        // Apply filters of upsized image if you wish, but probably not needed
        //imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR); 
        //imagefilter($image, IMG_FILTER_SMOOTH,99);
        //imagefilter($image, IMG_FILTER_BRIGHTNESS, 10);       

        imagejpeg($image);
        imagedestroy($image);
    }
}