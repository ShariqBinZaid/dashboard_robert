<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanicSettings extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'panic_settings';
    public function phoneNumbers()
    {
        return $this->hasMany(PanicSettingsPhones::class, 'panic_settings_id', 'id');
    }

}
