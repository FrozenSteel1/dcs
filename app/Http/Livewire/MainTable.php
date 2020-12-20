<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Worker;
use App\Models\Division;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use ZipArchive;
use Illuminate\Support\Facades\Hash;


class MainTable extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $division_name, $division_parent_name, $division_id;
    public $document_name, $document_number, $document_area, $document_id,
        $document_responsible_id, $document_signer_id, $document_tags, $document_date_signing,
        $document_date_expired, $document_data, $document_type;
    public $worker_name, $worker_surname, $worker_id, $worker_email, $worker_email_spare, $worker_tel
    , $worker_tel_spare, $worker_position, $worker_patronymic;
    public $documents, $divisions, $workers;
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
        $this->worker_name = '';
        $this->worker_surname = '';
        $this->worker_id = '';
        $this->worker_email = '';
        $this->worker_email_spare = '';
        $this->worker_tel = '';
        $this->worker_tel_spare = '';
        $this->worker_position = '';
        $this->worker_patronymic = '';
        $this->document_name = '';
        $this->document_number = '';
        $this->document_area = '';
        $this->document_id = '';
        $this->document_responsible_id = '';
        $this->document_signer_id = '';
        $this->document_tags = '';
        $this->document_date_signing = '';
        $this->document_date_expired = '';
        $this->document_data = '';
        $this->document_type = '';


    }

    public function storeDocument()
    {

        $validatedDate = $this->validate([
            'document_name' => 'required',
            'document_number' => 'required',
            'document_area' => '',
            'document_data' => '',
            'document_type' => '',
            'document_date_expired' => '',
            'document_date_signing' => '',
            'document_tags' => '',
            'document_responsible_id' => '',
            'document_signer_id' => '',
        ]);
        $zip = new ZipArchive;
        $nameZip = str_replace(['.', '/'], 'w', storage_path() . '\app\docs\\' . Hash::make(implode(getdate()))) . '.zip';
        if ($zip->open($nameZip, ZipArchive::CREATE) === TRUE) {

            foreach ($validatedDate['document_data'] as $file) {

                $zip->addFile(storage_path() . '\app\livewire-tmp\\' . $file->getFileName(), $file->getClientOriginalName());

            }

            $zip->close();
        }


        $validatedDate['document_data'] = $nameZip;


        Document::create($validatedDate);

        session()->flash('message', 'Документ добавлен все хорошо');

        $this->resetInputFields();

        $this->emit('documentStore'); // Close model to using to jquery

    }

    public function storeWorker()
    {

        $validatedDate = $this->validate([

            'worker_name' => 'required',
            'worker_surname' => 'required',
            'worker_id' => '',
            'worker_email' => 'email',
            'worker_email_spare' => 'email',
            'worker_tel' => '',
            'worker_tel_spare' => '',
            'worker_position' => '',
            'division_id' => '',
            'worker_patronymic' => '',

        ]);


        Worker::create($validatedDate);

        session()->flash('message', 'Работник успешно добавлен');

        $this->resetInputFields();

        $this->emit('workerStore'); // Close model to using to jquery

    }

    public function storeDivision()
    {

        $rules = [
            'division_name' => 'different:division_parent_name|filled|max:255|min:3|required|string',
            'division_parent_name' => 'different:division_name|nullable|max:255|min:3|string',
        ];
        $validatedDate = $this->validate($rules);
        Division::create($validatedDate);
        session()->flash('message', 'Подразделение добавлено.');

        //  $this->resetInputFields();

        $this->emit('divisionStore'); // Close model to using to jquery

    }

    public function edit($id)
    {
        dd('edit');
        $this->updateMode = true;

        $division = Division::where('id', $id)->first();

        $this->division_id = $id;
        $this->division_name = $division->division_name;
        $this->division_parent_name = $division->division_parent_name;

    }

    public function editWorker($id)
    {
        dd('edieditWorkert');
        $this->updateMode = true;

        $division = Division::where('id', $id)->first();

        $this->division_id = $id;
        $this->division_name = $division->division_name;
        $this->division_parent_name = $division->division_parent_name;

    }

    public function editDocument($id)
    {

        $this->updateMode = true;

        $document = Document::where('id', $id)->first();

        $this->document_id = $id;
        $this->document_name = $document->document_name;
        $this->document_number = $document->document_number;
        $this->document_type = $document->document_type;
        $this->document_area = $document->document_area;
        $this->document_responsible_id = $document->document_responsible_id;
        $this->document_worker_id = $document->document_worker_id;
        $this->document_signer_id = $document->document_signer_id;
        $this->document_date_signing = $document->document_date_signing;
        $this->document_date_expired = $document->document_date_expired;
        $this->document_data = $document->document_data;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function cancelDocument()
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

    public function download($id)
    {

        $pathToFile =Document::find($id)['document_data'];

        return response()->download($pathToFile);
    }

    public function deleteDivision($id)
    {
        if ($id) {
            Division::where('id', $id)->delete();
            session()->flash('message', 'Подразделение расформировано.');
        }
        $this->emit('documentStore'); // Close model to using to jquery
    }

    public function deleteWorker($id)
    {
        if ($id) {
            Worker::where('id', $id)->delete();
            session()->flash('message', 'Работника уволили.');
        }
    }

    public function deleteDocument($id)
    {
        if ($id) {
            Document::where('id', $id)->delete();
            session()->flash('message', 'Документа больше нет.');
        }
    }

    public function searching()
    {
        $this->divisions = Division::where('division_name', 'like', '%' . $this->search . '%')
            ->get()
            ->toArray();
    }

    public function searchWorkers()
    {
        $this->workers = Worker::where('worker_surname', 'like', '%' . $this->search . '%')
            ->get()
            ->toArray();
    }

    public function render(): string
    {
        $this->searching();
        $this->searchWorkers();


        return view('livewire.main-table', [
            'documents' => Document::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),
            'divisions' => $this->divisions,
            'workers' => $this->workers,
            'worker_id' => $this->worker_id,
            'division_id' => $this->division_id,
            'document_id' => $this->document_id,


        ]);


    }


}
