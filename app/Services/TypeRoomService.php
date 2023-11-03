<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ITypeRoomService;
use App\Models\Accommodation;
use App\Util\UtilResponse;
use App\Models\TypeRoom;
use App\Models\Room;




class TypeRoomService implements ITypeRoomService
{
    protected $util;

    public function __construct(UtilResponse $util)
    {
        $this->util = $util;
    }
    public function byTypeRoomProcess( $typeroom){
        return response()->json(['status'=>true,'data'=>$typeroom]);
    }

    public function allTypeRoom(){
        $typeroom = TypeRoom::where('state', 1)->get();
        return response()->json($typeroom);
        }

    public function allTypeRoomProcess(){
        $perPage = 10;
        $typeroom = TypeRoom::all();
        $typeRoomsPaginated = TypeRoom::paginate($perPage);
        return response()->json($typeRoomsPaginated);
        }

    public function createTypeRoomProcess($request){
        $validator = $this->validateTypeRoomRequest($request);

        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        if ($this->isTypeRoom($request->input('type'))) {
            $process = 'Type Romm with this type'; 
            return $this->util->responseDuplicate($process);
        }
        $user = Auth::user();
        $typeRoom = $this->createTypeRoomInstance($request, $user);
        $typeRoom->save();
        return  $this->util->responseOk('Type Room create',$typeRoom);
    }

    public function updateTypeRoomProcess($request,TypeRoom $typeRoomData){
        $validator = $this->validateTypeRoomRequest($request);
        if ($validator->fails()) {
            return $this->util->responseFail($validator->errors()->all());
        }
        $user = Auth::user();
        $typeRoomData->user_update = $user->id;
        $typeRoomData->update($request->input());
        return  $this->util->responseOk('Type Room update',$typeRoomData);
    }

    public function deleteTypeRoomProcess(TypeRoom $typeRoomData){
        $rooms = Room::where('typeRoom_id', $typeRoomData->id)->get();
        if($rooms->isEmpty()){
            $typeRoomData -> delete();
            return  $this->util->responseOk('Type Room deleted',$typeRoomData);
        }
        else{
            return $this->util->responseFail("The room type is being used in the room configuration");
        }
    }

    private function validateTypeRoomRequest($request)
    {
        $rules = [
            'type' => 'required|string|min:1|max:100',
            'state' => 'required|boolean'
           ];
        return \Validator::make($request->input(), $rules);
    }

    private function createTypeRoomInstance($request, $user)
    {
        $accommodationId = json_encode($request->input('accommodationId'));
        $typeRoom = new TypeRoom([
            'type' => $request->input('type'),
            'state' => $request->input('state')
        ]);
        $typeRoom -> updated_at = null;
        $typeRoom -> user_create = $user->id;
        return $typeRoom;
    }
    
    private function isTypeRoom($typeRoom)
    {
        return TypeRoom::where('type', $typeRoom)->exists();
    }
}