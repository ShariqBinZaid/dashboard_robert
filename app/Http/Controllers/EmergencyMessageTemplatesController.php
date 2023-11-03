<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmergencyMessageTemplatesResource;
use App\Models\EmergencyMessageTemplates;
use Illuminate\Http\Request;

class EmergencyMessageTemplatesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'message' => 'required'
            ]);

            $template = new EmergencyMessageTemplates();
            $template->name = $request->name;
            $template->message = $request->message;
            $template->save();
            return $this->sendResponse($template, 'Templalete Created successfully!');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function list()
    {
        try {
            $list = EmergencyMessageTemplates::all();
            return $this->sendResponse(EmergencyMessageTemplatesResource::collection($list), 'List retrieved successfully!');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function details($id)
    {
        try {
            $details = EmergencyMessageTemplates::findOrFail($id);
            return $this->sendResponse(new EmergencyMessageTemplatesResource($details), 'Details retrieved successfully!');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            EmergencyMessageTemplates::findOrFail($id)->delete();
            return $this->sendResponse([], 'Emergency message template deleted successfully!');
        } catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}
