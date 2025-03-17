@foreach($publications as $publication)
<div class="col publication-card" style="opacity: 0; margin-top: 24px; animation: fadeIn 0.5s ease forwards;">
    <div class="card h-100 p-6 shadow-sm">
        <h5 class="fs-4 text-gray-900 fw-bold mb-1">{{ $publication->title }}</h5>
        <p class="mb-1 text-gray-700">
            <strong>Author:</strong> {{ $publication->professor->first_name }} {{ $publication->professor->last_name }}
        </p>
        <p class="mb-1 text-gray-700">
            <strong>Year:</strong> {{ $publication->year }}
        </p>
        @if($publication instanceof \App\Models\ProfessorJournalArticle)
            <p class="mb-1 text-gray-700">
                <strong>Journal:</strong> {{ $publication->type->name }}
            </p>
            <p class="mb-1 text-gray-700">
                <strong>Status:</strong> {{ $publication->status->name }}
            </p>
        @else
            <p class="mb-1 text-gray-700">
                <strong>Publisher:</strong> {{ $publication->publisher_name }}
            </p>
            <p class="mb-1 text-gray-700">
                <strong>Type:</strong> {{ $publication->type->name }}
            </p>
        @endif
    </div>
</div>
@endforeach
