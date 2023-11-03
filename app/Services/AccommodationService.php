<?php
namespace App\Services;
use App\Models\Accommodation;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Util\UtilResponse;
use App\Interfaces\IAccommodationService;


class AccommodationService implements IAccommodationService
{
    protected $util;

    public function __construct(UtilResponse $util)
    {
        $this->util = $util;
    }

    public function allAccommodation(){
        $accommodation = Accommodation::where('state', 1)->get();
        return response()->json($accommodation);
        }

    public function allAccommodationProcess(){
        $perPage = 10;
        $accommodation = Accommodation::all();
        $accommodationPage = Accommodation::paginate($perPage);
        return response()->json($accommodationPage);
        }

    public function createAccommodationProcess($request)
    {
        $validator = $this->validateAccommodationRequest($request);

        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }

        if ($this->isAccommodation($request->input('name'))) {
            $process = 'Accommodation with this name'; 
            return $this->util->responseDuplicate($process);
        }
        $user = Auth::user();
        $accommodation = $this->createAccommodationInstance($request, $user);
        $accommodation->save();
        return  $this->util->responseOk('Accommodation create',$accommodation);
    }

    public function updateAccommodationProcess($request, $accommodationData){
        $validator = $this->validateAccommodationRequest($request);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        $user = Auth::user();
        $accommodationData -> user_update = $user -> id;
        $accommodationData -> update($request->input());
        return  $this->util->responseOk('Accommodation update',$accommodationData);
    }

    public function deleteAccommodationProcess(Accommodation $accommodation){
        $accommodationResult = Room::where('accommodation_id', $accommodation->id)->get();
        if($accommodationResult->isEmpty()){
            $accommodation -> delete();
            return  $this->util->responseOk('Accommodation deleted',$accommodationResult);
        }
        else{
            return $this->util->responseFail("Accommodation type is being used in room configuration");
        }
    }


    private function validateAccommodationRequest($request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'state' => 'required|boolean'
        ];
        return \Validator::make($request->input(), $rules);
    }

    private function createAccommodationInstance($request, $user)
    {
        $accommodation = new Accommodation($request->all());
        $accommodation->user_create = $user->id;
        $accommodation->updated_at = null;
        return $accommodation;
    }

    private function isAccommodation($name)
    {
        return Accommodation::where('name', $name)->exists();
    }
}