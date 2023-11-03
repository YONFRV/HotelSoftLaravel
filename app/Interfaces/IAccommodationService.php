<?php

namespace App\Interfaces;
use App\Models\Accommodation;

interface IAccommodationService
{
    public function allAccommodationProcess();
    public function createAccommodationProcess($request);
    public function updateAccommodationProcess($request,$accommodationData);
    public function deleteAccommodationProcess(Accommodation $accommodation);
    public function allAccommodation();
}