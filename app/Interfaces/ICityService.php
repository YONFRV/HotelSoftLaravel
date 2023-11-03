<?php

namespace App\Interfaces;
use App\Models\City;

interface ICityService
{
    public function createCityProcess($request);
    public function allCityProcess();
    public function byCityProcess($city);
    public function updateCityProcess($request,City $city);
    public function deleteCityProcess(City $city);
    public function allCity();
}