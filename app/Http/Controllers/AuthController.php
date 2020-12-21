<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'=> 'required|max:55',
            'email'=> 'email|required|unique:users',
            'password'=> 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user'=>$user, 'access_token'=>$accessToken]);
    }

    public function login(Request $request)
    {
        $login_credentials = $request->validate([
        
            'email'=> 'email|required',
            'password'=> 'required'
        ]);

       if(!auth()->attempt($login_credentials)){
           return response(['message'=>'invalid login details']);
       }
       
       
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user'=>auth()->user(), 'access_token'=>$accessToken]);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        

        $token = $githubUser->token;
        $refreshToken = $githubUser->refreshToken;
        $expiresIn = $githubUser->expiresIn;
       
        $user = User::create([

            // $githubUser->getId();
            // $githubUser->getNickname();
            "name"=>$githubUser->getNickname(),
            "email"=>$githubUser->getEmail(),
            "password"=>Hash::make('123456'),
            // $githubUser->getAvatar();
        ]);

            // User::login($user, true);

            return redirect('api/product');
    }
}
