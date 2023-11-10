<?php

namespace App\Livewire;

use Livewire\Component;

class CardCharacter extends Component
{
    public $id;
    public $name;
    public $image;
    public $status;
    public $species;
    public $location;

    public function render()
    {
        return view('livewire.card-character');
    }

    public function getBackgroundColor($location)
    {
        if ($location <= 50) {
            return 'bg-green-500';
        } elseif ($location <= 80) {
            return 'bg-blue-500';
        } elseif ($location > 80) {
            return 'bg-red-500';
        } else {
            return 'bg-white';
        }
    }

    public function deleteCharacter()
    {
        $this->emit('deleteCharacter', $this->id);

    }
}
