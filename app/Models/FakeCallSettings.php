<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeCallSettings extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
