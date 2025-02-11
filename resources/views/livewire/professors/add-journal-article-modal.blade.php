<div class="modal fade" id="kt_modal_add_journal_article" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_journal_article_header">
                <h2 class="fw-bold">{{ $edit_mode ? 'Edit Journal Article' : 'Add Journal Article' }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_journal_article_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_journal_article_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_journal_article_header"
                        data-kt-scroll-wrappers="#kt_modal_add_journal_article_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="year" placeholder="{{ __('messages.year') }}" />
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.month') }}</label>
                                <select class="form-select" wire:model="month" data-placeholder="{{ __('messages.month') }}" data-dropdown-parent="#kt_modal_add_journal_article">
                                    @foreach($months as $id => $month)
                                    <option value="{{$month}}">{{$month}}</option>
                                    @endforeach
                                </select>
                                @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.title') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="title" placeholder="Title" />
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.article_type') }}</label>
                                <select class="form-select" wire:model="journal_article_type_id" data-placeholder="{{ __('messages.article_type') }}" data-dropdown-parent="#kt_modal_add_journal_article">
                                    @foreach($articleTypes as $articleType)
                                    <option value="{{$articleType->id}}">{{$articleType->name}}</option>
                                    @endforeach
                                </select>
                                @error('journal_article_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.publication_status') }}</label>
                                <select class="form-select" wire:model="publication_status_id" data-placeholder="{{ __('messages.publication_status') }}" data-dropdown-parent="#kt_modal_add_journal_article">
                                    @foreach($publicationStatuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                                @error('publication_status_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.title') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="title" placeholder="Title" />
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.volume') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="volume" placeholder="Volume" />
                                @error('volume') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.issue') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="issue" placeholder="Issue" />
                                @error('issue') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.pages') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="pages" placeholder="Pages" />
                                @error('pages') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.primary_field') }}</label>
                                <select class="form-select" wire:model="primary_field_id" data-placeholder="{{ __('messages.primary_field') }}" data-dropdown-parent="#kt_modal_add_journal_article">
                                    @foreach($primaryFields as $field)
                                    <option value="{{$field->id}}">{{$field->name}}</option>
                                    @endforeach
                                </select>
                                @error('primary_field_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.secondary_field') }}</label>
                                <select class="form-select" wire:model="secondary_field_id" data-placeholder="{{ __('messages.secondary_field') }}" data-dropdown-parent="#kt_modal_add_journal_article">
                                    @foreach($secondaryFields as $field)
                                    <option value="{{$field->id}}">{{$field->name}}</option>
                                    @endforeach
                                </select>
                                @error('secondary_field_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                            wire:loading.attr="disabled">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
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
        $('#kt_modal_add_journal_article').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>