<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Worker;
use App\Models\User;
use App\Models\Division;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MainTable extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $division_name, $division_parent_name, $division_id;
    public $document_name, $document_number, $document_area, $document_id,
        $document_responsible_id, $document_signer_id, $document_tags, $document_date_signing,
        $document_date_expired, $document_data, $document_type, $document_worker_id;
    public $worker_name, $worker_surname, $worker_id, $worker_email, $worker_email_spare, $worker_tel
    , $worker_tel_spare, $worker_position, $worker_patronymic;
    public $documents, $divisions, $workers;
    public $perPage = 10;
    public $search = '';
    public $searchDivision = '';
    public $orderBy = 'document_number';
    public $orderAsc = true;
    public $updateMode = false;
    public $err = 0;
    public $flashMessage = [];

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

    private static function getWorkerId()
    {
        if (Auth::check()) {

            $user = Auth::user()->id;
            return $user;
        }
        return false;
    }

    public function storeDocument()
    {

        $this->flashMessage = [];
//Валидация
        $validatedDate = $this->validate([
            'document_name' => 'required|max:255|min:3|string',
            'document_number' => 'required|string|max:255',
            'document_area' => 'string|max:255',
            'document_data' => 'required',
            'document_type' => 'string|max:255',
            'document_date_expired' => 'date|after:document_date_signing',
            'document_date_signing' => 'required|date',
            'document_tags' => 'string|max:255',
            'document_responsible_id' => 'required|string|max:255|min:3',
            'document_signer_id' => 'required|string|max:255|min:3',
        ]);

//работа с полем файлов
       $zip = new ZipArchive;
        $nameZip = str_replace(['.', '/'], 'w', storage_path() . '\app\docs\\' . Hash::make(implode(getdate()))) . '.zip';
        if ($zip->open($nameZip, ZipArchive::CREATE) === TRUE) {

            foreach ($validatedDate['document_data'] as $file) {

                $zip->addFile(storage_path() . '\app\livewire-tmp\\' . $file->getFileName(), $file->getClientOriginalName());

            }

            $zip->close();
        }
        $validatedDate['document_data'] = $nameZip;
// Конец работы с полем файлов
// Работа с полем выбора бизнес единицы
        $businessItem = Division::where('division_name', $validatedDate['document_area'])->first();
        if ($businessItem <> null) {
            $validatedDate['document_area'] = $businessItem->id;
        }

// Конец работы с полем выбора бизнес единицы

// Работа с полем выбора ответственного
        $responsibleArr = explode(' ', $validatedDate['document_responsible_id']);
        if (count($responsibleArr) == 2) {
            $findResponsible = Worker::where('worker_name', $responsibleArr[1])
                ->orwhere('worker_name', $responsibleArr[0])
                ->where('worker_surname', $responsibleArr[0])
                ->orwhere('worker_surname', $responsibleArr[1])
                ->get()->first();
        }
        if (count($responsibleArr) > 2) {
            $findResponsible = Worker::where('worker_name', $responsibleArr[1])
                ->orwhere('worker_name', $responsibleArr[0])
                ->where('worker_surname', $responsibleArr[0])
                ->orwhere('worker_surname', $responsibleArr[1])
                ->where('worker_patronymic', $responsibleArr[2])
                ->orwhere('worker_patronymic', '')
                ->get()->first();
        }
        if (isset($findResponsible)) {


            $validatedDate['document_responsible_id'] = $findResponsible->id;
        } else {
            $this->flashMessage[] = 'Такого ответственного не существует занесите его в базу';
        }

// Конец работы с полем выбора ответственного

// Работа с полем выбора подписчика
        $signerArr = explode(' ', $validatedDate['document_signer_id']);
        if (count($signerArr) == 2) {
            $findSigner = Worker::where('worker_name', $signerArr[1])
                ->orwhere('worker_name', $signerArr[0])
                ->where('worker_surname', $signerArr[0])
                ->orwhere('worker_surname', $signerArr[1])
                ->get()->first();
        }
        if (count($signerArr) > 2) {
            $findSigner = Worker::where('worker_name', $signerArr[1])
                ->orwhere('worker_name', $signerArr[0])
                ->where('worker_surname', $signerArr[0])
                ->orwhere('worker_surname', $signerArr[1])
                ->where('worker_patronymic', $signerArr[2])
                ->orwhere('worker_patronymic', '')
                ->get()->first();
        }
        if (isset($findSigner)) {

            $validatedDate['document_signer_id'] = $findSigner->id;
        } else {
            $this->flashMessage[] = 'Такого подписчика не существует занесите его в базу или укажите ФИО полностью';
        }

// Конец работы с полем выбора подписчика

//Работа с полем работника
       $validatedDate['document_worker_id'] = self::getWorkerId();
//Конец работы с полем работника

//Сохранение и выведение финального сообщения
       if ($this->flashMessage == []) {
            Document::create($validatedDate);
            session()->flash('message', 'Документ добавлен все хорошо');
            $this->resetInputFields();

            $this->emit('documentStore'); // Close model to using to jquery
        } else {

            session()->flash('errorsArray', $this->flashMessage);

        }


    }

    public function storeWorker()
    {


        $validatedDate = $this->validate([

            'worker_name' => 'required|string|min:3|max:50',
            'worker_surname' => 'required|string|min:3|max:50',
            'worker_patronymic' => 'string|min:3|max:50',
            'worker_email' => 'email',
            'worker_email_spare' => 'email',
            'worker_tel' => 'required|string|max:50',
            'worker_tel_spare' => 'string|max:50',
            'worker_position' => 'string|min:3|max:50',
            'division_id' => 'string|min:3|max:50',


        ]);

        if ($validatedDate['division_id'] <> '') {
            $findDivision = Division::where('division_name', $validatedDate['division_id'])->first();
            if (isset($findDivision)) {

                $validatedDate['division_id'] = $findDivision->id;
            }
        } else {
            $validatedDate['division_id'] = 0;
        }


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

        $this->updateMode = true;

        $division = Division::where('id', $id)->first();

        $this->division_id = $id;
        $this->division_name = $division->division_name;
        $this->division_parent_name = $division->division_parent_name;

    }

    public function editWorker($id)
    {

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
        $this->document_area = Division::where('id', $document->document_area)->first()->division_name;
        $this->document_responsible_id = Worker::where('id', $document->document_responsible_id)->first()->worker_name;
        $this->document_worker_id = User::where('id', $document->document_worker_id)->first()->name;
        $this->document_signer_id = Worker::where('id', $document->document_signer_id)->first()->worker_name;;
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

        $pathToFile = Document::find($id)['document_data'];

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
            $this->emit('documentStore');
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
//перекинуть тут

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
