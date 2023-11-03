<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable =['name','city_id','address','nit','max_rooms','total_rooms_created','state','user_create','user_update'];
   
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
}
