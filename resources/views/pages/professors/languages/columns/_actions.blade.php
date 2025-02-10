<div class="d-flex justify-content-end flex-shrink-0">
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" wire:click="$emit('update_language', {{ $language->id }})" data-kt-language-id="{{ $language->id }}" data-kt-action="update_language">
        {!! getIcon('pencil', 'fs-2', '', 'i') !!}
    </button>
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" wire:click="$emit('delete_language', {{ $language->id }})" data-kt-language-id="{{ $language->id }}" data-kt-action="delete_language">
        {!! getIcon('trash', 'fs-2', '', 'i') !!}
    </button>
</div>
