<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\IAccommodationService;
use App\Services\AccommodationService;
use App\Interfaces\IAuthService;
use App\Services\AuthService;
use App\Interfaces\ITypeRoomService;
use App\Services\TypeRoomService;
use App\Interfaces\IHotelService;
use App\Services\HotelService;
use App\Interfaces\IRoomsService;
use App\Services\RoomsService;
use App\Interfaces\ICityService;
use App\Services\CityService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
           $this->app->bind(IAccommodationService::class, AccommodationService::class);
           $this->app->bind(IAuthService::class, AuthService::class);
           $this->app->bind(ITypeRoomService::class, TypeRoomService::class);
           $this->app->bind(IHotelService::class, HotelService::class);
           $this->app->bind(IRoomsService::class, RoomsService::class);
           $this->app->bind(ICityService::class, CityService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('numeric_array', function ($attribute, $value, $parameters, $validator) {
            if (!is_array($value)) {
                return false;
            }
            foreach ($value as $item) {
                if (!is_numeric($item)) {
                    return false;
                }
            }
            return true;
        });
    }
}
