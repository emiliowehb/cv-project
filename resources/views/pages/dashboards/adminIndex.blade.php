<x-default-layout>

    @section('title')
        Workspace Admin Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-md-5 mb-xl-10">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Workspace Information</h3>
                    <p class="card-text">Welcome <strong>{{Auth::user()->first_name . ' ' . Auth::user()->last_name }}</strong>, here is the information about your workspace.</p>
                    <div class="row">
                        <div class="col-3 fw-bold">Workspace name</div>
                        <div class="col-3">{{Auth::user()->workspace->name}}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3 fw-bold">Workspace members:</div>
                        <div class="col-3"><i>Render member names here...</i></div>
                    </div>
                <div class="row mt-7">
                    <div class="col-12">
                        <a href="#" class="btn btn-primary btn-sm">Access Workspace Settings</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-default-layout>
