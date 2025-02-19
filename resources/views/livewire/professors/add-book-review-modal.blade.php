<div class="modal fade" id="kt_modal_add_book_review" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('messages.add_book_review') }}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}">
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
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.reviewed_medium') }}</label>
                                <select class="form-select" wire:model="reviewed_medium_id" data-placeholder="{{ __('messages.reviewed_medium') }}" data-dropdown-parent="#kt_modal_add_book_review">
                                    @foreach($reviewedMedia as $medium)
                                    <option value="{{$medium->id}}">{{$medium->name}}</option>
                                    @endforeach
                                </select>
                                @error('reviewed_medium_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-form-label required">{{ __('messages.name') }}</label>
                                    <input type="text" class="form-control bg-transparent" wire:model="name" placeholder="{{ __('messages.name') }}" />
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="year" placeholder="{{ __('messages.year') }}" />
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.month') }}</label>
                                <select class="form-select" wire:model="month" data-placeholder="{{ __('messages.month') }}" data-dropdown-parent="#kt_modal_add_book_review">
                                    @foreach($months as $month)
                                    <option value="{{$month['key']}}">{{$month['value']}}</option>
                                    @endforeach
                                </select>
                                @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.periodical_title') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="periodical_title" placeholder="{{ __('messages.periodical_title') }}" />
                                @error('periodical_title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.reviewed_work_authors') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="reviewed_work_authors" placeholder="{{ __('messages.reviewed_work_authors') }}" />
                                @error('reviewed_work_authors') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.intellectual_contribution') }}</label>
                                <select class="form-select" wire:model="intellectual_contribution_id" data-placeholder="{{ __('messages.intellectual_contribution') }}" data-dropdown-parent="#kt_modal_add_book_review">
                                    @foreach($intellectualContributions as $contribution)
                                    <option value="{{$contribution->id}}">{{$contribution->name}}</option>
                                    @endforeach
                                </select>
                                @error('intellectual_contribution_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="col-form-label">{{ __('messages.notes') }}</label>
                                <textarea class="form-control bg-transparent" wire:model="notes" placeholder="{{ __('messages.notes') }}"></textarea>
                                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"
                                wire:loading.attr="disabled">{{ __('messages.discard') }}</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label" wire:loading.remove>{{ __('messages.submit') }}</span>
                                <span class="indicator-progress" wire:loading wire:target="submit">
                                    {{ __('messages.please_wait') }}
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
        $('#kt_modal_add_book_review').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>