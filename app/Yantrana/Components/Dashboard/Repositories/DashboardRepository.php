<?php

/*
* DashboardRepository.php - Repository file
*
* This file is part of the Dashboard component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Dashboard\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\User\Models\{ User };
use App\Yantrana\Components\AbuseReport\Models\AbuseReportModel;
use App\Yantrana\Components\FinancialTransaction\Models\FinancialTransaction;
use DB;
use Carbon\Carbon;

class DashboardRepository extends BaseRepository
{
	/**
      * Fetch all users
      *
      * @return    eloquent collection object
      *---------------------------------------------------------------- */

    public function fetchUsers()
    {   
        return User::leftjoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
					->where('user_authorities.user_roles__id', '!=', 1)
					->select(
						__nestedKeyValues([
							'users.*',
							'user_authorities' => [
								'_id AS user_authority_id',
								'updated_at AS authority_updated_at',
								'user_roles__id'
							]
						])
					)
					->get();
    }

    /**
      * Fetch all online users
      *
      * @return    eloquent collection object
      *---------------------------------------------------------------- */

    public function fetchOnlineUsers()
    {   
        return User::leftjoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
					->select(
						__nestedKeyValues([
							'users.*',
							'user_authorities' => [
								'_id AS user_authority_id',
								'updated_at AS authority_updated_at',
								'user_roles__id'
							]
						])
					)
					->where('user_authorities.user_roles__id', '!=', 1)
					->where('user_authorities.updated_at', ">=", Carbon::now()->subMinutes(2))
					->get();
    }

    /**
      * Fetch Abuse report counts
      *
      * @return    eloquent collection object
      *---------------------------------------------------------------- */

    public function abuseReports($status = 1)
    {   
        return AbuseReportModel::where('status', '=', $status)->get();
    }

    /**
      * Fetch Financial transactions 
      *
      * @return    eloquent collection object
      *---------------------------------------------------------------- */

    public function currentYearfinancialTransactions($status = null)
    {
    	if (!is_null($status)) {

    		return FinancialTransaction::where('status', '=', $status)
    							->whereYear('created_at', Carbon::now()->format('Y'))
    							->select([
    								'*', DB::raw('month(created_at) AS month')
    							])
    							->get();
    	}

        return FinancialTransaction::whereYear('created_at', Carbon::now()->format('Y'))
        							->select([
	    								'*', DB::raw('month(created_at) AS month')
	    							])
        							->get();
    }

    /**
      * Fetch Users registered in current year
      *
      * @return    eloquent collection object
      *---------------------------------------------------------------- */

    public function currentYearRegistrations()
    {
        return User::leftjoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
        			->whereYear('users.created_at', Carbon::now()->format('Y'))
        			->where('user_profiles.gender', '!=', null)
					->select(
						__nestedKeyValues([
							'users' => [
								'_id',
								'created_at',
								'first_name',
								'last_name',
								DB::raw('month(users.created_at) AS month')
							],
							'user_profiles' => [
								'gender'
							]
						])
					)
					->get();
    }
}