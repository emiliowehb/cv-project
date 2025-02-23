<div class="d-flex justify-content-end flex-shrink-0">
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" wire:click="$emit('update_re', {{ $expertiseArea->id }})" data-kt-re-id="{{ $expertiseArea->id }}" data-kt-action="update_re">
        {!! getIcon('pencil', 'fs-2', '', 'i') !!}
    </button>
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" wire:click="$emit('delete_re', {{ $expertiseArea->id }})" data-kt-re-id="{{ $expertiseArea->id }}" data-kt-action="delete_re">
        {!! getIcon('trash', 'fs-2', '', 'i') !!}
    </button>
</div>
