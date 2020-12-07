<div>
    <!-- Основная таблица -->
    <div class="w-full flex pb-10">
        <div class="w-3/6 mx-1">
            <input wire:model.debounce.300ms="search" type="text"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   placeholder="Поиск документов...">
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderBy"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option value="document_name">Название</option>
                <option value="document_number">Номер</option>
                <option value="created_at">Дата подписания</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderAsc"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option value="1">По возрастанию</option>
                <option value="0">По убыванию</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="perPage"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
    </div>
    @include('modal.createDocument')
    @include('modal.createDivision')
    @include('modal.createWorker')
    <table class="table-auto table-hover w-full mb-6">
        <thead>
        <tr>
            <th class="px-4 py-2">Номер</th>
            <th class="px-4 py-2">Название</th>
            <th class="px-4 py-2">Дата подписания</th>
        </tr>
        </thead>

        <tbody>

        @foreach($documents as $document)

            <tr data-toggle="modal" data-target="#documentModal" wire:click="editDocument({{$document->id}})">
                <td class="border px-4 py-2">{{ $document->document_number }}</td>
                <td class="border px-4 py-2">{{ $document->document_name }}</td>
                <td class="border px-4 py-2">{{ $document->document_date_signing}}</td>
            </tr>

        @endforeach
        </tbody>

    </table>
    {{--    {!! $documents->links() !!}--}}
    <div>


        @if (session()->has('message'))
            <div class="alert alert-success" style="margin-top:30px;">x
                {{ session('message') }}
            </div>
        @endif

    </div>

</div>
