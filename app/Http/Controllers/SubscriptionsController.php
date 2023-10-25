<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SubscriptionsResource;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscriptions::all();

        return view('subscriptions.index', compact(['subscriptions']));
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $subscriptions = Subscriptions::get();
        return new SubscriptionsResource($subscriptions);
    }

    public function store(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'desc' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);
        if (@$input['id']) {
            $subscriptions = Subscriptions::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Subscriptions Updated Successfully.']);
        } else {
            $subscriptions = Subscriptions::create($input);
            return response()->json(['success' => true, 'msg' => 'Subscriptions Created Successfully']);
        }
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $subscriptions = Subscriptions::all();
            return new SubscriptionsResource($subscriptions);
        } else {
            $subscriptions = Subscriptions::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $subscriptions]);
        }
    }

    public function destroy(Request $req, $id)
    {
        Subscriptions::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Subscriptions Deleted Successfully']);
    }
}
