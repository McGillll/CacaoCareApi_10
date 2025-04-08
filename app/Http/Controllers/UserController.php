<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UsreStoreRequest;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Hash;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class UserController
{
    //Create
    public function store(UserStoreRequest $request)
    {
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

        return response()->json([
            'message' => 'User created successfully!', 'data' => $user
        ], 201);
    }

    public function upload(Request $request){
        $path = $request->file('file')->storePubliclyAs('cacao-photos/blackpod-rot');
        return response()->json([
            'data' => $path
        ]);
    }

    //Retreive

    public function getMany()
    {
        $user = User::all();
        return response()->json([
            'data' => $user
        ], 200);
    }

    public function getOne(string $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if(!$user){
            return response()->json([], 404);
        }else{
            return response()->json([
                'data' => $user
            ], 200);
        }
    }

    public function getCurrentUser() {
        $user = auth()->user();
        return response()->json([
            'data' => $user
        ],200);
    }

    //Update
    public function update(UserUpdateRequest $request, User $user)
    {

    }

    //Delete
    public function destroy(User $user)
    {
        //
    }
}
