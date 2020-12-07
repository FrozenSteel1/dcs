<?php

namespace App\Http\Livewire;

use App\Models\Division;
use App\Models\Document;
use Livewire\Component;

class DivisionsTable extends Component
{
    public $divisions;
   public  $search='';
    public $orderBy = 'division_name';
    public $orderAsc = true;
    public $updateMode = false;
    public $perPage = 10;
    public $division_name, $division_parent_name, $division_id;
    public function storeDivision()
    {

        $validatedDate = $this->validate([
            'division_name' => '',
            'division_parent_name' => '',
        ]);


        Division::create($validatedDate);

        session()->flash('message', 'Все прошло успешно');

        $this->resetInputFields();

        $this->emit('divisionStore'); // Close model to using to jquery

    }
    private function resetInputFields()
    {
        $this->division_name = '';
        $this->division_parent_name = '';



    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }
    public function deleteDivision($id)
    {
        if ($id) {
            Division::where('id', $id)->delete();
            session()->flash('message', 'Подразделение расформировано.');
        }
        $this->emit('divisionStore'); // Close model to using to jquery
    }
    public function searchDivisions()
    {
        $this->divisions = Division::where('division_name', 'like', '%' . $this->search . '%')

            ->get()
            ->toArray();
    }
    public function editDivision($id)
    {

        $this->updateMode = true;

        $division = Division::where('id', $id)->first();

        $this->division_id = $id;
        $this->division_name = $division->division_name;
        $this->division_parent_name = $division->division_parent_name;

    }
    public function render()
    {
$this->searchDivisions();

        return view('livewire.divisions-table', [
            'divisions' => $this->divisions,
            'division_id'=>$this->division_id,
            'divisionsSearch' => Division::searchDivision($this->search)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),


        ]);
    }
}
