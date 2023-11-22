<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmergencyMessageSchedulesResource;
use App\Http\Resources\EmergencyMessageSettingsResource;
use App\Models\EmergencyMessageSchedules;
use App\Models\EmergencySettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyMessageSettingsController extends Controller
{
    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'message' => 'required',
            ]);
            //get fake text settings
            $settings = EmergencySettings::where('user_id', Auth::id())->first();
            if ($settings) {
                $settings->name = $request->name;
                $settings->phone = $request->phone;
                $settings->message = $request->message;
                $settings->save();
            } else {
                $settings = new EmergencySettings();
                $settings->user_id = Auth::id();
                $settings->name = $request->name;
                $settings->phone = $request->phone;
                $settings->message = $request->message;
                $settings->save();
            }
            return $this->sendResponse(new EmergencyMessageSettingsResource($settings), 'Emergency message settings updated successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function toggleService()
    {
        try {
            $settings = EmergencySettings::where('user_id', Auth::id())->first();
            if (!$settings) {
                throw new \Exception('First save settings, then add time schedules!');
            }
            $settings->is_active = $settings->is_active == 0 ? 1 : 0;
            $settings->save();
            return $this->sendResponse(['is_active' => $settings->is_active], 'Toggle Successful!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function details()
    {
        try {
            $settings = EmergencySettings::where('user_id', Auth::id())->with('schedules')->first();
            if (!$settings) {
                throw new \Exception('First save settings, then add time schedules!');
            }
            return $this->sendResponse(new EmergencyMessageSettingsResource($settings), 'Settings retrieved successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function addSchedule(Request $request)
    {
        try {
            $request->validate([
                'schedule_time' => 'required'
            ]);
            $settings = EmergencySettings::where('user_id', Auth::id())->first();
            if (!$settings) {
                throw new \Exception('First save settings, then add time schedules!');
            }
            $schedule = new EmergencyMessageSchedules();
            $schedule->emergency_settings_id = $settings->id;
            $schedule->schedule_time = Carbon::parse($request->schedule_time)->format('Y-m-d H:i:s');
            $schedule->is_repeat = $request->is_repeat;
            $schedule->ringtone = $request->ringtone;
            $schedule->can_vibrate = $request->can_vibrate;
            $schedule->save();
            return $this->sendResponse(new EmergencyMessageSchedulesResource($schedule), 'Schedule added successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function toggleRepeatSchedule($id)
    {
        try {
            $schedule = EmergencyMessageSchedules::find($id);
            if (!$schedule) {
                throw new \Exception('Schedule not found!');
            }
            $schedule->is_repeat = $schedule->is_repeat == 1 ? 0 : 1;
            $schedule->save();
            return $this->sendResponse(['is_repeat' => $schedule->is_repeat], 'Toggle successful!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
