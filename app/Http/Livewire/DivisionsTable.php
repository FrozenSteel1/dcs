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

        $rules = [
            'division_name' => 'different:division_parent_name|filled|max:255|min:3|required|string',
            'division_parent_name' => 'different:division_name|nullable|max:255|min:3|string',
        ];
        $validatedDate = $this->validate($rules);
        Division::create($validatedDate);
        session()->flash('message', 'Подразделение добавлено.');


        $this->emit('divisionStore');

    }
    public function updateDivision($id)
    {

        $record=Division::where('id',$id)->first();

        $rules = [
            'division_name' => 'different:division_parent_name|filled|max:255|min:3|required|string',
            'division_parent_name' => 'different:division_name|nullable|max:255|min:3|string',
        ];
        $validatedDate = $this->validate($rules);
        if ($validatedDate['division_name']<>$record->division_name or $validatedDate['division_parent_name']<>$record->division_parent_name){
            $record->update($validatedDate);
            session()->flash('message', 'Подразделение изменено.');

        }
        $this->emit('divisionStore');




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
            'update_mode' => $this->updateMode,
            'divisions' => $this->divisions,
            'division_id'=>$this->division_id,
            'divisionsSearch' => Division::searchDivision($this->search)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),


        ]);
    }
}
