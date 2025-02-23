<div wire:ignore.self class="modal fade" id="kt_modal_add_expertise_area" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ $edit_mode ? __('messages.edit_expertise_area') : __('messages.add_expertise_area') }}</h2>
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
                                <span class="required">Expertise Area</span>
                            </label>
                            <select wire:model="expertise_area_id" class="form-select form-select-solid">
                                @foreach($expertiseAreas as $expertiseArea)
                                <option value="{{ $expertiseArea->id }}">{{ $expertiseArea->name }}</option>
                                @endforeach
                            </select>
                            @error('expertise_area_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('messages.discard') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">{{ $edit_mode ? __('messages.update') : __('messages.add') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#kt_modal_add_expertise_area').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>