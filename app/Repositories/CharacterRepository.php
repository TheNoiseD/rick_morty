<?php

namespace App\Repositories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;

class CharacterRepository
{

    public function createCharacter($data):object
    {
        $response = new \stdClass();
        if ($this->getCharacterByUserAndId($data['user_id'], $data['character_id'])) {
            $response->message='Ya tienes este personaje en tu colección';
            return $response;
        }
        Character::create($data);

        $response->message = 'Ya tienes un nuevo personaje Felicidades';
        return $response;
    }

    public function getAllCharacters():Collection
    {
        return Character::all();
    }

    public function getCharacterByUserAndId($userId, $characterId):?Character
    {
        return Character::where('user_id',$userId)->where('character_id',$characterId)->first();
    }

    public function getCharactersByUser($userId):Collection
    {
        return Character::where('user_id',$userId)->get();
    }

    public function deleteCharacter($id): object
    {
        $user = auth()->user();
        $character = Character::where('id',$id)->where('user_id',$user->id)->first();
        $response = new \stdClass();
        if($character){
            $character->delete();
            $response->message = 'Personaje eliminado';
            $response->status = 200;
            return $response;
        }else{
            $response->message = 'Puede que esete personaje no te pertenezca o no exista';
            $response->status = 404;
            return $response;
        }
    }

}
