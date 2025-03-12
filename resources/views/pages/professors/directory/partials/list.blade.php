@if($professors->isEmpty())
<div class="col">
    <div class="card p-6 shadow-sm">
        <div class="text-center">
            <h3 class="fs-2 text-gray-700 mt-6">No results found</h3>
            <p class="fs-5 text-gray-400">We couldn't find any professors matching your criteria.</p>
        </div>
    </div>
</div>
@endif

@foreach($professors as $professor)
<div class="col professor-card" style="opacity: 0; margin-top: 24px; animation: fadeIn 0.5s ease forwards;">
    <div class="card h-100 p-6 shadow-sm">
        <div class="d-flex">
            <div class="symbol symbol-100px symbol-circle">
                @if($professor->user->profile_photo_url)
                    <img src="{{ asset('storage/' . $professor->user->profile_photo_path) }}" alt="image"/>
                @else
                    <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $professor->first_name . ' ' . $professor->last_name) }}">
                        {{ substr($professor->first_name . ' ' . $professor->last_name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex-grow-1 ms-5 mt-2">
                <button class="btn btn-secondary btn-sm float-end">
                    <i class="fas fa-plus"></i>
                </button>
                <h5 class="fs-4 text-gray-900 text-hover-primary fw-bold mb-1">
                    <a href="{{ route('professors.directory.profile', $professor) }}" class="text-gray-900 text-hover-primary">
                    {{ $professor->first_name }} {{ $professor->last_name }}
                    </a>
                </h5>
                <p class="mb-1 text-gray-700">{{ $professor->email }}</p>
                @if($professor?->employments?->count() > 0)
                    <p class="fw-semibold text-gray-700 mb-1">{{ $professor?->employments?->first()?->employer }} - {{ $professor?->employments?->first()?->position?->name }}</p>
                @endif
                <p class="d-flex align-items-center text-gray-700 mb-1">
                    {{--  TODO: flag <img src="https://flagcdn.com/w40/fr.png" class="me-2" width="20"> --}}
                    {{ $professor?->address?->country?->name }}
                </p>
            </div>
        </div>
    </div>
</div>
@endforeach