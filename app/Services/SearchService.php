<?php

namespace App\Services;

use App\Models\ServiceGooglesheet;
use App\Models\CoachGooglesheet;

class SearchService
{
    public function SearchforDashboard($query)
    {
        // Get results from ServiceGooglesheet
        $serviceResults = ServiceGooglesheet::query()
            ->when($query, function ($q) use ($query) {
                $q->where('service_name', 'LIKE', '%' . $query . '%');
            })
            ->get();

        // Get results from CoachGooglesheet
        $coachResults = CoachGooglesheet::query()
            ->when($query, function ($q) use ($query) {
                $q->where('full_name', 'LIKE', '%' . $query . '%');
            })
            ->get();

        // Format results into separate arrays
        $result = [
            'services' => $serviceResults,
            'coaches' => $coachResults
        ];

        return $result;
    }


    public function SearchforDashboardWithoutQuery()
    {
        // Get results from ServiceGooglesheet
        $serviceResults = ServiceGooglesheet::get();
        // Get results from CoachGooglesheet
        $coachResults = CoachGooglesheet::get();

        // Format results into separate arrays
        $result = [
            'services' => $serviceResults,
            'coaches' => $coachResults
        ];

        return $result;
    }



    public function SearchforCoaches($query)
    {

        // Get results from CoachGooglesheet
        $coachResults = CoachGooglesheet::query()
            ->when($query, function ($q) use ($query) {
                $q->where('full_name', 'LIKE', '%' . $query . '%');
            })
            ->get();



        return $coachResults;
    }

    public function SearchforCoachesWithOutQuery()
    {

        // Get results from CoachGooglesheet
        $coachResults = CoachGooglesheet::get();



        return $coachResults;
    }
    

    public function SearchforServices($query)
    {

        // Get results from CoachGooglesheet
        $serviceResults = ServiceGooglesheet::query()
            ->when($query, function ($q) use ($query) {
                $q->where('service_name', 'LIKE', '%' . $query . '%');
            })
            ->get();
            

        return $serviceResults;
    }

    public function SearchforServicesWithoutQuery()
    {

        // Get results from CoachGooglesheet
        $serviceResults = ServiceGooglesheet::get();
            

        return $serviceResults;
    }
}
