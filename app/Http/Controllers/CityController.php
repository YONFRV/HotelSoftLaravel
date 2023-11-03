<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Interfaces\ICityService;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(ICityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index()
    {
      $response = $this->cityService->allCityProcess(); 
      return  $response ;
    }

    public function store(Request $request)
    {
        $response = $this->cityService->createCityProcess($request); 
        return  $response ;
    }

    public function show(City $city)
    {
        $response = $this->cityService->byCityProcess($city); 
        return  $response ;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $response = $this->cityService->updateCityProcess($request, $city); 
        return  $response ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $response = $this->cityService->deleteCityProcess($city); 
        return  $response;
    }
    public function allCity()
    {
        $response = $this->cityService->allCity(); 
        return  $response;
    }
}
