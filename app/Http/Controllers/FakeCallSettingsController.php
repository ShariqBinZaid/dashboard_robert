<?php

namespace App\Http\Controllers;

use App\Models\FakeCallSettings;
use App\Models\FakeCallSettingsLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FakeCallSettingsController extends Controller
{
    public function update(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'phone' => 'required'
            ]);
            //get fake text settings
            $settings = FakeCallSettings::where('user_id', Auth::id())->first();
            if ($settings) {
                $settings->name = $request->name;
                $settings->phone = $request->phone;
                $settings->save();
            } else {
                $settings = new FakeCallSettings();
                $settings->user_id = Auth::id();
                $settings->name = $request->name;
                $settings->phone = $request->phone;
                $settings->save();
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
