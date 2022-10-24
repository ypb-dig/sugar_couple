<?php
/*
* ManageAbuseReportRepository.php - Repository file
*
* This file is part of the AbuseReport component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\AbuseReport\Repositories;
use Auth;
use DB;
use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\AbuseReport\Models\AbuseReportModel;

class ManageAbuseReportRepository extends BaseRepository
{
    /**
     * Constructor.
     *
     * @param Page $report - report Model
     *-----------------------------------------------------------------------*/
    public function __construct() { }

	 /**
     * fetch all report list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchListData($status)
    {
		return AbuseReportModel::leftjoin('users', 'abuse_reports.for_users__id', '=', 'users._id')
							->select(
								__nestedKeyValues([
									'abuse_reports.*',
									'users' => [
										'_id as userId',
                                		DB::raw('users.first_name AS reportedUserName')
									]
								])
							)
							->where('abuse_reports.status', $status)
							->groupBy('abuse_reports.for_users__id')
							->get();
	}

	/**
     * fetch all report list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchAbuseReport($userIds)
    {
		return AbuseReportModel::where('for_users__id', $userIds)
								->where('by_users__id', getUserID())
								->first();
	}

	/**
     * fetch all report list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchReportByUser($userIds)
    {
		return AbuseReportModel::join('users', 'abuse_reports.by_users__id', '=', 'users._id')
							->whereIn('abuse_reports.for_users__id', $userIds)
							->select(
								__nestedKeyValues([
									'abuse_reports' => [
										'_id',
										'created_at',
										'updated_at',
										'status',
										'for_users__id',
										'by_users__id',
										'reason'
									],
									'users' => [
										'_id as userId',
                                		DB::raw('users.first_name AS reportedByUser')
									]
								])
							)
							->get();
	}

	/**
     * fetch report data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
		//check is numeric
		if (is_numeric($idOrUid)) {
			return AbuseReportModel::where('_id', $idOrUid)->first();
        } else {
			return AbuseReportModel::where('_uid', $idOrUid)->first();
        }
	}

	/**
     * Store Abuse Report.
     *
     * @param array $storeData
     * 
     *-----------------------------------------------------------------------*/
    public function storeReportUser($storeData)
    {
        $keyValues = [
            'status',
            'for_users__id',
			'by_users__id',
			'reason'
		];
		
        // Get Instance of Abuse Report model
		$abuseReportModel = new AbuseReportModel;
		
        // Store Abuse User Report
        if ($abuseReportModel->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
	}

	 /**
     * Update moderate report Data
     *
     * @param object $page
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function batchUpdate($updateData)
    {
		$AbuseReportModel = new AbuseReportModel;
		
        // Check if information updated
        if ($AbuseReportModel->batchUpdate($updateData, '_id')) {
			$user = Auth::user();
			$userName = $user->first_name.' '.$user->last_name;
			activityLog('Abuse Report Moderated by '. $userName);

            return true;
        }

        return false;
	}
}