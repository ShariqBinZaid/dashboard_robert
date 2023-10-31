<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TextInboxResource;
use App\Http\Resources\TextThreadsResource;
use App\Services\TextInboxService;
use Illuminate\Http\Request;

class TextInboxController extends Controller
{
    public function loadInbox(TextInboxService $inboxService){
        try {
            $inbox = $inboxService->inbox();
            return $this->sendResponse(TextInboxResource::collection($inbox), 'Inbox retrieved successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function loadThreads(TextInboxService $inboxService, $name){
        try {
            $threads = $inboxService->threads($name);
            return $this->sendResponse(TextThreadsResource::collection($threads), 'Threads retrieved successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
