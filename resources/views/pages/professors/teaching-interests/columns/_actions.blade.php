<div class="d-flex justify-content-end flex-shrink-0">
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" wire:click="$emit('update_te', {{ $teachingInterest->id }})" data-kt-te-id="{{ $teachingInterest->id }}" data-kt-action="update_te">
        {!! getIcon('pencil', 'fs-2', '', 'i') !!}
    </button>
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" wire:click="$emit('delete_te', {{ $teachingInterest->id }})" data-kt-te-id="{{ $teachingInterest->id }}" data-kt-action="delete_te">
        {!! getIcon('trash', 'fs-2', '', 'i') !!}
    </button>
</div>
