<div class="modal fade" id="kt_modal_add_supervision" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_graduate_supervision_header">
                <h2 class="fw-bold">{{ $edit_mode ? 'Edit Graduate Supervision' : 'Add Graduate Supervision' }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_graduate_supervision_form" class="form" wire:submit.prevent="submit">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_graduate_supervision_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_graduate_supervision_header"
                        data-kt-scroll-wrappers="#kt_modal_add_graduate_supervision_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-6">
                                <label class="col-form-label required">First Name</label>
                                <input type="text" class="form-control bg-transparent" wire:model="student_first_name" placeholder="First Name" />
                                @error('student_first_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Last Name</label>
                                <input type="text" class="form-control bg-transparent" wire:model="student_last_name" placeholder="Last Name" />
                                @error('student_last_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Start Year</label>
                                <input type="number" class="form-control bg-transparent" wire:model="start_year" placeholder="Start Year" />
                                @error('start_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Start Month</label>
                                <select class="form-select" wire:model="start_month" data-placeholder="Start Month" data-dropdown-parent="#kt_modal_add_graduate_supervision">
                                    @foreach($months as $month)
                                    <option value="{{$month['key']}}">{{$month['value']}}</option>
                                    @endforeach
                                </select>
                                @error('start_month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">End Year</label>
                                <input type="number" class="form-control bg-transparent" wire:model="end_year" placeholder="End Year" />
                                @error('end_year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">End Month</label>
                                <select class="form-select" wire:model="end_month" data-placeholder="End Month" data-dropdown-parent="#kt_modal_add_graduate_supervision">
                                    @foreach($months as $month)
                                    <option value="{{$month['key']}}">{{$month['value']}}</option>
                                    @endforeach
                                </select>
                                @error('end_month') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Program Area</label>
                                <input type="text" class="form-control bg-transparent" wire:model="student_program_area" placeholder="Program Area" />
                                @error('student_program_area') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Program Name</label>
                                <input type="text" class="form-control bg-transparent" wire:model="student_program_name" placeholder="Program Name" />
                                @error('student_program_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Study Program</label>
                                <select class="form-select" wire:model="study_program_id" data-placeholder="Study Program" data-dropdown-parent="#kt_modal_add_graduate_supervision">
                                    @foreach($studyPrograms as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                                @error('study_program_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Supervision Status</label>
                                <select class="form-select" wire:model="supervision_status_id" data-placeholder="Supervision Status" data-dropdown-parent="#kt_modal_add_graduate_supervision">
                                    @foreach($supervisionStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('supervision_status_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Supervision Role</label>
                                <select class="form-select" wire:model="supervision_role_id" data-placeholder="Supervision Role" data-dropdown-parent="#kt_modal_add_graduate_supervision">
                                    @foreach($supervisionRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('supervision_role_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label class="col-form-label required">Student Type</label>
                                <select class="form-select" wire:model="student_type" data-placeholder="Student Type" data-dropdown-parent="#kt_modal_add_graduate_supervision">
                                    <option value="undergraduate">Undergraduate</option>
                                    <option value="graduate">Graduate</option>
                                    <option value="doctoral">Doctoral</option>
                                </select>
                                @error('student_type') <span class="text-danger">{{ $message }}</span> @enderror
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
        $('#kt_modal_add_supervision').on('hidden.bs.modal', function() {
            @this.call('resetForm');
        });
    });
</script>