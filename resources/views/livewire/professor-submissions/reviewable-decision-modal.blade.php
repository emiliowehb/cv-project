<div wire:ignore.self class="modal fade" id="kt_modal_reviewable_decision" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Deny Reviewable</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form wire:submit.prevent="submit" class="form">
                    <div class="row mb-7">
                        <div class="col-md-12 d-flex flex-column fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Reason for denial</span>
                            </label>
                            <textarea wire:model="reason" class="form-control form-control-solid" rows="5"></textarea>
                            @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Deny</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#kt_modal_reviewable_decision').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>