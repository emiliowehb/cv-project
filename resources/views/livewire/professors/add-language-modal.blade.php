<div wire:ignore.self class="modal fade" id="kt_modal_add_language" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ $edit_mode ? 'Edit Language' : 'Add Language' }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form wire:submit.prevent="submit" class="form">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span class="required">Language</span>
                        </label>
                        <select wire:model="language_id" class="form-select form-select-solid">
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                        @error('language_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span class="required">Spoken Level</span>
                        </label>
                        <select wire:model="spoken_language_level_id" class="form-select form-select-solid">
                            @foreach($languageLevels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        @error('spoken_language_level_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                            <span class="required">Written Level</span>
                        </label>
                        <select wire:model="written_language_level_id" class="form-select form-select-solid">
                            @foreach($languageLevels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                        @error('written_language_level_id') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#kt_modal_add_language').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>
