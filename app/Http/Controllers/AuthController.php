<?php

namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use App\Models\Profile;
use App\Models\Citizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
   
class AuthController extends BaseController
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Création du profil
        $r_profile['user_id'] = $user->id;
        $r_profile['username'] = $input['name'];
        $r_profile['citizens'] = '50';
        $r_profile['horses'] = '10';
        $r_profile['golds'] = '100';
        $r_profile['food'] = '350';
        $r_profile['wood'] = '500';
        $r_profile['stone'] = '500';
        $r_profile['ruby'] = '0';
        $profile = Profile::create($r_profile);

        // Initialisation de la tab le citizens
        $r_citizens['profile_id'] = $profile->id;
        $r_citizens['action'] = 'initialisation';
        $r_citizens['before'] = '0';
        $r_citizens['after'] = '50';
        $citizens = Citizen::create($r_citizens);


        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}