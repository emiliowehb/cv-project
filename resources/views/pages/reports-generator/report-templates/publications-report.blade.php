<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .preview-container {
        border: 3px solid #e5e5e5;
        padding: 15px;
        margin-bottom: 20px;
    }

    .card-no-radius {
        border-radius: 0;
    }

    .table-bordered {
        border: 2px solid #dee2e6;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table-bordered th,
    .table-bordered td {
        border: 2px solid #dee2e6;
        padding: 8px;
        text-align: left;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .card-subtitle {
        font-size: 18px;
        color: #6c757d;
    }

    .fs-1 {
        font-size: 2rem;
    }

    .fs-4 {
        font-size: 1.5rem;
    }

    .fs-5 {
        font-size: 1rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    .mt-15 {
        margin-top: 15px;
    }

    .mb-5 {
        margin-bottom: 20px;
    }

    h3 {
        font-size: 1.5rem;
        color: #007bff;
        margin-bottom: 10px;
    }

    .signature {
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="preview-container mt-15">
    <div class="card card-no-radius">
        <div class="card-body">
            <h5 class="card-title fs-1 mb-5">LOGO HERE</h5>
            <h6 class="card-subtitle text-muted fs-4">Publications Report</h6>

            <!-- Begin Publications Report -->
            @foreach($data as $professor)
            <div class="mt-15">
                <h5>{{ $professor->fullName() }}</h5>
                <div class="mt-15" id="professor-books">
                    <div class="d-flex align-items-center">
                        <h3>BOOKS AUTHORED</h3>
                    </div>
                    <div id="books-content">
                        <ul>
                            @foreach($professor->books as $book)
                            @if(!in_array($book->publication_status_id, [2, 4]))
                            <li data-type="book">
                                <strong>{{ $book->name }}</strong> — {{$book->type->name}}, {{ $book->year }} {{ ucfirst($book->month) }}, {{ $book->publisher->name }}, {{ $book->researchArea?->name }} — <strong>Publication Status:</strong> {{$book->publicationStatus->name}}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-forthcoming-books">
                    <div class="d-flex align-items-center">
                        <h3>BOOKS (FORTHCOMING – IN PRESS OR SUBMITTED)</h3>
                    </div>
                    <div id="forthcoming-books-content">
                        <ul>
                            @foreach($professor->books as $book)
                            @if(in_array($book->publication_status_id, [2, 4]))
                            <li data-type="forthcoming_book" data-year="{{ $book->year }}" data-id="{{ $book->id }}">
                                <strong>{{ $book->name }}</strong> — {{$book->type->name}}, {{ $book->year }} {{ ucfirst($book->month) }}, {{ $book->publisher->name }}, {{ $book->researchArea?->name }} — <strong>Publication Status:</strong> {{$book->publicationStatus->name}}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-chapters-in-books">
                    <div class="d-flex align-items-center">
                        <h3>CHAPTERS IN BOOKS</h3>
                    </div>
                    <div id="chapters-in-books-content">
                        <ul>
                            @foreach($professor->bookChapters as $chapter)
                            @if(!in_array($chapter->publication_status_id, [2, 4]))
                            <li data-type="chapter" data-year="{{ $chapter->published_year }}" data-id="{{ $chapter->id }}">
                                <strong>Book Title: {{ $chapter->book_name }}, Author: {{$chapter->author_name}}</strong> - {{ $chapter->chapter_title }}, {{$chapter->volume}}, {{ $chapter->published_year }} {{ ucfirst($chapter->published_month) }}, {{ $chapter->publisher->name }} — <strong>Publication Status:</strong> {{ $chapter->publicationStatus?->name }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-forthcoming-chapters-in-books">
                    <div class="d-flex align-items-center">
                        <h3>CHAPTERS IN BOOKS (FORTHCOMING – IN PRESS OR SUBMITTED)</h3>
                    </div>
                    <div id="forthcoming-chapters-in-books-content">
                        <ul>
                            @foreach($professor->bookChapters as $chapter)
                            @if(in_array($chapter->publication_status_id, [2, 4]))
                            <li data-type="forthcoming_chapter" data-year="{{ $chapter->published_year }}" data-id="{{ $chapter->id }}">
                                <strong>Book Title: {{ $chapter->book_name }}, Author: {{$chapter->author_name}}</strong> - {{ $chapter->chapter_title }}, {{$chapter->volume}}, {{ $chapter->published_year }} {{ ucfirst($chapter->published_month) }}, {{ $chapter->publisher->name }} — <strong>Publication Status:</strong> {{ $chapter->publicationStatus->name }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-papers-in-journals">
                    <div class="d-flex align-items-center">
                        <h3>PAPERS IN REFEREED JOURNALS</h3>
                    </div>
                    <div id="papers-in-journals-content">
                        <ul>
                            @foreach($professor->journalArticles as $paper)
                            @if(!in_array($paper->publication_status_id, [2, 4]))
                            <li data-type="paper" data-year="{{ $paper->year }}" data-id="{{ $paper->id }}">
                                <strong>{{ $paper->title }}</strong> - {{ $paper->type->name }}, {{ $paper->year }} {{ ucfirst($paper->month) }}, {{$paper->issue}} {{ $paper->volume }}, Pages: {{$paper->pages}} — <strong>Publication Status:</strong> {{$paper->status->name}}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mt-15" id="professor-forthcoming-papers-in-journals">
                    <div class="d-flex align-items-center">
                        <h3>PAPERS IN JOURNALS (FORTHCOMING – IN PRESS OR SUBMITTED)</h3>
                    </div>
                    <div id="forthcoming-papers-in-journals-content">
                        <ul>
                            @foreach($professor->journalArticles as $paper)
                            @if(in_array($paper->publication_status_id, [2, 4]))
                            <li data-type="forthcoming_paper" data-year="{{ $paper->year }}" data-id="{{ $paper->id }}">
                                <strong>{{ $paper->title }}</strong> - {{ $paper->type->name }}, {{ $paper->year }} {{ ucfirst($paper->month) }}, {{$paper->issue}} {{ $paper->volume }}, Pages: {{$paper->pages}} — <strong>Publication Status:</strong> {{$paper->status->name}}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-papers-in-conference-proceedings">
                    <div class="d-flex align-items-center">
                        <h3>PAPERS IN CONFERENCE PROCEEDINGS</h3>
                    </div>
                    <div id="papers-in-conference-proceedings-content">
                        <ul>
                            @foreach($professor->proceedings as $presentation)
                            <li data-type="presentation" data-year="{{ $presentation->year }}" data-id="{{ $presentation->id }}">
                                <strong>{{$presentation->event_name}}:</strong> {{ $presentation->name }} - {{ $presentation->year }} {{ ucfirst($presentation->month) }}, {{ $presentation->country->name }}, Days: {{ $presentation->days}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-technical-reports">
                    <div class="d-flex align-items-center">
                        <h3>MAJOR INVITED CONTRIBUTIONS AND/OR TECHNICAL REPORTS</h3>
                    </div>
                    <div id="technical-reports-content">
                        <ul>
                            @foreach($professor->technicalReports as $report)
                            <li data-type="technical_report" data-year="{{ $report->year }}" data-id="{{ $report->id }}">
                                {{ $report->workClassification->name }} <strong>{{ $report->identifying_number }}</strong> - {{ $report->year }} {{ ucfirst($report->month) }}, {{ $report->publisher->name }}, {{ $report->researchArea->name }}, {{ $report->volume }}, {{ $report->pages }} pages, {{ $report->intellectualContribution->name }} — <strong>Publication Status: </strong> {{$report->publicationStatus->name}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-15" id="professor-working-papers">
                    <div class="d-flex align-items-center">
                        <h3>WORKING PAPERS</h3>
                    </div>
                    <div id="working-papers-content">
                        <ul>
                            @foreach($professor->workingPapers as $paper)
                            <li data-type="working_paper" data-year="{{ $paper->year }}" data-id="{{ $paper->id }}">
                                <strong>{{ $paper->name }}, {{$paper->identifying_number}} </strong> - {{ $paper->year }}, {{ $paper->department->name }}, {{ $paper->intellectualContribution->name }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            @endforeach
        </div>
        <!-- End Publications Report Table -->
    </div>
    <div class="card-footer">
        <div class="signature mt-15">
            <h6 class="mt-2 fs-5">Generated on: {{Carbon\Carbon::now()->format('d/m/Y')}}</h6>
        </div>
    </div>
</div>
</div>