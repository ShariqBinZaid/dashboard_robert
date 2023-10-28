<?php

namespace App\Http\Controllers;

use App\Models\PanicSettings;
use App\Models\PanicSettingsPhones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PanicSettingsController extends Controller
{
    public function store(Request $req)
    {
        try {
            $input = $req->all();

            $validator = Validator::make($input, [
                'message' => 'required',
            ]);

            // dd($input);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);
            $input += ['user_id' => Auth::user()->id];

            if (@$input['id']) {
                $panic = PanicSettings::where("id", $input['id'])->update($input);
                $paniclog = PanicSettingsPhones::where("id", $input['id'])->updated([
                    'panic_settings_id' => $panic->id,
                    'phone' => $input['phone'],
                ]);
                return response()->json(['success' => true, 'msg' => 'Panic Settings Updated Successfully.']);
            } else {
                $panic = PanicSettings::create($input);

                foreach ($input['phones'] as $phone) {
                    PanicSettingsPhones::create([
                        'panic_settings_id' => $panic->id,
                        'phone' => $phone,
                    ]);
                }

                return response()->json(['success' => true, 'msg' => 'Panic Settings Created Successfully', 'data' => PanicSettings::with('User')->where('id', $panic->id)->get()]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // public function store(Request $req)
    // {
    //     try {
    //         $input = $req->all();

    //         $validator = Validator::make($input, [
    //             'message' => 'required',
    //             'phone' => 'required|array', // Assuming 'phones' is an array of phone numbers
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'error' => $validator->errors()]);
    //         }

    //         unset($input['_token']);
    //         $input['user_id'] = Auth::user()->id;

    //         if (@$input['id']) {
    //             $panic = PanicSettings::where("id", $input['id'])->update($input);

    //             // Assuming 'phones' is an array of phone numbers
    //             $phones = $input['phones'];
    //             PanicSettingsPhones::where('panic_setting_id', $panic->id)->delete(); // Delete existing phones
    //             foreach ($phones as $phone) {
    //                 PanicSettingsPhones::create([
    //                     'panic_setting_id' => $panic->id,
    //                     'phone' => $phone,
    //                 ]);
    //             }

    //             return response()->json(['success' => true, 'msg' => 'Panic Settings Updated Successfully.']);
    //         } else {
    //             $panic = PanicSettings::create($input);

    //             // Assuming 'phones' is an array of phone numbers
    //             $phones = $input['phones'];
    //             foreach ($phones as $phone) {
    //                 PanicSettingsPhones::create([
    //                     'panic_setting_id' => $panic->id,
    //                     'phone' => $phone,
    //                 ]);
    //             }

    //             return response()->json(['success' => true, 'msg' => 'Panic Settings Created Successfully', 'data' => PanicSettings::with('User')->where('id', $panic->id)->get()]);
    //         }
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }


    public function getpanic()
    {
        $getpanic = PanicSettings::with('User')->get();
        return response()->json(['success' => true, 'data' => $getpanic]);
    }
}
