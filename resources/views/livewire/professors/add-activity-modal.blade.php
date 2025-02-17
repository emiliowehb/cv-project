<div class="modal fade" id="kt_modal_add_activity" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_activity_header">
                <h2 class="fw-bold">Add Activity</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_activity_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_activity_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_activity_header"
                        data-kt-scroll-wrappers="#kt_modal_add_activity_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.activity_name') }}</label>
                                <input type="text" class="form-control bg-transparent" wire:model="name" placeholder="Activity Name" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.start_year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="start_year" placeholder="Start Year" />
                                @error('start_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">{{ __('messages.end_year') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="end_year" placeholder="End Year" />
                                @error('end_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2 col-form-label">
                                    <span>{{__('messages.current')}}</span>
                                </label>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input type="checkbox" class="form-check-input" name="is_current" wire:model="is_current" />
                                    <label class="form-check-label text-gray-700">{{__('messages.current')}}</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.activity_service_type') }}</label>
                                <select class="form-select" data-placeholder="{{__('messages.add_activity_service_type') }}" name="activity_service_id" wire:model="activity_service_id" data-dropdown-parent="#kt_modal_add_activity">
                                    @foreach($activityServices as $activityService)
                                    <option value="{{$activityService->id}}">{{$activityService->name}}</option>
                                    @endforeach
                                </select>
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
        $('#kt_modal_add_activity').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>