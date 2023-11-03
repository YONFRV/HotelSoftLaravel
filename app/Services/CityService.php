<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ICityService;
use App\Models\Accommodation;
use App\Util\UtilResponse;
use App\Models\Hotel;
use App\Models\City;




class CityService implements ICityService
{
    protected $util;

    public function __construct(UtilResponse $util)
    {
        $this->util = $util;
    }
    public function byCityProcess( $city){
        return response()->json(['status'=>true,'data'=>$city]);
    }

    public function allCity(){
        $city = City::where('state', 1)->get();
        return response()->json($city); 
        }

    public function allCityProcess(){
        $perPage = 10;
        $city = City::all();
        $cityPaginated = City::paginate($perPage);
        return response()->json($cityPaginated);
        }

    public function createCityProcess($request){
        $validator = $this->validateCityRequest($request);

        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        if ($this->isCity($request->input('name'))) {
            $process = 'City with this name'; 
            return $this->util->responseDuplicate($process);
        }
        $user = Auth::user();
        $city = $this->createCityInstance($request, $user);
        $city->save();
        return  $this->util->responseOk('City create',$city);
    }

    public function updateCityProcess($request,City $city){
        $validator = $this->validateCityRequest($request);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        $user = Auth::user();
        $city->user_update = $user->id;
        $city->update($request->input());
        return  $this->util->responseOk('City update',$city);
    }

    public function deleteCityProcess(City $city){
        $rooms = Hotel::where('city_id', $city->id)->get();
        if($rooms->isEmpty()){
            $city -> delete();
            return  $this->util->responseOk('City deleted',$city);
        }
        else{
            return $this->util->responseFail("City is being used in the hotel");
        }
    }

    private function validateCityRequest($request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'state' => 'required|boolean'
           ];
        return \Validator::make($request->input(), $rules);
    }

    private function createCityInstance($request, $user)
    {
        $city = new City([
            'name' => $request->input('name'),
            'state' => $request->input('state')
        ]);
        $city -> updated_at = null;
        $city -> user_create = $user->id;
        return $city;
    }
    
    private function isCity($city)
    {
        return City::where('name', $city)->exists();
    }
}