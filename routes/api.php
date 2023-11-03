<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\TypeRoomController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('auth/login', [AuthController::class,'login']);
Route::get('typeroomssl', [TypeRoomController::class,'index']);
Route::get('accommodationssl', [AccommodationController::class,'index']);
Route::get('cityssl', [CityController::class,'index']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::patch('auth/update-user', [AuthController::class,'updateData']);
    Route::post('auth/by-user', [AuthController::class,'byData']);
    Route::resource('accommodations', AccommodationController::class);
    Route::get('accommodations-all', [AccommodationController::class,'allAccommodation']);
    Route::resource('typerooms', TypeRoomController::class);
    Route::get('typerooms-all', [TypeRoomController::class,'allTypeRooms']);
    Route::resource('citys', CityController::class);
    Route::get('citys-all', [CityController::class,'allCity']);
    Route::resource('hotels', HotelController::class);
    Route::get('hotel-all', [HotelController::class,'allHotels']);
    Route::resource('rooms', RoomController::class);
    Route::get('rooms-by-hotel/{id}', [RoomController::class,'getRoomsByHotelId']);
    Route::put('rooms-amount/{id}', [RoomController::class,'updateAmount']);
    Route::get('auth/logout', [AuthController::class,'logout']);
    Route::post('auth/register', [AuthController::class,'create']);
});
 