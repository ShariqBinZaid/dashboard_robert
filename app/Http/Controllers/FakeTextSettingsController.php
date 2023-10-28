<?php

namespace App\Http\Controllers;

use App\Models\FakeTextLogs;
use Illuminate\Http\Request;
use App\Models\FakeTextSettings;
use App\Models\FakeTextSettingsLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FakeTextSettingsController extends Controller
{
    public function store(Request $req)
    {
        try {
            $input = $req->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'phone' => 'required',
                'message' => 'required',
            ]);

            // dd($input);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);
            $input += ['user_id' => Auth::user()->id];

            if (@$input['id']) {
                $faketext = FakeTextSettings::where("id", $input['id'])->update($input);
                $faketextlog = FakeTextSettingsLogs::where("id", $input['id'])->updated([
                    'fake_text_setting_id' => $faketext->id,
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'message' => $input['message'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Fake Text Settings Updated Successfully.']);
            } else {
                $faketext = FakeTextSettings::create($input);
                $faketextlog = FakeTextSettingsLogs::create([
                    'fake_text_setting_id' => $faketext->id,
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'message' => $input['message'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Fake Text Settings Created Successfully', 'data' => FakeTextSettings::with('User')->where('id', $faketext->id)->get()]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getfaketext()
    {
        $getfaketext = FakeTextSettings::with('User')->get();
        return response()->json(['success' => true, 'data' => $getfaketext]);
    }
}
