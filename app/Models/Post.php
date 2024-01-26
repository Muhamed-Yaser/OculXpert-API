<?php

namespace App\Models;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user() {
        return $this->belongsTo(User::class,'user_id' ,'id');
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class,'doctor_id' ,'id');
    }

}
