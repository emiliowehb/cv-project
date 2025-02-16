<div class="modal fade" id="kt_modal_add_employment" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Employment</h2>
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
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label required">Employer</label>
                                    <input type="text" class="form-control bg-transparent" wire:model="employer" placeholder="Employer" />
                                    @error('employer') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Country</label>
                                <select class="form-select country-selector" wire:model="country_id" data-placeholder="Select a country" data-dropdown-parent="#kt_modal_add_employment">
                                    @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Position</label>
                                <select class="form-select country-selector" wire:model="position_id" data-placeholder="Select a position" data-dropdown-parent="#kt_modal_add_employment">
                                    @foreach($positions as $position)
                                    <option value="{{$position->id}}">{{$position->name}}</option>
                                    @endforeach
                                </select>
                                @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="col-form-label required">Start Year</label>
                                    <input type="number" class="form-control bg-transparent" wire:model="start_year" placeholder="Start Year" />
                                    @error('start_year') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="col-form-label">End Year</label>
                                    <input type="number" class="form-control bg-transparent" wire:model="end_year" placeholder="End Year" />
                                    @error('end_year') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center mt-10">
                                    <div class="checkbox-inline">
                                        <div class="mb-2">
                                            <label class="checkbox form-check-label  text-gray-700">
                                                <input type="checkbox" class="form-check-input" wire:model="is_current" name="is_current">
                                                <span></span>
                                                {{__('messages.current')}}
                                            </label>
                                        </div>
                                        <div>
                                            <label class="checkbox form-check-label text-gray-700">
                                                <input type="checkbox" class="form-check-input" wire:model="is_full_time" name="is_full_time">
                                                <span></span>
                                                {{__('messages.fulltime')}}
                                            </label>
                                        </div>
                                    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        $('#kt_modal_add_employment').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>