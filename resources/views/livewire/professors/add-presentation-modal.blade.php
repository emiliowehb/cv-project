<div class="modal fade" id="kt_modal_add_presentation" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_presentation_header">
                <h2 class="fw-bold">{{ $edit_mode ? __('messages.edit_presentation') : __('messages.add_presentation') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_presentation_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_presentation_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_presentation_header"
                        data-kt-scroll-wrappers="#kt_modal_add_presentation_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.presentation_name') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="name" placeholder="{{ __('messages.presentation_name') }}" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="year" placeholder="{{ __('messages.year') }}" />
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.month') }}</label>
                                <select class="form-select" wire:model="month" data-placeholder="{{ __('messages.select_month') }}" data-dropdown-parent="#kt_modal_add_presentation">
                                    @foreach($months as $month)
                                    <option value="{{ $month['key'] }}">{{ $month['value'] }}</option>
                                    @endforeach
                                </select>
                                @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="col-form-label">{{ __('messages.days') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="days" placeholder="{{ __('messages.days') }}" />
                                @error('days') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="col-form-label">{{ __('messages.event_name') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="event_name" placeholder="{{ __('messages.event_name') }}" />
                                @error('event_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.country') }}</label>
                                <select class="form-select" wire:model="country_id" data-placeholder="{{ __('messages.select_country') }}" data-dropdown-parent="#kt_modal_add_presentation">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.town') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="town" placeholder="{{ __('messages.town') }}" />
                                @error('town') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.intellectual_contribution') }}</label>
                                <select class="form-select" wire:model="intellectual_contribution_id" data-placeholder="{{ __('messages.select_intellectual_contribution') }}" data-dropdown-parent="#kt_modal_add_presentation">
                                    @foreach($intellectualContributions as $contribution)
                                    <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                    @endforeach
                                </select>
                                @error('intellectual_contribution_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2 col-form-label">
                                    <span>{{__('messages.published_in_proceedings')}}</span>
                                </label>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input type="checkbox" class="form-check-input" name="is_published_in_proceedings" wire:model="is_published_in_proceedings" />
                                    <label class="form-check-label text-gray-700">{{__('messages.published_in_proceedings')}}</label>
                                </div>
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
        $('#kt_modal_add_presentation').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>
