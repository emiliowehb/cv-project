<div class="modal fade" id="kt_modal_add_grant" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_grant_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{ __('messages.add_grant') }}</h2>
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
                <form id="kt_modal_add_grant_form" class="form" wire:submit.prevent="submit">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_grant_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_grant_header"
                        data-kt-scroll-wrappers="#kt_modal_add_grant_scroll" data-kt-scroll-offset="300px">
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="col-form-label required">{{ __('messages.grant_name') }}</label>
                                    <input type="text" class="form-control bg-transparent" wire:model="name" placeholder="{{ __('messages.grant_name') }}" />
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.grant_amount') }}</label>
                                <input type="number" class="form-control bg-transparent" wire:model="amount" placeholder="{{ __('messages.amount') }}" />
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label  required">{{ __('messages.start_date') }}</label>
                                <input class="form-control form-control-solid" placeholder="{{ __('messages.start_date') }}" wire:model="start_date" id="start_date" name="start_date" />
                            </div>
                            <div class="col-6">
                                <label class="col-form-label  required">{{ __('messages.end_date') }}</label>
                                <input class="form-control form-control-solid" placeholder="{{ __('messages.end_date') }}" wire:model="end_date" id="end_date" name="end_date" />
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.grant_type') }}</label>
                                <select class="form-select" wire:model="grant_type_id" data-placeholder="{{ __('messages.select_grant_type') }}" data-dropdown-parent="#kt_modal_add_grant">
                                    @foreach($grantTypes as $grantType)
                                    <option value="{{$grantType->id}}">{{$grantType->name}}</option>
                                    @endforeach
                                </select>
                                @error('grant_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.currency') }}</label>
                                <select class="form-select" wire:model="currency_id" data-placeholder="{{ __('messages.select_currency') }}" data-dropdown-parent="#kt_modal_add_grant">
                                    @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->name}}</option>
                                    @endforeach
                                </select>
                                @error('currency_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.funding_source') }}</label>
                                <select class="form-select" wire:model="funding_source_id" data-placeholder="{{ __('messages.select_funding_source') }}" data-dropdown-parent="#kt_modal_add_grant">
                                    @foreach($fundingSources as $fundingSource)
                                    <option value="{{$fundingSource->id}}">{{$fundingSource->name}}</option>
                                    @endforeach
                                </select>
                                @error('funding_source_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">{{ __('messages.role') }}</label>
                                <select class="form-select" wire:model="role" data-placeholder="{{ __('messages.select_role') }}" data-dropdown-parent="#kt_modal_add_grant">
                                    @foreach($roles as $role)
                                    <option value="{{$role}}">{{$role}}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('messages.notes') }}</label>
                                    <textarea class="form-control bg-transparent" wire:model="notes" placeholder="{{ __('messages.notes') }}"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
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
    document.addEventListener('DOMContentLoaded', function () {
        $("#start_date").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            drops: "up",
            maxYear: parseInt(moment().format("YYYY"), 12)
        }, function(start) {
            @this.call('updateStartDate', start.format('DD/MM/YYYY'));
        });

        $("#end_date").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            drops: "up",
            maxYear: parseInt(moment().format("YYYY"), 12)
        }, function(end) {
            @this.call('updateEndDate', end.format('DD/MM/YYYY'));
        });

        $('#kt_modal_add_grant').on('hidden.bs.modal', function () {
            @this.call('resetForm');
        });
    });
</script>