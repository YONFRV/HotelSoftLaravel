<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\IHotelService;
use App\Models\Hotel;
use App\Models\Room;
use App\Util\UtilResponse;



class HotelService implements IHotelService
{
    protected $util;

    public function __construct(UtilResponse $util)
    {
        $this->util = $util;
    }

    public function allHotels(){
        $hotel = Hotel::where('state', 1)->get();
        return response()->json($hotel);
        }

    public function byHotelProcess(Hotel $hotel){
        return response()->json(['status'=>true,'data'=>$hotel]);
    }

    public function allHotelProcess(){
        $perPage = 10;
        $Hotel = Hotel::with('city')->paginate($perPage);
        return response()->json($Hotel);
    }

    public function createHotelProcess($request){
        $validator = $this->validateHotelRequest($request);

        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        if ($this->isHotel($request->input('name'),$request->input('nit'))) {
            $process = 'Hotel  with this type'; 
            return $this->util->responseDuplicate($process);
        }
        $user = Auth::user();
        $typeRoom = $this->createHotelInstance($request, $user);
        $typeRoom->save();
        return  $this->util->responseOk('Hotel create',$typeRoom);
    }

    public function updateHotelProcess($request, Hotel $hotelData){
        $validator = $this->validateHotelRequest($request);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        if($hotelData->name != $request->name ){
            if ($this->isHotel($request->input('name'),$request->input('nit'))) {
                $process = 'Hotel  with this name'; 
                return $this->util->responseDuplicate($process);
            }
        }
        if($hotelData->total_rooms_created > $request->max_rooms ){
            return $this->util->responseFail("You cannot edit Max_Room because they are being used, you must delete room to be able to reduce the number of rooms,");
        }
        $user = Auth::user();
        $hotelData->user_update = $user->id;
        $hotelData->update($request->input());
        return  $this->util->responseOk('Hotel update',$hotelData);
    }

    public function deleteHotelProcess(Hotel $Hotel){
        $hotelResult = Room::where('hotel_id', $Hotel->id)->get();
        if($hotelResult->isEmpty()){
            $Hotel -> delete();
            return  $this->util->responseOk('Hotel deleted',$hotelResult);
        }
        else{
            return $this->util->responseFail("Hotel type is being used in room configuration");
        }
    }

    private function validateHotelRequest($request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'city_id' => 'required|numeric',
            'address' => 'required|string|min:1|max:100',
            'nit' => 'required|string|min:1|max:20',
            'max_rooms' => 'required|integer',
            'state' => 'required|boolean'
           ];
        return \Validator::make($request->input(), $rules);
    }

    private function createHotelInstance($request, $user)
    {
        $hotel = new Hotel([
            'name' => $request->input('name'),
            'city_id' => $request->input('city_id'),
            'address' => $request->input('address'),
            'nit' => $request->input('nit'),
            'max_rooms' => $request->input('max_rooms'),
            'state' => $request->input('state')
        ]);
        $hotel -> updated_at = null;
        $hotel -> user_create = $user->id;
        return $hotel;
    }
    
    private function isHotel($hotel,$nit)
    {
        return Hotel::where('name', $hotel)
        ->where('nit', $nit)
        ->exists();
    }
}