<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\IRoomsService;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\TypeRoom;
use App\Models\Accommodation;
use App\Util\UtilResponse;

class RoomsService implements IRoomsService
{
    protected $util;
    protected $message;

    public function __construct(UtilResponse $util)
    {
        $this->util = $util;
        $this->message = "Amount exceeds what was allowed to the hotel for: ";
    }

    public function byRoomProcess($room){
        return response()->json(['status'=>true,'data'=>$room]);
    }

    public function allRoomProcess(){
        $perPage = 10;
        $rooms = Room::with('hotel', 'typeRoom', 'accommodation')->paginate($perPage);
        return response()->json($rooms);
    }

    public function createRoomProcess($request){
        $validator = $this->validateRoomRequest($request);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        if ($this->isRoom($request)) {
            $process = 'Room  with this type'; 
            return $this->util->responseDuplicate($process);
        }
        $hotel = Hotel::find($request->hotel_id);
        list($maxAllowedAmount, $totalRoms) = $this->validateCantRoomsHotel(1, $request, $hotel, NULL);
        if($maxAllowedAmount >= $totalRoms){
            $user = Auth::user();
            $room = $this->createRoomInstance($request, $user);
            $room->save();
            $hotel->total_rooms_created = $totalRoms;
            $hotel->save();
            return  $this->util->responseOk('Room create',$room);
        }else{
            return $this->util->responseFail($this->message. $totalRoms-$maxAllowedAmount);
        }
    }

    public function updateRoomProcess($request, Room $room){
        $validator = $this->validateRoomRequest($request);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        if(($request->amount != $room->amount) || ($request->state != $room->state) && $this->isRoom($request)){
            return  $this->updateProcess($request,$room);
        }
        else{
            if ($this->isRoom($request)) {
                $process = 'Room '; 
                return $this->util->responseDuplicate($process);
            }
        }
    }
    private function updateProcess($request,Room $room){
        $hotel = Hotel::find($request->hotel_id);
        list($maxAllowedAmount, $RoomsAmount) = $this->validateCantRoomsHotel(2, $request, $hotel,$room);
        if($maxAllowedAmount >=$RoomsAmount){
            $user = Auth::user();
            $room->user_update = $user->id;
            $room->update($request->input());
            $hotel->total_rooms_created = $RoomsAmount;
            $hotel->save();
            return  $this->util->responseOk('Room update',$room);
        }else{
            return $this->util->responseFail($this->message. $RoomsAmount-$maxAllowedAmount );
        }
    }

    public function updateRoomAmountProcess($id, $request){
        $room = Room::find($id);
        $hotel = Hotel::find($room->hotel_id);
        $rules = [
            'amount' => 'required|numeric',
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        list($maxAllowedAmount, $RoomsAmount) = $this->validateCantRoomsHotel(2, $request, $hotel,$room);
        if($maxAllowedAmount >=$RoomsAmount){
            $user = Auth::user();
            $room->user_update = $user->id;
            $room->amount = $request->input('amount'); // Actualiza solo el campo 'amount'
            $room->save();
            $hotel->total_rooms_created = $RoomsAmount;
            $hotel->save();
            return  $this->util->responseOk('Room update',$room);
        }else{
            return $this->util->responseFail($this->message. $RoomsAmount-$maxAllowedAmount );
        }
    }

    public function deleteRoomProcess(Room $room){
        $hotel = Hotel::find($room->hotel_id);
        $room -> delete();
        $hotel->total_rooms_created -= $room->amount;
        $hotel->save();
        return  $this->util->responseOk('Room deleted',$room);
    }

    public function getRoomsByHotelId($hotelId)
    {
        $rooms = Room::where('hotel_id', $hotelId)
            ->with(['TypeRoom', 'Accommodation','Hotel'])
            ->get()
            ->groupBy('hotel_id');
            $firstHotel = $rooms->first()->first()->hotel;
        return response()->json(['hotel' => $firstHotel, 'rooms' => $rooms], 200);
    }

    private function validateRoomRequest($request)
    {
        $rules = [
            'amount' => 'required|numeric',
            'typeRoom_id' => 'required|numeric',
            'accommodation_id' => 'required|numeric',
            'hotel_id' => 'required|numeric',
            'state' => 'required|boolean'
           ];
        return \Validator::make($request->input(), $rules);
    }

    private function createRoomInstance($request, $user)
    {
        $accommodationId = json_encode($request->input('accommodationId'));
        $room = new Room([
            'amount' => $request->input('amount'),
            'typeRoom_id' => $request->input('typeRoom_id'),
            'accommodation_id' => $request->input('accommodation_id'),
            'hotel_id' => $request->input('hotel_id'),
            'state' => $request->input('state')
        ]);
        $room -> updated_at = null;
        $room -> user_create = $user->id;
        return $room;
    }
    
    private function validateCantRoomsHotel($typeProcess,$request,$hotel, $room){
        $maxAllowedAmount = $hotel->max_rooms;
        $amountRooms =  $hotel->total_rooms_created;
        if($typeProcess == 1){
            return [$maxAllowedAmount, $request->amount+$amountRooms];
        }
        else{
            return $this->resultUpdateRoom($request,$room,$hotel);
        }
    }

    private function resultUpdateRoom($request, Room $room, Hotel $hotel){
        $maxAllowedAmount = $hotel->max_rooms;
        $amountRooms =  $hotel->total_rooms_created;
        if($request->amount > $room->amount){
            return [$maxAllowedAmount, $amountRooms+($request->amount-$room->amount)];
        }
        else if($hotel->total_rooms_created==0){
            return [$maxAllowedAmount, $request->amount];
        }
        else if($request->amount < $room->amount){
            return [$maxAllowedAmount, $amountRooms-($room->amount-$request->amount)];
        }
    }

    private function isRoom($request)
    {
        return Room::where('hotel_id', $request->hotel_id)
        ->where('typeRoom_id', $request->typeRoom_id)
        ->where('accommodation_id', $request->accommodation_id)
        ->first();
    } 
}