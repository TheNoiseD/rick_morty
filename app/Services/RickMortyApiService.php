<?php

namespace App\Services;

use App\Contracts\RickMortyApiContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RickMortyApiService implements RickMortyApiContract
{

    const API_URL = 'https://rickandmortyapi.com/api/';
    const API_CHARACTER_URL = self::API_URL . 'character/';

    private static $instance;

    public static function getInstance(): RickMortyApiService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        // Constructor privado para prevenir instancias múltiples.
    }

    public function getCharacterInfo($characterId)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', self::API_CHARACTER_URL . $characterId,['verify'=>false]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return ['error'=> $e->getMessage()];
        }
    }
}
