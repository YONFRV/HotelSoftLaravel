<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRoom extends Model
{
    use HasFactory;
    protected $fillable =['type','state','user_create','user_update'];
    //protected $fillable =['type','state','accommodationId','UserCreate','UserUpdate'];

   /* public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodationId', 'id');
    }*/
}
