<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceGooglesheet;

class Services
{

    public $_model;

    public function __construct(ServiceGooglesheet $ServiceGooglesheet)
    {
        $this->_model = $ServiceGooglesheet;
    }

    public function getServices()
    {
        $AllServices = $this->_model->get();
        return $AllServices;
    }

}