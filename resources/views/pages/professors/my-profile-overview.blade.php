<x-default-layout>
    @section('title')
    Users
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.my-profile.overview', $professor) }}
    @endsection

    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <x-professor-profile-card :professor="$professor"></x-professor-profile-card>

            <!--end::Card-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Personal Information</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_schedule">
                                    <i class="ki-duotone ki-brush fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Edit Information
                                </button>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-10 pt-4">
                            <div class="row mb-2">
                                <div class="col-3">
                                    <h6>First Name</h6>
                                </div>
                                <div class="col-3">
                                    <span>{{$professor->first_name}}</span>
                                </div>

                                <div class="col-3">
                                    <h6>Last Name</h6>
                                </div>
                                <div class="col-3">
                                    <span>
                                        {{ $professor->last_name }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3">
                                    <h6>Middle Name</h6>
                                </div>
                                <div class="col-3">
                                    <span>
                                        {{ $professor->middle_name ? $professor->middle_name : '—' }}
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h6>Gender</h6>
                                </div>
                                <div class="col-3">
                                    <span>{{$professor->gender == 1 ? 'Male' : 'Female'}}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3">
                                    <h6>Email Address</h6>
                                </div>
                                <div class="col-3">
                                    <span>
                                        {{ $professor->email }}
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h6>Office / Work Email</h6>
                                </div>
                                <div class="col-3">
                                    <span>{{$professor->office_email }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <h6>Workspace Name:</h6>
                                </div>
                                <div class="col-3">
                                    <span>
                                        {{ $professor->workspace->name }}
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h6>Workspace Owner</h6>
                                </div>
                                <div class="col-3">
                                    <span>{{$professor->workspace->owner->first_name . ' ' . $professor->workspace->owner->last_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->
                    <!--begin::Tasks-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Professor's Tasks</h2>
                                <div class="fs-6 fw-semibold text-muted">Tasks to complete your profile</div>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Add publications (Books, Chapters, Papers...)</a>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-semibold ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">Provide supporting documents</a>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Tasks-->
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <livewire:user.add-user-modal></livewire:user.add-user-modal>
        <!--end::Content-->
    </div>
</x-default-layout>