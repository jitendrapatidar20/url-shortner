<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\User;

class BlockUser extends Model
{
    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'permanent_block'
    ];
     
}


