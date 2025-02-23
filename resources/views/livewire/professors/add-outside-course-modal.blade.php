<div class="modal fade" id="kt_modal_add_outside_course" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_outside_course_header">
                <h2 class="fw-bold">{{ $edit_mode ? __('messages.edit_course') : __('messages.add_course') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_outside_course_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_outside_course_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_outside_course_header"
                        data-kt-scroll-wrappers="#kt_modal_add_outside_course_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.course_name') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="name" placeholder="{{ __('messages.course_name') }}" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.institution') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="institution" placeholder="{{ __('messages.institution') }}" />
                                @error('institution') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="year" placeholder="{{ __('messages.year') }}" />
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.country') }}</label>
                                <select class="form-select" wire:model="country_id" data-placeholder="{{ __('messages.select_country') }}" data-dropdown-parent="#kt_modal_add_outside_course">
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
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.language') }}</label>
                                <select class="form-select" wire:model="language_id" data-placeholder="{{ __('messages.select_language') }}" data-dropdown-parent="#kt_modal_add_outside_course">
                                    @foreach($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @error('language_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2 col-form-label">
                                    <span>{{__('messages.is_graduate_course')}}</span>
                                </label>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input type="checkbox" class="form-check-input" name="is_graduate" wire:model="is_graduate" />
                                    <label class="form-check-label text-gray-700">{{__('messages.is_graduate_course')}}</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.session') }}</label>
                                <select class="form-select" wire:model="session_id" data-placeholder="{{ __('messages.select_session') }}" data-dropdown-parent="#kt_modal_add_outside_course">
                                    @foreach($sessions as $session)
                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                    @endforeach
                                </select>
                                @error('session_id') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#kt_modal_add_outside_course').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>
