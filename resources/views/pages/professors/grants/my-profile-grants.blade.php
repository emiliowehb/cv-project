<x-default-layout>

    @section('title')
    Grants
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.my-profile.grants', $professor) }}
    @endsection

    <!--begin::Content-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Main Content-->
        <div class="flex-lg-row-fluid">
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
                            <!--begin::Add grant-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_grant">
                                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                                {{ __('messages.add_grant') }}
                            </button>
                            <!--end::Add grant-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal-->
                        <livewire:professor.add-grant-modal></livewire:professor.add-grant-modal>
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

            Livewire.on('success', function() {
                $('#kt_modal_add_grant').modal('hide');
                window.LaravelDataTables['professor-grant-table'].ajax.reload();
            });

            Livewire.on('update_grant', function() {
                $('#kt_modal_add_grant').modal('show');
            });
        });

        $('#kt_modal_add_degree').on('hidden.bs.modal', function() {
            Livewire.dispatch('add_degree');
        });

        $('#kt_modal_add_grant').on('hidden.bs.modal', function() {
            Livewire.dispatch('add_grant');
        });
    </script>
    @endpush

</x-default-layout>