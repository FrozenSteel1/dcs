<?php

namespace App\Http\Livewire;

use App\Models\Division;
use App\Models\Worker;
use Livewire\Component;

class WorkersTable extends Component
{
    public $workers,$divisions;

    public  $search='';
    public $orderBy = 'worker_name';
    public $orderAsc = true;
    public $updateMode = false;
    public $perPage = 10;
    public $worker_name, $worker_surname, $worker_id, $worker_email, $worker_email_spare, $worker_tel
, $worker_tel_spare, $worker_position, $worker_patronymic, $division_id;
    private function resetInputFields()
    {
        $this->worker_name='';
        $this->worker_surname='';
        $this->worker_id='';
        $this->worker_email='';
        $this->worker_email_spare='';
        $this->worker_tel='';
        $this->worker_tel_spare='';
        $this->worker_position='';
        $this->worker_patronymic='';
        $this->division_id='';


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

//        if ($validatedDate['division_id'] <> '') {
//            $findDivision = Division::where('division_name', $validatedDate['division_id'])->first();
//            if (isset($findDivision)) {
//
//                $validatedDate['division_id'] = $findDivision->id;
//            }
//        } else {
//            $validatedDate['division_id'] = 0;
//        }


        Worker::create($validatedDate);

        session()->flash('message', 'Работник успешно добавлен');

        $this->resetInputFields();

        $this->emit('workerStore'); // Close model to using to jquery

    }
    public function updateWorker($id)
    {

$record=Worker::where('id',$id)->first();

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


//        if ($validatedDate['division_id'] <> '') {
//            $findDivision = Division::where('division_name', $validatedDate['division_id'])->first();
//            if (isset($findDivision)) {
//
//                $validatedDate['division_id'] = $findDivision->id;
//            }
//        } else {
//            $validatedDate['division_id'] = 0;
//        }


        $record->update($validatedDate);

        session()->flash('message', 'Работник успешно изменен');

        $this->resetInputFields();

        $this->emit('workerStore');

    }
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }
    public function searchWorkers()
    {
        $this->workers = Worker::where('worker_surname', 'like', '%' . $this->search . '%')

            ->get()
            ->toArray();
    }
    public function editWorker($id)
    {

        $this->updateMode = true;

        $worker = Worker::where('id', $id)->first();

        $this->worker_id = $id;

        $this->worker_name = $worker->worker_name;
        $this->worker_surname = $worker->worker_surname;
        $this->worker_patronymic = $worker->worker_patronymic;
        $this->worker_email = $worker->worker_email;
        $this->worker_email_spare = $worker->worker_email_spare;
        $this->worker_tel = $worker->worker_tel;
        $this->worker_tel_spare = $worker->worker_tel_spare;
        $this->division_id = $worker->division_id;
        $this->worker_position = $worker->worker_position;


    }
    public function deleteWorker($id)
    {

        if ($id) {
            Worker::where('id', $id)->delete();
            session()->flash('message', 'Работника уволили.');
        }
        $this->emit('workerStore'); // Close model to using to jquery
    }
    public function render()
    {
        $this->divisions = Division::where('division_name', 'like', '%' . $this->search . '%')
            ->get()
            ->toArray();



        return view('livewire.workers-table', [
            'update_mode' => $this->updateMode,
            'divisions' => $this->divisions,
            'workersSearch' => Worker::searchWorker($this->search)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),
            'workers'=>$this->workers,
            'worker_id'=>$this->worker_id,


        ]);

    }
}
