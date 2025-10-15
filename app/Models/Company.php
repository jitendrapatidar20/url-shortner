<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Company extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'slug'];
    
    public function users(){ return $this->hasMany(User::class); }
    public function shortUrls(){ return $this->hasMany(ShortUrl::class); }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'  
            ]
        ];
    }
}

