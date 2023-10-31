<?php

namespace App\Http\Controllers;

use App\Http\Resources\FakeTextSettingsResource;
use App\Services\FirebaseService;
use App\Services\TextInboxService;
use Illuminate\Http\Request;
use App\Models\FakeTextSettings;
use Illuminate\Support\Facades\Auth;

class FakeTextSettingsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'message' => 'required',
            ]);
            //get fake text settings
            $settings = FakeTextSettings::where('user_id', Auth::id())->first();
            if ($settings) {
                $settings->name = $request->name;
                $settings->phone = $request->phone;
                $settings->message = $request->message;
                $settings->save();
            } else {
                $settings = new FakeTextSettings();
                $settings->user_id = Auth::id();
                $settings->name = $request->name;
                $settings->phone = $request->phone;
                $settings->message = $request->message;
                $settings->save();
            }
            return $this->sendResponse(new FakeTextSettingsResource($settings), 'Fake text settings updated successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function details()
    {
        try {
            $settings = FakeTextSettings::where('user_id', Auth::id())->firstOrFail();
            return $this->sendResponse(new FakeTextSettingsResource($settings), 'Settings retrieved successfully!');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function generateSMS(TextInboxService $inboxService)
    {
        try {
            //check for service registration
            $settings = FakeTextSettings::where('user_id', Auth::id())->first();
            if(!$settings){
                throw new \Exception('Please setup fake SMS settings!');
            }
            //Create a message for text inbox
            $message = $inboxService->store($settings);
            //Send firebase notification
            $firebaseService = new FirebaseService();
            $firebaseService->sendNotification($message->name, $message->message);
            return $this->sendResponse($message->id, 'Message sent successfully!');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}
