<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\synchronization;


class synchronizationController extends Controller
{

    protected $synchronizationService;

    protected $_request;

    public function __construct(synchronization $synchronizationService, Request $request)
    {
        $this->synchronizationService = $synchronizationService;
        $this->_request = $request;

    }

    public function servicesync(){

        return $this->synchronizationService->services();   
        
    }

    public function coachesync(){

        return $this->synchronizationService->coaches();
    }
}
