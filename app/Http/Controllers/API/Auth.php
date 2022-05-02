<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\db;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Auth extends Controller
{
    public function Index()
    {
        $Info = User::all();
        return response()->json([
            'status' => 200,
            'user' => $Info,
        ]);
    }


    public function RegisterUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'telephone' => 'required|max:10',
            'password' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->errors(),
            ]);
        } else {
            # code...
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'role' => 0,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'username' => $user->name,
                'token' => $token,
                'role' => 0,
                'message' => 'Welcome To CornershopJa',
            ]);
        }

        // $details = [
        //     'title'=> 'Welcome To CornershopJa',  
        //     'body'=> 'Your are ready to get started. Please click on the button below to get shopping with us today!' 
        //   ];
        //   Mail::to(auth()->user()->email)->send(new SendMail($details)); //Mail is inbuilt class which allows us to send emails.
        //   return "Email Sent";
    }

    public function LoginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
            'password' => 'required|max:15|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials',
                ]);
            } else {
                if ($user->role == 1) {
                    # code...
                    $token =  $user->createToken($user->email . '_SellerToken', ['server:seller'])->plainTextToken;
                } else {
                    # code...
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                }
                

                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->telephone,
                    'token' => $token,
                    'role' => $user->role,
                    'message' => 'Welcome Back' . $user->name,
                ]);
            }
        }
    }

    public function Logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logged Out Successfully',
        ]);
    }

    public function LoginSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
            'password' => 'required|max:15|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validator_errors' => $validator->errors(),
            ]);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Credentials',
                ]);
            } else {
                if ($user->role == 1) {
                    # code...
                    $token =  $user->createToken($user->email . '_SellerToken', ['server:seller'])->plainTextToken;
                } else {
                    # code...
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                }
                

                return response()->json([
                    'status' => 200,
                    'username' => $user->name,
                    'token' => $token,
                    'role' => $user->role,
                    'message' => 'Welcome Back' . $user->name,
                ]);
            }
        }
    }

}
