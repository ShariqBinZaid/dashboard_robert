<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeTextSettingsLogs extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function FakeTextSetting()
    {
        return $this->hasMany(FakeTextSettings::class, 'id', 'fake_text_setting_id');
    }
}
