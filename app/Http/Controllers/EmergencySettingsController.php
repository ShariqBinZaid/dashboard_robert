<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencySettings;
use App\Models\EmergencySettingsLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmergencySettingsController extends Controller
{
    public function store(Request $req)
    {
        try {
            $input = $req->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'phone' => 'required',
                'time' => 'required',
            ]);

            // dd($input);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);
            $input += ['user_id' => Auth::user()->id];

            if (@$input['id']) {
                $emergency = EmergencySettings::where("id", $input['id'])->update($input);
                $emergencylog = EmergencySettingsLogs::where("id", $input['id'])->updated([
                    'emergency_setting_id' => $emergency->id,
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'time' => $input['time'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Emergency Settings Updated Successfully.']);
            } else {
                $emergency = EmergencySettings::create($input);
                $emergencylog = EmergencySettingsLogs::create([
                    'emergency_setting_id' => $emergency->id,
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'time' => $input['time'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Emergency Settings Created Successfully', 'data' => EmergencySettings::with('User', 'Category')->where('id', $emergency->id)->get()]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getemergency()
    {
        $getemergency = EmergencySettings::with('User', 'Category')->get();
        return response()->json(['success' => true, 'data' => $getemergency]);
    }
}
