<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ["subject","description","status_id","customer_id","user_id","queue_id"];
    //protected $with = ['status','customer','user'];

    public function scopeFilter($query,$filter){
        $query->where($filter['search'] ?? false,function($query,$search){
            $query->where(function($query) use ($search){
                $query->where("id","LIKE",'%'.$search.'%');
            });
        });
    }

    public function status(){
        return $this->belongsTo(Status::class,'status_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function queue(){
        return $this->belongsTo(Queue::class);
    }

}
