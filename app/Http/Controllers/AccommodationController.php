<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Interfaces\IAccommodationService;

class AccommodationController extends Controller
{
    protected $accommodationService;

    public function __construct(IAccommodationService $accommodationService)
    {
        $this->accommodationService = $accommodationService;
    }

    public function index()
    {
        $response = $this->accommodationService->allAccommodationProcess(); 
        return  $response ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->accommodationService->createAccommodationProcess($request); 
        return  $response ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Accommodation $accommodation)
    {
        return response()->json(['status'=>true,'data'=>$accommodation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accommodation $accommodation)
    {
        $response = $this->accommodationService->updateAccommodationProcess($request,$accommodation); 
        return  $response ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accommodation $accommodation)
    {
        $response = $this->accommodationService->deleteAccommodationProcess($accommodation); 
        return  $response ;
    }
    public function allAccommodation()
    {
        $response = $this->accommodationService->allAccommodation(); 
        return  $response;
    }
}
