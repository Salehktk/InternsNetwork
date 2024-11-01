<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SearchService;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function dashboardSearch(Request $request)
    {
        $query = $request->input('key_word');
       
        if($query){

            $results = $this->searchService->SearchforDashboard($query);
            return response()->json([
                'message' => 'success',
                'results' => $results,
            ]);
        }
        return response()->json([
            'message' => 'enter any keyword',
        ]);
       
    }

    public function CoachesSearch(Request $request)
    {
        $query = $request->input('key_word');
       
        if($query){
        $results = $this->searchService->SearchforCoaches($query);


        return response()->json([
            'message' => 'success',
            'results' => $results,
        ]);
    }

    return response()->json([
        'message' => 'enter any keyword',
    ]);
    }

    public function ServicesSearch(Request $request)
    {
        $query = $request->input('key_word');
       
        if($query){
        $results = $this->searchService->SearchforServices($query);


        return response()->json([
            'message' => 'success',
            'results' => $results,
        ]);
    }

    return response()->json([
        'message' => 'enter any keyword',
    ]);

    }
}
