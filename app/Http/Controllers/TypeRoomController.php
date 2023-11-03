<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Interfaces\ITypeRoomService;
use App\Models\TypeRoom;


class TypeRoomController extends Controller
{

    protected $typeRoomService;

    public function __construct(ITypeRoomService $typeRoomService)
    {
        $this->typeRoomService = $typeRoomService;
    }

    public function index()
    {
      $response = $this->typeRoomService->allTypeRoomProcess(); 
      return  $response ;
    }

    public function store(Request $request)
    {
        $response = $this->typeRoomService->createTypeRoomProcess($request); 
        return  $response ;
    }

    public function show(TypeRoom $typeroom)
    {
        $response = $this->typeRoomService->byTypeRoomProcess($typeroom); 
        return  $response ;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeRoom $typeroom)
    {
        $response = $this->typeRoomService->updateTypeRoomProcess($request, $typeroom); 
        return  $response ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeRoom $typeroom)
    {
        $response = $this->typeRoomService->deleteTypeRoomProcess($typeroom); 
        return  $response;
    }
    public function allTypeRooms()
    {
        $response = $this->typeRoomService->allTypeRoom(); 
        return  $response;
    }
}
