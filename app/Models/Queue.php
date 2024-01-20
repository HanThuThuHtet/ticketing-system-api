<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    public function users(){
        return $this->belongsToMany(User::class,'user_queue');
    }
}
