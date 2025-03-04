<x-default-admin-layout>

    @section('title')
    {{ __('messages.newspaper_articles') }}
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
                    <div class="card-toolbar">
                        <livewire:professor-submissions.reviewable-decision-modal></livewire:professor-submissions.reviewable-decision-modal>
                    </div>
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
                $('#kt_modal_reviewable_decision').modal('hide');
                window.LaravelDataTables['newspaper-article-reviewables-table'].ajax.reload();
            });

            Livewire.on('denyReviewable', function() {
                $('#kt_modal_reviewable_decision').modal('show');
            });
        });
    </script>
    @endpush

</x-default-admin-layout>