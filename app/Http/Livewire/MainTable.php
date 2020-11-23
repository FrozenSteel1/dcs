<?php

namespace App\Http\Livewire;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Division;

class MainTable extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $division_name, $division_parent_name, $division_id;
    public $document_name, $document_number, $document_area, $document_id,
        $document_responsible_id, $document_signer_id, $document_tags, $document_date_signing,
        $document_date_expired, $document_data;
    public $documents, $divisions;
    public $perPage = 10;
    public $search = '';
    public $searchDivision = '';
    public $orderBy = 'document_number';
    public $orderAsc = true;
    public $updateMode = false;


    private function resetInputFields()
    {
        $this->division_name = '';
        $this->division_parent_name = '';
    }

    public function storeDocument()
    {
        $validatedDate = $this->validate([
            'document_name' => 'required',
            'document_number' => 'required',
            'document_area' => '',
            'document_data' => '',
            'document_date_expired' => '',
            'document_date_signing' => '',
            'document_tags' => '',
            'document_responsible_id' => '',
            'document_signer_id' => '',
        ]);

        dd($validatedDate);
        Document::create($validatedDate);

        session()->flash('message', 'Divisions Created Successfully.');

        $this->resetInputFields();

        $this->emit('divisionStore'); // Close model to using to jquery

    }

    public function store()
    {
        $validatedDate = $this->validate([
            'division_name' => 'required',
            'division_parent_name' => 'required',
        ]);

        Division::create($validatedDate);

        session()->flash('message', 'Divisions Created Successfully.');

        $this->resetInputFields();

        $this->emit('divisionStore'); // Close model to using to jquery

    }

    public function edit($id)
    {

        $this->updateMode = true;

        $division = Division::where('id', $id)->first();

        $this->division_id = $id;
        $this->division_name = $division->division_name;
        $this->division_parent_name = $division->division_parent_name;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function update()
    {
        $validatedDate = $this->validate([
            'division_name' => 'required',
            'division_parent_name' => 'required',
        ]);

        if ($this->division_id) {
            $division = Division::find($this->division_id);
            $division->update([
                'division_name' => $this->division_name,
                'division_parent_name' => $this->division_parent_name,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Divisions Updated Successfully.');
            $this->resetInputFields();

        }
    }

    public function delete($id)
    {
        if ($id) {
            Division::where('id', $id)->delete();
            session()->flash('message', 'Divisions Deleted Successfully.');
        }
    }


    public function render(): string
    {

        return view('livewire.main-table', [
            'documents' => Document::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),

        ]);


    }


}
