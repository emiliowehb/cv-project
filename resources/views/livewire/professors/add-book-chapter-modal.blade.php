<div class="modal fade" id="kt_modal_add_book_chapter" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Book Chapter</h2>
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
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.book_type') }}</label>
                                <select class="form-select" wire:model="book_type_id" data-placeholder="{{ __('messages.book_type') }}" data-dropdown-parent="#kt_modal_add_book_chapter">
                                    @foreach($bookTypes as $bookType)
                                    <option value="{{$bookType->id}}">{{$bookType->name}}</option>
                                    @endforeach
                                </select>
                                @error('book_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-form-label required">{{ __('messages.book_name') }}</label>
                                    <input type="text" class="form-control bg-transparent" wire:model="book_name" placeholder="Book Name" />
                                    @error('book_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-form-label required">{{ __('messages.chapter_title') }}</label>
                                    <input type="text" class="form-control bg-transparent" wire:model="chapter_title" placeholder="Chapter Title" />
                                    @error('chapter_title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.publisher') }}</label>
                                <select class="form-select" wire:model="publisher_id" data-placeholder="{{ __('messages.publisher') }}" data-dropdown-parent="#kt_modal_add_book_chapter">
                                    @foreach($publishers as $publisher)
                                    <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                                @error('publisher_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.published_year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="published_year" placeholder="Year" />
                                @error('published_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.published_month') }}</label>
                                <select class="form-select" wire:model="published_month" data-placeholder="{{ __('messages.published_month') }}" data-dropdown-parent="#kt_modal_add_book_chapter">
                                    @foreach($months as $month)
                                    <option value="{{$month['key']}}">{{$month['value']}}</option>
                                    @endforeach
                                </select>
                                @error('published_month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.nb_pages') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="nb_pages" placeholder="Number of Pages" />
                                @error('nb_pages') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.volume') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="volume" placeholder="Volume" />
                                @error('volume') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.work_classification') }}</label>
                                <select class="form-select" wire:model="work_classification_id" data-placeholder="{{ __('messages.work_classification') }}" data-dropdown-parent="#kt_modal_add_book_chapter">
                                    @foreach($workClassifications as $workClassification)
                                    <option value="{{$workClassification->id}}">{{$workClassification->name}}</option>
                                    @endforeach
                                </select>
                                @error('work_classification_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.research_area') }}</label>
                                <select class="form-select" wire:model="research_area_id" data-placeholder="{{ __('messages.research_area') }}" data-dropdown-parent="#kt_modal_add_book_chapter">
                                    @foreach($researchAreas as $researchArea)
                                    <option value="{{$researchArea->id}}">{{$researchArea->name}}</option>
                                    @endforeach
                                </select>
                                @error('research_area_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <x-author-repeater class="App\Models\ProfessorBook" title="Manage Authors for Books" />

                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.intellectual_contribution') }}</label>
                                <select class="form-select" wire:model="intellectual_contribution_id" data-placeholder="{{ __('messages.intellectual_contribution') }}" data-dropdown-parent="#kt_modal_add_book_chapter">
                                    @foreach($intellectualContributions as $intellectualContribution)
                                    <option value="{{$intellectualContribution->id}}">{{$intellectualContribution->name}}</option>
                                    @endforeach
                                </select>
                                @error('intellectual_contribution_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('messages.notes') }}</label>
                                    <textarea class="form-control bg-transparent" wire:model="notes" placeholder="{{ __('messages.notes') }}"></textarea>
                                    @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#kt_modal_add_book_chapter').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>
