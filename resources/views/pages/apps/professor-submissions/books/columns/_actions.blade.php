<div class="d-flex justify-content-end flex-shrink-0">
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1" wire:click="$emit('approveReviewable', {{ $reviewable->id }})" data-reviewable-id="{{ $reviewable->id }}" data-kt-action="approveReviewable">
        {!! getIcon('check', 'fs-2', '', 'i') !!}
    </button>
    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" wire:click="$emit('denyReviewable', {{ $reviewable->id }})" data-reviewable-id="{{ $reviewable->id }}" data-kt-action="denyReviewable">
        {!! getIcon('cross', 'fs-2', '', 'i') !!}
    </button>
</div>
