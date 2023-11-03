<?php

namespace App\Interfaces;
use App\Models\Hotel;

interface IHotelService
{
    public function createHotelProcess($request);
    public function allHotelProcess();
    public function byHotelProcess(Hotel $hotel);
    public function updateHotelProcess($request,Hotel $hotel);
    public function deleteHotelProcess(Hotel $Hotel);
    public function allHotels();
}