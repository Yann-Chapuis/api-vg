<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Citizens;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Citizens as CitizensResource;

class CitizensController extends BaseController
{
    public function show($id) {
        // $profile = Citizens::find($id);
        $profile = Citizens::where('profiles_id', $id)->first();
  
        if (is_null($profile)) {
            return $this->sendError('Le profile n\'a pas été trouvé.');
        }
   
        return $this->sendResponse(new CitizensResource($profile), 'Effectué.');
    }



    public function update(Request $request, Citizens $citizens, Profile $profile) {

        $current_user_id = Auth::id();
        $current_profile_user = Profile::where('users_id', $current_user_id)->first();

        $profile = Profile::find($current_profile_user->id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'profiles_id' => 'required',
            'action' => 'required',
            'before' => 'required',
            'after' => 'required'
        ]);

        if($profile === null) {
            return $this->sendError('L\'utilisateur n\'existe pas.', $validator->errors());      
        }

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        // Récupérer la dernière entrée et comparer avant/après
        $last_entry = Citizens::where('profiles_id', $current_profile_user->id)->latest()->first();

        if($current_profile_user->id == $input['profiles_id']) {
            if($input['before'] == $last_entry['after']) {
                // Ajout de l'entrée en bdd
                $citizens = Citizens::create($request->all());
                
                // Modification du profil
                $current_profile_user->citizens = $input['after'];
                $current_profile_user->save();

                return $this->sendResponse(new CitizensResource($citizens), 'Product updated successfully.');
            }
            else {
                return $this->sendError('Erreur. Veuillez contacter un modérateur.', $validator->errors());       
            }
        }
        else {
            return $this->sendError('Erreur. Vous ne pouvez modifier les données d\'autres utilisateurs.', $validator->errors());                  
        }


        


        // Ajouter dans la bdd
        // Modifier la table profile



    
    }
}
