<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\VerificationEmail;
use App\Models\EmailVerification;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController
{
    public function register(UserStoreRequest $request) {
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->profile = "https://cacaocare.s3.ap-southeast-2.amazonaws.com/profile-photos/default_profile.png";
        $user->region = $request->region;
        $user->province = $request->province;
        $user->city = $request->city;
        $user->barangay = $request->barangay;
        $user->role = 'user';

        $user->save();

        $token = Str::random(40);
        DB::table('email_verifications')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $url = url('/verify-email?token=' . $token);
        Mail::to($request->email)->send(new VerificationEmail($url));

        return response()->json(['message' => 'Verification email sent!']);
    }

    public function verifyEmail(Request $request) {
        $token = $request->query('token');
        $record = DB::table('email_verifications')->where('token', $token)->first();

        if ($record) {
            DB::table('users')
            ->where('email', $record->email)
            ->update(['email_verified_at' => Carbon::now()]);
            DB::table('email_verifications')->where('token', $token)->delete();

            return redirect()->to('https://cacao-care.nuxt.dev/signin');
        }
        return redirect()->to('/');
    }

    public function authLogin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'email' => 'This email is not registered'
                ]
            ], 404);
        }

        $mismatchPassword = !Hash::check($request->password, $user->password);

        if($mismatchPassword){
            return response()->json([
                'message' => 'Invalid Password',
                'errors' => [
                    'password' => 'Invalid password'
                ]
            ], 400);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'data' => $user
        ], 200);

    }

    public function authLogout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message', 'Successfully Logout'
        ], 200);
    }
}
