<?php

namespace App\Interfaces;
use App\Models\Room;

interface IRoomsService
{
    public function createRoomProcess($request);
    public function allRoomProcess();
    public function byRoomProcess($Room);
    public function updateRoomProcess($request, Room $Room);
    public function deleteRoomProcess(Room $room);
    public function updateRoomAmountProcess($id, $request);
    public function getRoomsByHotelId($hotelId);
}