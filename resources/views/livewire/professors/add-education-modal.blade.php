<div class="modal fade" id="kt_modal_add_degree" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add degree</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" wire:submit.prevent="submit">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label required">{{ __('messages.degree_obtained_year') }}</label>
                                    <input type="number" class="form-control bg-transparent" wire:model="year" placeholder="Year" />
                                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="col-form-label required">{{ __('messages.degree_type') }}</label>
                                <select class="form-select country-selector" wire:model="degree_id"  data-placeholder="Select a degree" data-dropdown-parent="#kt_modal_add_degree">
                                    @foreach($degrees as $degree)
                                    <option value="{{$degree->id}}">{{$degree->name}}</option>
                                    @endforeach
                                </select>
                                @error('degree_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <label class="col-form-label required">{{ __('messages.discipline') }}</label>
                                <select class="form-select country-selector" wire:model="discipline_id"  data-placeholder="Select a degree discipline" data-dropdown-parent="#kt_modal_add_degree">
                                    @foreach($disciplines as $discipline)
                                    <option value="{{$discipline->id}}">{{$discipline->name}}</option>
                                    @endforeach
                                </select>
                                @error('discipline_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.department') }}</label>
                                <select class="form-select country-selector" wire:model="department_id"  data-placeholder="Select a department" data-dropdown-parent="#kt_modal_add_degree">
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#kt_modal_add_degree').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>