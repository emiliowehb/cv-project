<div wire:ignore.self class="modal fade" id="kt_modal_view_reviewable_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Details of {{ $reviewableType }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div>
                {!! $reviewableDetails !!}                    
                </div>
                <div class="pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
</div>