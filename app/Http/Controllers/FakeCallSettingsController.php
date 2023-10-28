<?php

namespace App\Http\Controllers;

use App\Models\FakeCallSettings;
use App\Models\FakeCallSettingsLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FakeCallSettingsController extends Controller
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
                $fakecall = FakeCallSettings::where("id", $input['id'])->update($input);
                $fakecalllog = FakeCallSettingsLogs::where("id", $input['id'])->updated([
                    'fake_call_settings_id' => $fakecall->id,
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'time' => $input['time'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Fake Call Settings Updated Successfully.']);
            } else {
                $fakecall = FakeCallSettings::create($input);
                $fakecalllog = FakeCallSettingsLogs::create([
                    'fake_call_settings_id' => $fakecall->id,
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'time' => $input['time'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Fake Call Settings Created Successfully', 'data' => FakeCallSettings::with('User')->where('id', $fakecall->id)->get()]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getfakecall()
    {
        $getfakecall = FakeCallSettings::with('User')->get();
        return response()->json(['success' => true, 'data' => $getfakecall]);
    }
}
