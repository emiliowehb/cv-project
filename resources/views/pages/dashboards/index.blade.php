<x-default-layout>

    @section('title')
    Dashboard
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-md-5 mb-xl-10">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title">Add Personal Information</h3>
                    <p class="card-text">Welcome <strong>{{Auth::user()->first_name . ' ' . Auth::user()->last_name }}</strong>, it seems like you still have not uploaded any of your personal information. Please add your credentials and expertise to complete your profile.</p>
                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_personal_info">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add Information
                    </button>
                    <!--end::Add user-->
                    
                </div>
                <!--begin::Modal-->
                <livewire:facultymember.add-personal-info-modal></livewire:facultymember.add-personal-info-modal>
                <!--end::Modal-->
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-default-layout>