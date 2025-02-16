<div wire:ignore.self class="modal fade" id="kt_modal_add_research_interest" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ $edit_mode ? 'Edit Research Interest' : 'Add Research Interest' }}</h2>
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
                                <span class="required">Research Interest</span>
                            </label>
                            <select wire:model="research_area_id" class="form-select form-select-solid">
                                @foreach($researchInterests as $researchInterest)
                                <option value="{{ $researchInterest->id }}">{{ $researchInterest->name }}</option>
                                @endforeach
                            </select>
                            @error('research_area_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">{{ $edit_mode ? 'Update' : 'Add' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#kt_modal_add_research_interest').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>