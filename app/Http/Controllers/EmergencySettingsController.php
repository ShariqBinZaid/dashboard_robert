<?php

namespace App\Http\Controllers;

use App\Models\EmergencySettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmergencySettingsController extends Controller
{
    public function store(Request $req)
    {
        try {
            $input = $req->all();

            $validator = Validator::make($input, [
                'name' => 'required',
            ]);

            // dd($input);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);
            if (@$input['id']) {
                $emergency = EmergencySettings::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'Emergency Settings Updated Successfully.']);
            } else {
                $emergency = EmergencySettings::create($input);
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
