<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
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
            $categories = Categories::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Categories Updated Successfully.']);
        } else {
            $categories = Categories::create($input);
            return response()->json(['success' => true, 'msg' => 'Categories Created Successfully', 'data' => $categories]);
        }
    }

    public function getcategories()
    {
        $getcategories = Categories::get();
        return response()->json(['success' => true, 'data' => $getcategories]);
    }
}
