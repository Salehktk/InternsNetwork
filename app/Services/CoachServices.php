<?php

namespace App\Services;

use App\Models\User;
use App\Models\Api\Coach;
use App\Models\CoachGooglesheet;
use Illuminate\Support\Facades\Auth;
use Revolution\Google\Sheets\Facades\Google;

class CoachServices
{
    public $_model;
    
    public function __construct(CoachGooglesheet $CoachGooglesheet)
    {
        $this->_model = $CoachGooglesheet;
    }

    public function getCoaches()
    {
        $AllCoaches = $this->_model->get();
        
        return $AllCoaches;
    }

}