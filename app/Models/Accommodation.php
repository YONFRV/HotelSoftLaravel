<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'state', 'user_create','user_update'];

   /* public function typeRooms()
    {
        return $this->hasMany(TypeRoom::class, 'accommodationId', 'id');
    }*/

}
