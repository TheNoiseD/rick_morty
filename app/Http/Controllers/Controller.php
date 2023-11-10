<?php

namespace App\Http\Controllers;

use App\Repositories\CharacterRepository;
use App\Services\RickMortyApiService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private CharacterRepository $characterRepository;

    public function __construct(CharacterRepository $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }

    public function index():View
    {
        return view('welcome');
    }

    public function characters():View
    {
        return view('dashboard');
    }
    public function myCharacters():View
    {
        $data['characters'] = $this->characterRepository->getCharactersByUser(Auth::id());
        return view('characters',$data);
    }

    public function saveCharacter(Request $request): JsonResponse
    {
        if(Auth::check()){
            $apiService = RickMortyApiService::getInstance();
            $character = $apiService->getCharacterInfo($request->post('id'));
            $response = $this->characterRepository->createCharacter([
                'user_id'=>Auth::id(),
                'character_id'=>$character['id'],
                'name'=>$character['name'],
                'status'=>$character['status'],
                'species'=>$character['species'],
                'image'=>$character['image'],
                'location'=>$request->post('location'),
            ]);
            return response()->json(['message'=>$response->message],200);
        }else{
            return response()->json(['error'=>'Unauthorized','message'=>'Ingresa para poder guardar tus personajes favoritos'],401);
        }
    }

    public function deleteCharacter($id): JsonResponse
    {
        $response = $this->characterRepository->deleteCharacter($id);
        return response()->json(['message'=>$response->message],$response->status);
    }

}
