<x-default-layout>

    @section('title')
    {{ __('messages.chapters_in_books') }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.my-profile.book-chapters', $professor) }}
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
                            <!--begin::Add book chapter-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_book_chapter">
                                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                                {{ __('messages.add_book_chapter') }}
                            </button>
                            <!--end::Add book chapter-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal-->
                        <livewire:professor.add-book-chapter-modal></livewire:professor.add-book-chapter-modal>
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
                $('#kt_modal_add_book_chapter').modal('hide');
                window.LaravelDataTables['professor-book-chapters-table'].ajax.reload();
            });

            Livewire.on('update_chapter', function() {
                $('#kt_modal_add_book_chapter').modal('show');
            });
        });

        $('#kt_modal_add_book_chapter').on('hidden.bs.modal', function() {
            Livewire.dispatch('add_book_chapter');
        });
    </script>
    @endpush

</x-default-layout>