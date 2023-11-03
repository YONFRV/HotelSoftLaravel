<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable =['amount','typeRoom_id','accommodation_id','hotel_id','state','user_create','user_update'];
    public function TypeRoom()
    {
        return $this->belongsTo(TypeRoom::class, 'typeRoom_id');
    }
    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
