<?php

namespace App\Http\Controllers;

use App\Models\FakeTextSettings;
use Illuminate\Http\Request;
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
            if (@$input['id']) {
                $faketext = FakeTextSettings::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'Fake Text Settings Updated Successfully.']);
            } else {
                $faketext = FakeTextSettings::create($input);
                return response()->json(['success' => true, 'msg' => 'Fake Text Settings Created Successfully', 'data' => FakeTextSettings::with('User', 'Category')->where('id', $faketext->id)->get()]);
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
