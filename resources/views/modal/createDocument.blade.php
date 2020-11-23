<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Open Form
</button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление документа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="document_name">Название</label>
                        <input type="text" class="form-control" id="document_name" placeholder="document_name" wire:model="document_name">
                        @error('document_name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_number">Номер</label>
                        <input type="text" class="form-control" id="document_number" wire:model="document_number" placeholder="document_number">
                        @error('document_number') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_area">Действие</label>
                        <input  type="text" class="form-control" id="document_area" wire:model="document_area" placeholder="document_area">
                        @error('document_area') <span class="text-danger error">{{ $message }}</span>@enderror

                    </div>

                    <div class="form-group">
                        <label for="document_responsible_id">Ответственные</label>
                        <input type="text" class="form-control" id="document_responsible_id" wire:model="document_responsible_id" placeholder="document_responsible_id">
                        @error('document_responsible_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_signer_id">Подписчик</label>
                        <input type="text" class="form-control" id="document_signer_id" wire:model="document_signer_id" placeholder="document_signer_id">
                        @error('document_signer_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_date_signing">Дата подписания</label>
                        <input type="date" class="form-control" id="document_date_signing" wire:model="document_date_signing" placeholder="document_date_signing">
                        @error('document_date_signing') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_date_expired">Дата окончания действия</label>
                        <input type="date" class="form-control" id="document_date_expired" wire:model="document_date_expired" placeholder="document_date_expired">
                        @error('document_date_expired') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_tags">Тэги</label>
                        <input type="text" class="form-control" id="document_tags" wire:model="document_tags" placeholder="document_tags">
                        @error('document_tags') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="document_data">Файлы</label>
                        <input  type="file" multiple="multiple" class="form-control" id="document_tags" wire:model="document_data" placeholder="document_data">
                        @error('document_data') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Закрыть</button>
                <button type="button" wire:click.prevent="storeDocument()" class="btn btn-primary close-modal">Добавить</button>
            </div>
        </div>
    </div>
</div>

