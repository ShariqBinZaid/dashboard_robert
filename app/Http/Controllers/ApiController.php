<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginUserResource;
use App\Mail\VerifyOTP;
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
        try {
            $request->validate([
                'name' => 'required',
                'gender' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'dob' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            $display_picture = null;
            if ($request->file('display_picture')) {
                $display_picture = $this->updateprofile($request, 'display_picture', 'profileimage');
            }
            $otp = rand('1000', '9999');
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'password' => Hash::make($request->password),
                'display_picture' => $display_picture,
                'otp' => $otp,
                'is_active' => 0,
                'user_type' => 'user'
            ]);
            Mail::to($user->email)->send(new VerifyOTP($user));
            return $this->sendResponse(['id' => $user->id], 'User Registered Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function verify(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|numeric',
                'otp' => 'required|numeric'
            ]);
            $user = User::where('id', $request->id)->where('otp', $request->otp)->first();
            if (!$user) {
                throw new \Exception('Invalid OTP!');
            }
            if ($user->is_active == 1) {
                throw new \Exception('OTP already used to verify account!');
            }
            $user->is_active = 1;
            $user->save();
            $token = $user->createToken('MyApp')->accessToken;
            Auth::login($user);
            return $this->sendResponse(new LoginUserResource(Auth::user()), 'User verified successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function registerupdate(Request $req)
    {
        try {
            $input = $req->all();
//            $validator = Validator::make($input, [
//                'email' => 'required',
//                // Add validation for the password field
//                // 'password' => 'required',
//                // 'confirm_password' => 'required|same:password', // Add validation for the confirm_password field
//            ]);
//
//            if ($validator->fails()) {
//                return response()->json(['success' => false, 'error' => $validator->errors()]);
//            }

            if (array_key_exists('password', $input)) {
                $input['password'] = bcrypt($input['password']);
            }

            if (array_key_exists('confirm_password', $input)) {
                $input['confirm_password'] = bcrypt($input['confirm_password']);
            }

            if ($req->file('display_picture')) {
                unset($input['display_picture']);
                $input += ['display_picture' => $this->updateprofile($req, 'display_picture', 'profileimage')];
            }

            // Remove sensitive data from the input array
            unset($input['_token'], $input['password'], $input['confirm_password']);

            $userupdate = User::where("id", Auth::id())->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.', 'data' => User::where('id', $input['id'])->first()]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            //Verify credentials
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new \Exception('Invalid Credentials!');
            }
            //Check user type
            if (Auth::user()->user_type != 'user') {
                throw new \Exception('Invalid user type');
            }
            //Check if user is verified
            if (Auth::user()->is_active == 0) {
                throw new \Exception('Please verify your account');
            }
            return $this->sendResponse(new LoginUserResource(Auth::user()), 'User logged in successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
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

    public function fcmid(Request $request)
    {
        try {
            $request->validate([
                'fcm_id' => 'required'
            ]);
            $user = Auth::user();
            $user->fcm_id = $request->fcm_id;
            $user->save();
            return $this->sendResponse([], 'FCM ID Updated!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
