<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Profile as ProfileResource;

class ProfileController extends BaseController
{


    public function show($id) {
        $profile = Profile::find($id);
  
        if (is_null($profile)) {
            return $this->sendError('Le profile n\'a pas été trouvée.');
        }
   
        return $this->sendResponse(new ProfileResource($profile), 'Profil récupéré avec succès.');
    }

    public function update(Request $request, Profile $profile, $id)
    {
        $profile = Profile::find($id);


        $input = $request->all();

        $validator = Validator::make($input, [
            'citizens' => 'required',
            'horses' => 'required',
            'golds' => 'required',
            'food' => 'required',
            'wood' => 'required',
            'stone' => 'required',
            'ruby' => 'required'
        ]);


        if($profile === null) {
            return $this->sendError('L\'utilisateur n\'existe pas.', $validator->errors());      
        }

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $profile->citizens = $input['citizens'];
        $profile->horses = $input['horses'];
        $profile->golds = $input['golds'];
        $profile->food = $input['food'];
        $profile->wood = $input['wood'];
        $profile->stone = $input['stone'];
        $profile->ruby = $input['ruby'];

        $profile->save();
   
        return $this->sendResponse(new ProfileResource($profile), 'Product updated successfully.');
    }
   
}