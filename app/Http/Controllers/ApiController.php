<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'user_type' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $users  = User::where('email', $request['email'])->get();
        if ($users->count() > 0) {
            return response()->json(['success' => false, 'msg' => 'Email Already Exist']);
            die;
        }
        if ($request->file('display_picture')) {

            unset($input['display_picture']);
            $input += ['display_picture' => $this->updateprofile($request, 'display_picture', 'profileimage')];
        }
        // return $input;
        $input['password'] = bcrypt($input['password']);
        $input += ['otp' => rand(100000, 999999)];
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user;

        return $this->sendResponse($success, 'User Registered Successfully.');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            // $success['email'] =  $user->email;
            $success['user'] =  $user;
            return $this->sendResponse($success, 'User Login Successfully.');
        } else {
            return $this->sendResponse('Unauthorised.', ['error' => 'Email or Password Incorrect']);
            // return $this->sendError('Unauthorised.', ['error' => 'Incorrect ID Password']);
        }
    }

    public function registerdelete(Request $req, $id)
    {
        $email = $req->input('email');
        $password = $req->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'msg' => 'User not found'], 404);
        }

        if (password_verify($password, $user->password)) {
            $user->delete();

            return response()->json(['success' => true, 'msg' => 'User Deleted Successfully']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Email or Password is Incorrect'], 401);
        }
    }

    public function updateregister(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'display_picture' => 'required',
            // 'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            // 'gender' => 'required',
            // 'email' => 'required',
            // 'dob' => 'required',
            'phone' => 'required',
            // 'status' => 'required',
            // 'is_active' => 'required',
            // 'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->file('display_picture')) {
            unset($input['display_picture']);
            $input += ['display_picture' => $this->updateprofile($req, 'display_picture', 'profileimage')];
        }

        unset($input['_token']);
        if (@$input['id']) {
            $userupdate = User::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.', 'data' => User::where('id', $input['id'])->first()]);
        } else {
            $userupdate = User::create($input);
            return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
        }
    }

    public function changepassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'current_password' => 'required'
            ]);
            $user = User::find(Auth::id());
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return $this->sendResponse($user, 'Password changed successfully!');
            } else {
                return $this->sendError('Current password mismatch!');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function userupdate(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'user_type' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }
        unset($input['_token']);
        if (@$input['id']) {
            $userupdate = User::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.']);
        } else {
            $userupdate = User::create($input);
            return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
        }
    }

    public function phoneotp(Request $req)
    {
        $otp = User::where('id', $req->user_id)->where('otp', $req->otp)->first();
        if (!empty($otp)) {
            return response()->json(['success' => true, 'msg' => 'Success']);
        }
        return response()->json(['success' => false, 'msg' => 'Please enter valid otp code']);
    }

    public function generateotp(Request $req)
    {
        $otp = rand(1000, 9999);
        $user = User::where('id', $req->user_id)->update(['otp' => $otp, 'phone' => $req->phone]);
        return response()->json(['success' => true, 'msg' => 'OTP Genrated', 'data' => $otp]);
    }

    public function vendordashboard()
    {
        $booking = Bookings::count();
        $currentDateTime = Carbon::now();
        $upcomingbookings = Bookings::where('datetime', '>', $currentDateTime)->count();
        $pastBooking =  Bookings::where('datetime', '<', $currentDateTime)->get();
        $pastTime = 0;
        if ($pastBooking->count() > 0) {
            foreach ($pastBooking as $key => $pb) {
                $pastTime += $pb->duration;
            }
        }

        $duration = $pastTime;
        $hours    = (int)($duration / 60);
        $minutes  = $duration - ($hours * 60);

        date_default_timezone_set('UTC');
        $date = new DateTime($hours . ":" . $minutes);
        //  echo $date->format('H:i:s');
        // dd($date->format('H:i:s'));
        return response()->json(['success' => true, 'msg' => 'Dashboard Data:', 'booking' => $booking, 'upcomingbookings' => $upcomingbookings, 'totaltime' => $date->format('H:i:s')]);
    }

    public function searchUser(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];
        $search = User::where('first_name', 'LIKE', "%$ser%")->orWhere('last_name', 'LIKE', "%$ser%")->get();
        // $search = DB::select("SELECT * FROM users WHERE first_name LIKE '" . $input['search'] . "%' OR last_name LIKE  '" . $input['search'] . "%' ");
        // dd($search);
        return $search;
    }

    public function search(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];

        $rentalResults = Rentals::with('Images')->where('title', 'LIKE', "%$ser%")->orWhere('desc', 'LIKE', "%$ser%")->get();
        $tourResults = Tours::with('Images')->where('title', 'LIKE', "%$ser%")->orWhere('desc', 'LIKE', "%$ser%")->get();

        // $searchResults['rentals'] = $rentalResults;
        // $searchResults['tours'] = $tourResults;

        $searchResults = [
            'search' => array_merge($rentalResults->toArray(), $tourResults->toArray()),
        ];

        return response()->json(['success' => true, 'data' => $searchResults]);
    }

    public function searchLoc(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];

        $rentalResults = Rentals::with('User')->where('locations', 'LIKE', "%$ser%")->get();
        $tourResults = Tours::where('loc', 'LIKE', "%$ser%")->get();

        // $searchLoc['rentals'] = $rentalResults;
        // $searchLoc['tours'] = $tourResults;

        $searchLoc = [
            'searchLoc' => array_merge($rentalResults->toArray(), $tourResults->toArray()),
        ];

        return $searchLoc;
    }
}
