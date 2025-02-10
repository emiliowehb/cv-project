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