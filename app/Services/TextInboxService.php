<?php

namespace App\Services;

use App\Models\TextInbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class TextInboxService{
    public function store($settings){
        try {
            $message = new TextInbox();
            $message->user_id = Auth::id();
            $message->name = $settings->name;
            $message->phone = $settings->phone;
            $message->message = $settings->message;
            $message->save();
            return $message;
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function inbox(){
        try{
            $inbox = TextInbox::select('*', DB::raw('COUNT(id) As total_messages'))->where('user_id', Auth::id())->groupBy('name')->latest('created_at')->get();
            return $inbox;
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function threads($name){
        try{
            return TextInbox::where('user_id', Auth::id())->where('name', $name)->latest('created_at')->get();
        } catch (\Exception $e){
            throw $e;
        }
    }
}
