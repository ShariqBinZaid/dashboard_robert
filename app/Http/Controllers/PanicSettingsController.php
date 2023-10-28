<?php

namespace App\Http\Controllers;

use App\Http\Resources\PanicSettingsResource;
use App\Models\PanicSettings;
use App\Models\PanicSettingsPhones;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PanicSettingsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required',
                'phone' => 'required'
            ]);
            //Get if user has settings
            $settings = PanicSettings::where('user_id', Auth::id())->first();
            if ($settings) {
                $settings->message = $request->message;
                $settings->save();
            } else {
                $settings = new PanicSettings();
                $settings->user_id = Auth::id();
                $settings->message = $request->message;
                $settings->save();
            }
            //Update setting phone numbers
            if (!empty($request->phone) && is_array($request->phone)) {
                PanicSettingsPhones::where('panic_settings_id', $settings->id)->delete();
                $phone_nos = [];
                foreach ($request->phone as $phone) {
                    $phone_nos[] = ['phone' => $phone];
                }
                $settings->phoneNumbers()->createMany($phone_nos);
            }
            return $this->sendResponse(new PanicSettingsResource($settings), 'Panic settings updated successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getpanic()
    {
        $settings = PanicSettings::with('phoneNumbers')->first();
        return $this->sendResponse(new PanicSettingsResource($settings), 'Panic settings retrieved successfully!');
    }

    public function panicToggle(Request $request)
    {
        try {
            $request->validate([
                'lat' => 'required',
                'long' => 'required'
            ]);
            $activate = false;
            $settings = PanicSettings::where('user_id', Auth::id())->firstOrFail();
            if($settings->is_active == 0){
                $activate = true;
                $mapsLink = "https://www.google.com/maps?q=".$request->lat.",".$request->long;
                $message = $settings->message.'  '.$mapsLink;
                if(!empty($settings->phoneNumbers)){
                    $sms = new SmsService();
                    foreach ($settings->phoneNumbers as $number){
                        $sms->sendSMS($number->phone, $message);
                    }
                } else {
                    throw new \Exception('No Numbers found');
                }
                $settings->is_active = 1;
                $settings->save();
            } else {
                $settings->is_active = 0;
                $settings->save();
            }
            return $this->sendResponse(['panic_status' => $activate], 'Toggle panic button successful');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}
