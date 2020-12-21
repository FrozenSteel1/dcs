<button wire:click.prevent="cancel()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#workerModal">
    Добавить Работника
</button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="workerModal" tabindex="-1" role="dialog" aria-labelledby="workerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerModalLabel">Добавление работника</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group hidden">
                        <label for="worker_id">ID</label>
                        <input type="text" class="form-control" id="worker_id" placeholder="ID" wire:model="worker_id">
                        @error('worker_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_name">Имя</label>
                        <input type="text" class="form-control" id="worker_name" placeholder="Имя" wire:model="worker_name">
                        @error('worker_name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_surname">Фамилия</label>
                        <input type="text" class="form-control" id="worker_surname" wire:model="worker_surname" placeholder="Фамилия">
                        @error('worker_surname') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_patronymic">Отчество</label>
                        <input type="text" class="form-control" id="worker_patronymic" wire:model="worker_patronymic" placeholder="Отчество">
                        @error('worker_patronymic') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_email">Основной Email</label>
                        <input type="email" class="form-control" id="worker_email" wire:model="worker_email" placeholder="Основной Email">
                        @error('worker_email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_email_spare">Дополнительный Email</label>
                        <input type="email" class="form-control" id="worker_email_spare" wire:model="worker_email_spare" placeholder="Дополнительный Email">
                        @error('worker_email_spare') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_tel">Основной телефон</label>
                        <input type="tel" class="form-control" id="worker_tel" wire:model="worker_tel" placeholder="Основной телефон">
                        @error('worker_tel') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_tel_spare">Дополнительный телефон</label>
                        <input type="tel" class="form-control" id="worker_tel_spare" wire:model="worker_tel_spare" placeholder="Дополнительный телефон">
                        @error('worker_tel_spare') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="division_id">Подразделение</label>
                        <input autocomplete="off" list="devisionsList1" type="text" class="form-control" id="division_id" wire:model.lazy="division_id" placeholder="Подразделение">
                        <datalist id="devisionsList1">
                            @foreach($divisions as $division)
                                <option value="{{$division['division_name']}}"></option>
                            @endforeach
                        </datalist>
                        @error('division_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="worker_position">Должность</label>
                        <input type="text" class="form-control" id="worker_position" wire:model="worker_position" placeholder="Должность">
                        @error('worker_position') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Закрыть</button>
                <button type="button" wire:click.prevent="deleteWorker({{$worker_id}})" class="btn btn-primary close-modal">Удалить</button>
                @if($update_mode==false)
                    <button type="button" wire:click.prevent="storeWorker()" class="btn btn-primary close-modal">Добавить</button>
                @endif
                @if($update_mode==true)
                    <button type="button" wire:click.prevent="updateWorker({{$worker_id}})" class="btn btn-primary close-modal">Изменить</button>
                @endif

            </div>
        </div>
    </div>
</div>
