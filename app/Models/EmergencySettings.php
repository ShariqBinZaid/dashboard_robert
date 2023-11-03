<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencySettings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function schedules()
    {
        return $this->hasMany(EmergencyMessageSchedules::class);
    }
}
