<?php

namespace App\Interfaces;
use App\Models\TypeRoom;

interface ITypeRoomService
{
    public function createTypeRoomProcess($request);
    public function allTypeRoomProcess();
    public function byTypeRoomProcess($typeroom);
    public function updateTypeRoomProcess($request,TypeRoom $typeRoomData);
    public function deleteTypeRoomProcess(TypeRoom $typeRoomData);
    public function allTypeRoom();
}