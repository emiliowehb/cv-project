<div wire:ignore.self class="modal fade" id="kt_modal_add_teaching_interest" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ $edit_mode ? 'Edit Teaching Interest' : 'Add Teaching Interest' }}</h2>
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
                        <div class="col-md-8 d-flex flex-column fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Teaching Interest</span>
                            </label>
                            <select wire:model="teaching_interest_id" class="form-select form-select-solid">
                                @foreach($teachingInterests as $teachingInterest)
                                <option value="{{ $teachingInterest->id }}">{{ $teachingInterest->name }}</option>
                                @endforeach
                            </select>
                            @error('teaching_interest_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 d-flex flex-column fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span>{{__('messages.current')}}</span>
                            </label>
                            <div class="form-check form-check-custom form-check-solid">
                                <input type="checkbox" class="form-check-input" name="is_current" value="{{$teachingInterest->is_current}}" wire:model="is_current"/>
                                <label class="form-check-label text-gray-700">{{__('messages.current')}}</label>
                            </div>
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
        $('#kt_modal_add_teaching_interest').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>