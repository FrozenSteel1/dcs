<div class="relative">
    <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
    <input
           autocomplete="off" list="autoComplete1" wire:model=search type="text" class="form-input" id="autoComplete">

        <datalist id="autoComplete1">
        @if(!empty($this->search))
            @if(!empty($divisions))
                @foreach($divisions as  $division)
                        <option value="{{ $division['division_name'] }}">
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        @endif
        </datalist>

    </div>
</div>

