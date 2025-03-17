<x-default-layout>
    @section('title')
    Professors Directory
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.directory.profile') }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <div class="card mb-5 mb-xl-8">
                <div class="card-body">
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            @if($professor->user->profile_photo_url)
                                <img src="{{ asset('storage/' . $professor->user->profile_photo_path) }}" alt="image"/>
                            @else
                                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $professor->first_name . ' ' . $professor->last_name) }}">
                                    {{ substr($professor->first_name . ' ' . $professor->last_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $professor?->first_name }} {{ $professor?->last_name }}</a>
                    </div>
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible active" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="true" aria-controls="kt_user_view_details">
                            Details
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                    </div>
                    <div class="separator"></div>
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <div class="fw-bold mt-5">Email</div>
                            <div class="text-gray-600">
                                <a href="mailto:{{ $professor?->email }}" class="text-gray-600 text-hover-primary">{{ $professor?->email }}</a>
                            </div>
                            <div class="fw-bold mt-5">Office Email</div>
                            <div class="text-gray-600">
                                <a href="mailto:{{ $professor?->office_email }}" class="text-gray-600 text-hover-primary">{{ $professor?->office_email }}</a>
                            </div>
                            @if($professor?->address)
                            <div class="fw-bold mt-5">Address</div>
                            <div class="text-gray-600">
                                {{ $professor?->address?->address_line_1 }}<br>
                                @if($professor?->address?->address_line_2)
                                {{ $professor?->address?->address_line_2 }}<br>
                                @endif
                                {{ $professor?->address?->postal_code }} {{ $professor?->address?->city }}@if($professor?->address?->state), {{ $professor?->address?->state }}@endif<br>
                                {{ $professor?->address?->country->name }}
                            </div>
                            @endif
                            <div class="fw-bold mt-5">Gender</div>
                            <div class="text-gray-600">{{ $professor?->gender ? 'Male' : 'Female' }}</div>
                            <div class="fw-bold mt-5">Date of birth</div>
                            <div class="text-gray-600">{{ $professor?->birth_date }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="card pt-4 mb-6 mb-xl-9">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h2>Degrees</h2>
                    </div>
                </div>
                <div class="card-body pt-0 pb-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5">
                            <tbody class="fs-6 fw-semibold text-gray-600">
                                @foreach($professor->degrees as $degree)
                                <tr>
                                    <td>{{ $degree?->degree?->name }}</td>
                                    <td>{{ $degree?->discipline?->name }}</td>
                                    <td>{{ $degree?->department?->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card pt-4 mb-6 mb-xl-9">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h2>Employments</h2>
                    </div>
                </div>
                <div class="card-body pt-0 pb-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5">
                            <tbody class="fs-6 fw-semibold text-gray-600">
                                @foreach($professor->employments as $employment)
                                <tr>
                                    <td>{{ $employment?->employer }}</td>
                                    <td>{{ $employment?->position?->name }}</td>
                                    <td>{{ $employment?->start_year }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card pt-4 mb-6 mb-xl-9">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h2>Activities</h2>
                    </div>
                </div>
                <div class="card-body pt-0 pb-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5">
                            <tbody class="fs-6 fw-semibold text-gray-600">
                                @foreach($professor->activities as $activity)
                                <tr>
                                    <td>{{ $activity?->name }}</td>
                                    <td>{{ $activity?->activityService?->name }}</td>
                                    <td>{{ $activity?->start_year }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card pt-4 mb-6 mb-xl-9">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h2>Courses</h2>
                    </div>
                </div>
                <div class="card-body pt-0 pb-5">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5">
                            <tbody class="fs-6 fw-semibold text-gray-600">
                                @foreach($professor->courses as $course)
                                <tr>
                                    <td>{{ $course?->code }}</td>
                                    <td>{{ $course?->title }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>