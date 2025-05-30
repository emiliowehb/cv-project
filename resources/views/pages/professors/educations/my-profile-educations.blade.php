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
            <x-professor-profile-card :professor="$professor"></x-professor-profile-card>
            <!-- end::Card -->
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