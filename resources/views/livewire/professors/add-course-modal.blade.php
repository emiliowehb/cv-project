
<div class="modal fade" id="kt_modal_add_course" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_course_header">
                <h2 class="fw-bold">{{ $edit_mode ? __('messages.edit_course') : __('messages.add_course') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_course_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_course_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_course_header"
                        data-kt-scroll-wrappers="#kt_modal_add_course_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.course_code') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="code" placeholder="{{ __('messages.course_code') }}" />
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="col-form-label required">{{ __('messages.course_title') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="title" placeholder="{{ __('messages.course_title') }}" />
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.language') }}</label>
                                <select class="form-select" wire:model="language_id" data-placeholder="{{ __('messages.select_language') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @error('language_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.course_level') }}</label>
                                <select class="form-select" wire:model="course_level_id" data-placeholder="{{ __('messages.select_course_level') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($courseLevels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_level_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.course_type') }}</label>
                                <select class="form-select" wire:model="course_type_id" data-placeholder="{{ __('messages.select_course_type') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($courseTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.course_credit') }}</label>
                                <select class="form-select" wire:model="course_credit_id" data-placeholder="{{ __('messages.select_course_credit') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($courseCredits as $credit)
                                    <option value="{{ $credit->id }}">{{ $credit->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_credit_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.course_category') }}</label>
                                <select class="form-select" wire:model="course_category_id" data-placeholder="{{ __('messages.select_course_category') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($courseCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_category_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.course_program') }}</label>
                                <select class="form-select" wire:model="course_program_id" data-placeholder="{{ __('messages.select_course_program') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($coursePrograms as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_program_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.course_topic') }}</label>
                                <select class="form-select" wire:model="course_topic_id" data-placeholder="{{ __('messages.select_course_topic') }}" data-dropdown-parent="#kt_modal_add_course">
                                    @foreach($courseTopics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->subject->name }}: {{ $topic->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_topic_id') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#kt_modal_add_course').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>