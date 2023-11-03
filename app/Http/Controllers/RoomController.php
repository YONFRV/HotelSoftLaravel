<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\IRoomsService;
use App\Models\Room;

class RoomController extends Controller
{

    protected $RoomService;

    public function __construct(IRoomsService $RoomService)
    {
        $this->RoomService = $RoomService;
    }

    public function index()
    {
        $response = $this->RoomService->allRoomProcess(); 
        return  $response ;
    }

    public function store(Request $request)
    {
        $response = $this->RoomService->createRoomProcess($request); 
        return  $response;
    }

    public function show(Room $room)
    {
        $response = $this->RoomService->byRoomProcess($room); 
        return  $response;
    }

    public function update(Request $request, Room $room)
    {
        $response = $this->RoomService->updateRoomProcess($request,$room); 
        return  $response;
    }

    public function destroy(Room $room)
    {
        $response = $this->RoomService->deleteRoomProcess($room); 
        return  $response;
    }

    public function updateAmount(Request $request,$id)
    {
        $response = $this->RoomService->updateRoomAmountProcess($id,$request); 
        return  $response;
    }

    public function getRoomsByHotelId($id)
    {
        $response = $this->RoomService->getRoomsByHotelId($id); 
        return  $response;
    }
}
