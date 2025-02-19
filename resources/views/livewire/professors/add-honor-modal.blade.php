<div class="modal fade" id="kt_modal_add_honor" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_honor_header">
                <h2 class="fw-bold">{{ $edit_mode ? __('messages.edit_honor') : __('messages.add_honor') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_honor_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_honor_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_honor_header"
                        data-kt-scroll-wrappers="#kt_modal_add_honor_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.honor_name') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="name" placeholder="{{ __('messages.honor_name') }}" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.honor_type') }}</label>
                                <select class="form-select" wire:model="honor_type_id" data-placeholder="{{ __('messages.select_honor_type') }}" data-dropdown-parent="#kt_modal_add_honor">
                                    @foreach($honorTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('honor_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.honor_organization') }}</label>
                                <select class="form-select" wire:model="honor_organization_id" data-placeholder="{{ __('messages.select_honor_organization') }}" data-dropdown-parent="#kt_modal_add_honor">
                                    @foreach($honorOrganizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                </select>
                                @error('honor_organization_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.start_year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="start_year" placeholder="{{ __('messages.start_year') }}" />
                                @error('start_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.end_year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="end_year" placeholder="{{ __('messages.end_year') }}" />
                                @error('end_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2 col-form-label">
                                    <span>{{__('messages.is_ongoing')}}</span>
                                </label>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input type="checkbox" class="form-check-input" name="is_ongoing" wire:model="is_ongoing" />
                                    <label class="form-check-label text-gray-700">{{__('messages.is_ongoing')}}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="col-form-label">{{ __('messages.notes') }}</label>
                                <textarea class="form-control bg-transparent" wire:model="notes" placeholder="{{ __('messages.notes') }}"></textarea>
                                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                            wire:loading.attr="disabled">{{ __('messages.discard') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>{{ __('messages.submit') }}</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                {{ __('messages.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#kt_modal_add_honor').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>
