<?php

namespace App\Contracts;

interface RickMortyApiContract
{
    public function getCharacterInfo($characterId);
}
