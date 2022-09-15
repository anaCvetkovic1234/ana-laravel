<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //za registraciju korisnika
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'email'=> 'required|string|max:255|email|unique:users',
            'password'=> 'required|string|min:8'
        ]);
        //proverava da li je korisnik uspesno prosao validaciju, tj registraciju
        if($validator->fails())
        //ako nije
            return response()->json($validator->errors());

        //ako jeste
        $user = User::create([
             'name'=>$request->name,
             'email'=> $request->email,
             'password'=> Hash::make($request->password)
        ]);
        //kreiranje tokena
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data'=>$user, 'access_token'=>$token, 'token_type'=>'Bearer']);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only(['email','password'])))
            return response()->json(['message'=>'Unauthorized', 401]);

        $user = User::where('email',$request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message'=>'Hi '.$user->name.' welcome to home page.', 'access_token'=>$token, 'token_type'=>'Bearer']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message'=>'You have successfully logged out and the token was successfully deleted!'
        ];
    }
}