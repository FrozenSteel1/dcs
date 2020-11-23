<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Division;

class InputAutocomplete extends Component
{
    public  $search='';
    public  $divisions=[];

    public function searching()
    {
         $this->divisions = Division::where('division_name', 'like', '%' . $this->search . '%')
            ->get()
            ->toArray();
    }
    public function render()
    {
       $this->searching();
        return view('livewire.input-autocomplete');
    }
}
