<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppUser extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function machines(): HasMany
    {
        return $this->hasMany(AppUserMac::class, 'app_user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AppUserLog::class, 'app_user_id');
    }
}
