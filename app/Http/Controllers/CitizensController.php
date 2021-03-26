<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Citizen;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Citizen as CitizenResource;

class CitizensController extends BaseController
{
    public function show($id) {
        // $profile = Citizens::find($id);
        $profile = Citizen::where('profile_id', $id)->orderBy('created_at', 'DESC')->first();
  
        if (is_null($profile)) {
            return $this->sendError('Le profile n\'a pas été trouvé.');
        }
   
        return $this->sendResponse(new CitizenResource($profile), 'Effectué.');
    }



    public function update(Request $request, Citizen $citizens, Profile $profile) {

        $currentUserId = Auth::id();
        $currentProfileUser = Profile::where('user_id', $currentUserId)->first();

        $profile = Profile::find($currentProfileUser->id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'profile_id' => 'required',
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
        $last_entry = Citizen::where('profile_id', $currentProfileUser->id)->latest()->first();

        if($currentProfileUser->id == $input['profile_id']) {
            if($input['before'] == $last_entry['after']) {
                // Ajout de l'entrée en bdd
                $citizens = Citizen::create($request->all());
                
                // Modification du profil
                $currentProfileUser->citizens = $input['after'];
                $currentProfileUser->save();

                return $this->sendResponse(new CitizenResource($citizens), 'Product updated successfully.');
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
