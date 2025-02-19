<div class="modal fade" id="kt_modal_add_report" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_technical_report_header">
                <h2 class="fw-bold">{{ $edit_mode ? __('messages.edit_technical_report') : __('messages.add_technical_report') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_technical_report_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_technical_report_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_technical_report_header"
                        data-kt-scroll-wrappers="#kt_modal_add_technical_report_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="year" placeholder="{{ __('messages.year') }}" />
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.month') }}</label>
                                <select class="form-select" wire:model="month" data-placeholder="{{ __('messages.month') }}" data-dropdown-parent="#kt_modal_add_technical_report">
                                    @foreach($months as $month)
                                    <option value="{{$month['key']}}">{{$month['value']}}</option>
                                    @endforeach
                                </select>
                                @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.publisher') }}</label>
                                <select class="form-select" wire:model="publisher_id" data-placeholder="{{ __('messages.select_publisher') }}" data-dropdown-parent="#kt_modal_add_technical_report">
                                    @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                                @error('publisher_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.identifying_number') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="identifying_number" placeholder="{{ __('messages.identifying_number') }}" />
                                @error('identifying_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.volume') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="volume" placeholder="{{ __('messages.volume') }}" />
                                @error('volume') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.nb_pages') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="nb_pages" placeholder="{{ __('messages.nb_pages') }}" />
                                @error('nb_pages') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.work_classification') }}</label>
                                <select class="form-select" wire:model="work_classification_id" data-placeholder="{{ __('messages.select_work_classification') }}" data-dropdown-parent="#kt_modal_add_technical_report">
                                    @foreach($workClassifications as $classification)
                                    <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                                @error('work_classification_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.research_area') }}</label>
                                <select class="form-select" wire:model="research_area_id" data-placeholder="{{ __('messages.select_research_area') }}" data-dropdown-parent="#kt_modal_add_technical_report">
                                    @foreach($researchAreas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                                @error('research_area_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.notes') }}</label>
                                <textarea class="form-control bg-transparent" wire:model="notes" placeholder="{{ __('messages.notes') }}"></textarea>
                                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.publication_status') }}</label>
                                <select class="form-select" wire:model="publication_status_id" data-placeholder="{{ __('messages.select_publication_status') }}" data-dropdown-parent="#kt_modal_add_technical_report">
                                    @foreach($publicationStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('publication_status_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.intellectual_contribution') }}</label>
                                <select class="form-select" wire:model="intellectual_contribution_id" data-placeholder="{{ __('messages.select_intellectual_contribution') }}" data-dropdown-parent="#kt_modal_add_technical_report">
                                    @foreach($intellectualContributions as $contribution)
                                    <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                    @endforeach
                                </select>
                                @error('intellectual_contribution_id') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#kt_modal_add_technical_report').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>
