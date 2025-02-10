<x-default-layout>

    @section('title')
    Educations
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.my-profile.educations', $professor) }}
    @endsection

    <!--begin::Content-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Summary-->
                <!--begin::User Info-->
                <div class="d-flex flex-center flex-column py-5 position-relative">
                <!--begin::Avatar-->
                <div class="symbol symbol-100px symbol-circle mb-7">
                    @if($professor->user->profile_photo_url)
                    <img src="{{ asset('storage/' . $professor->user->profile_photo_path) }}" alt="image" />
                    @else
                    <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $professor->first_name . ' ' . $professor->last_name) }}">
                    {{ $professor->first_name[0] . $professor->last_name[0] }}
                    </div>
                    @endif
                    <!--begin::Edit Icon-->
                    <a href="#" class="position-absolute top-0 end-0 translate-middle" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                    {!! getIcon('pencil', 'fs-2', '', 'i') !!}
                    </a>
                    <!--end::Edit Icon-->
                </div>
                <!--end::Avatar-->
                <!--begin::Name-->
                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $professor->first_name . ' ' . $professor->last_name }}</a>
                <!--end::Name-->
                <!--begin::Position-->
                <div class="mb-9">
                    <!--begin::Badge-->
                    <div class="badge badge-lg badge-light-primary d-inline">{{ ucfirst($professor->user->role) }}</div>
                    <!--begin::Badge-->
                </div>
                <!--end::Position-->
                </div>
                <!--end::User Info-->
                <!--end::Summary-->
            </div>
            <!--end::Card body-->
            </div>
        </div>
        <!--end::Sidebar-->

        <!--begin::Main Content-->
        <div class="flex-lg-row-fluid ms-lg-10">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add degree-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_degree">
                                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                                Add degree
                            </button>
                            <!--end::Add degree-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal-->
                        <livewire:professor.add-education-modal></livewire:professor.add-education-modal>
                        <livewire:user.add-user-modal></livewire:user.add-user-modal>
                        <!--end::Modal-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Main Content-->
    </div>
    <!--end::Content-->

    @push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('success', function() {
                $('#kt_modal_add_degree').modal('hide');
                window.LaravelDataTables['professor-degree-table'].ajax.reload();
            });

            Livewire.on('update_degree', function() {
                $('#kt_modal_add_degree').modal('show');
            });
        });

        $('#kt_modal_add_degree').on('hidden.bs.modal', function() {
            Livewire.dispatch('add_degree');
        });
    </script>
    @endpush

</x-default-layout>