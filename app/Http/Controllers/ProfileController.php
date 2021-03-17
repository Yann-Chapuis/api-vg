<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Profile as ProfileResource;

class ProfileController extends BaseController
{

    public function index()
    {
        $profile = Profile::all();
    
        return $this->sendResponse(ProfileResource::collection($profile), 'Les profiles ont été récupéré.');
    }

    public function show($id) {
        $profile = Profile::find($id);
  
        if (is_null($profile)) {
            return $this->sendError('Le profile n\'a pas été trouvé.');
        }
   
        return $this->sendResponse(new ProfileResource($profile), 'Profile récupéré avec succès.');
    }

    public function update(Request $request, Profile $profile, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'life' => 'required',
            'attack' => 'required',
            'defense' => 'required',
            'health' => 'required',
            'gold' => 'required',
            'ruby' => 'required'
        ]);
        if($id === null) {
            return $this->sendError('L\'utilisateur n\'existe pas.', $validator->errors());      
        }
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $profile = Profile::find($id);
        $profile->life = $input['life'];
        $profile->attack = $input['attack'];
        $profile->defense = $input['defense'];
        $profile->health = $input['health'];
        $profile->gold = $input['gold'];
        $profile->ruby = $input['ruby'];
        $profile->save();
   
        return $this->sendResponse(new ProfileResource($profile), 'Product updated successfully.');
    }
   
}
