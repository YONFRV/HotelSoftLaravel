<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Interfaces\IHotelService;

class HotelController extends Controller
{

    protected $hotelService;

    public function __construct(IHotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $response = $this->hotelService->allHotelProcess(); 
        return  $response ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->hotelService->createHotelProcess($request); 
        return  $response ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $response = $this->hotelService->byHotelProcess($hotel); 
        return  $response ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $response = $this->hotelService->updateHotelProcess($request,$hotel); 
        return  $response ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $response = $this->hotelService->deleteHotelProcess($hotel); 
        return  $response ;
    }

    public function allHotels()
    {
        $response = $this->hotelService->allHotels(); 
        return  $response;
    }
}
