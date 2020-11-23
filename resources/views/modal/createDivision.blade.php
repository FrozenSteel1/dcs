<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Добавить подразделение
</button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление Подразделения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Подразделение</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Подразделение" wire:model="division_name">
                        @error('division_name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Подчинение</label>
                        <input type="email" class="form-control" id="exampleFormControlInput2" wire:model="division_parent_name" placeholder="В подчинении">
                        @error('division_parent_name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Закрыть</button>
                <button type="button" wire:click.prevent="storeDivision()" class="btn btn-primary close-modal">Добавить</button>
            </div>
        </div>
    </div>
</div>
