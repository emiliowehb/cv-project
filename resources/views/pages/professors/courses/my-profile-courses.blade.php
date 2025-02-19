<x-default-layout>

    @section('title')
    {{ __('messages.courses') }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.my-profile.courses', $professor) }}
    @endsection

    <!--begin::Content-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Main Content-->
        <div class="flex-lg-row-fluid ms-lg-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0">
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
                            <!--begin::Add course-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_course">
                                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                                {{ __('messages.add_course') }}
                            </button>
                            <!--end::Add course-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal-->
                        <livewire:professor.add-course-modal></livewire:professor.add-course-modal>
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
                $('#kt_modal_add_course').modal('hide');
                window.LaravelDataTables['professor-courses-table'].ajax.reload();
            });

            Livewire.on('update_course', function() {
                $('#kt_modal_add_course').modal('show');
            });
        });

        $('#kt_modal_add_course').on('hidden.bs.modal', function() {
            Livewire.dispatch('add_course');
        });
    </script>
    @endpush

</x-default-layout>