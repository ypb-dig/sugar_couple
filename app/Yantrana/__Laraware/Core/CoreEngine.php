<?php

namespace App\Yantrana\__Laraware\Core;

/*
 * Core Engine - 1.2.0 - 07 AUG 2018
 * 
 * core engine for Angulara (Laraware) applications
 *
 * @since 0.1.174 - 24 JUN 2016
 *--------------------------------------------------------------------------- */

use Exception;
use Session;
use Request;
use Response;

abstract class CoreEngine
{
    /**
     * Send reaction from Engine mostly to Controllers.
     *
     * @param array  $reactionCode - Reaction from Repo
     * @param array  $data         - Array of data if needed
     * @param string $message      - Message if any
     * 
     * @return array
     *-------------------------------------------------------------------------- */
    public function engineReaction($reactionCode, $data = null, $message = null)
    {
        if (is_array($reactionCode) === true) {
            $message = $reactionCode[2];
            $data = (is_array($data) and is_array($reactionCode[1])) 
                                    ? array_merge($reactionCode[1], $data) 
                                    : (empty($reactionCode[1]) 
                                        ? (empty($data) ? null : $data) 
                                        : $reactionCode[1]);

            $reactionCode = $reactionCode[0];
        }

        if (__isValidReactionCode($reactionCode) === true) {
            return [
                'reaction_code' => (integer) $reactionCode,
                'data' => $data,
                'message' => $message,
            ];
        }

        throw new Exception('__engineReaction:: Invalid Reaction Code!!');
    }

    /*
    * Load DataTable Helper 0.2.1 - 03 JUN 2015
    * 
    * helper function to load datatable.
    *
    * @param array $data - for request response
    * 
    * @return void.
    *-------------------------------------------------------- */
    public function dataTableResponse($sourceData, $dataFormat = [], $options = [])
    {
        $data = [];
        $rawData = $sourceData['data'];
        $enhancedData = [];

        foreach ($rawData as $key) {
            $newDataFormat = [];

            if (!empty($dataFormat)) {
                foreach ($dataFormat as $dataItemKey => $dataItemValue) {
                    if (is_numeric($dataItemKey)) {
                        $newDataFormat[ $dataItemValue ] = $key[ $dataItemValue ];
                    } elseif (! is_string($dataItemValue) and is_callable($dataItemValue)) {
                        $newDataFormat[ $dataItemKey ] = call_user_func($dataItemValue, $key);
                    } else {
                        $newDataFormat[ $dataItemKey ] = $key[ $dataItemValue ];
                    }
                }
            } else {
                $newDataFormat = $key;
            }

            $primaryKey = array_key_exists('_id', $key) ? '_id' : 'id';

            $newDataFormat['DT_RowId'] = 'rowid_'.$key[$primaryKey];

            $enhancedData[] = $newDataFormat;
        }

        $dataTablesData = array(
                'recordsTotal' => $sourceData['total'],
                'data' => $enhancedData,
                'recordsFiltered' => $sourceData['total'],
                'draw' => (int) Request::get('draw'),
            );

        $data['response_token'] = (int) Request::get('fresh');

        $data = array_merge($data, $dataTablesData);

        if (!empty($options)) {
            $data['_options'] = $options;
        }

        unset($enhancedData, $rawData, $sourceData, $dataFormat, $dataTablesData);
        
        $data['dataTableResponse'] = true;

        return __apiResponse($data);
    }

    /**
     * Extract engine data for internal use
     *
     * @param array  $engineReaction - Engine Reaction
     * @param array  $data         - Array of data if needed
     * @param string $message      - Message if any
     * 
     * @return array
     *-------------------------------------------------------------------------- */
    public function engineData($engineReaction, $key = null)
    {
        // Engine Reaction Validation
        if(is_array($engineReaction) 
            and array_key_exists('reaction_code', $engineReaction)
            and array_key_exists('data', $engineReaction)
            and array_key_exists('message', $engineReaction)
            ) {

            if($key) {
                if(array_key_exists($key, $engineReaction['data'])) {
                    // Get the Data out of it
                    return $engineReaction['data'][$key];
                }
                return null;
            }

            // Get the Data out of it
            return $engineReaction['data'];
        }

        throw new Exception('ENGINE:: Invalid Engine Reaction???');
    }
}