<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ShortUrl extends Model
{
    use HasFactory;
    protected $fillable = ['short_code','original_url','created_by','company_id','access_token'];

    public function creator(){ return $this->belongsTo(User::class,'created_by'); }
    public function company(){ return $this->belongsTo(Company::class); }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisibleTo($query, User $user)
    {
    
        if ($user->isRole('SuperAdmin')) {
            return $query;
        }

        if ($user->isRole('Admin')) {
            return $query->where('company_id', $user->company_id);
        }

        if ($user->isRole('Member')) {
            return $query->where('created_by', $user->id);
        }

        // Fallback: return no results for unknown roles
        return $query->whereNull('id');
    }
}


