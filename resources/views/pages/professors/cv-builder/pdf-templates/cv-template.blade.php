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

    .disabled {
        opacity: 0.5;
        pointer-events: none;
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

    .fs-3 {
        font-size: 1.75rem;
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

    ul {
        list-style-type: none;
        padding: 0;
    }

    ul li {
        margin-bottom: 10px;
    }

    .signature {
        text-align: center;
        margin-top: 30px;
    }

    .signature p {
        margin: 0;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<div class="preview-container mt-15">
    <div class="card card-no-radius">
        <div class="card-body">
            <h5 class="card-title fs-1 mb-5">LOGO HERE</h5>
            <h6 class="card-subtitle text-muted fs-4">CURRICULUM VITAE</h6>

            <!-- Begin Professor name and address -->
            <div class="mt-15">
                <h5 class="fs-3">{{ $professor->fullName() }}</h5>
                <p>{{$professor->formattedAddress()}}</p>
            </div>
            <!-- End professor name and address -->

            <!-- Begin Degrees Section -->
            @if($include_degrees)
            <div class="mt-15" id="professor-degrees">
                <div class="d-flex align-items-center">
                    <h3>DEGREES</h3>
                </div>
                <div id="degrees-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Degree</th>
                                <th>Institution</th>
                                <th>Discipline</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody id="degrees-table-body">
                            @foreach($filteredDegrees as $degree)
                            <tr data-type="degree" data-year="{{ $degree->year }}" data-id="{{ $degree->id }}">
                                <td>{{ $degree->degree->name }}</td>
                                <td>{{ $degree->institution_name }}</td>
                                <td>{{ $degree->discipline->name }}</td>
                                <td>{{ $degree->year }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Degrees Section -->

            <!-- Begin Employment Section -->
            @if($include_employments)
            <div class="mt-15" id="professor-employments">
                <div class="d-flex align-items-center">
                    <h3>EMPLOYMENTS</h3>
                </div>
                <div id="employments-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>EMPLOYER</th>
                                <th>POSITION</th>
                            </tr>
                        </thead>
                        <tbody id="employments-table-body">
                            @foreach($filteredEmployments as $employment)
                            <tr data-type="employment" data-start-year="{{ $employment->start_year }}" data-end-year="{{ $employment->end_year }}" data-id="{{ $employment->id }}">
                                <td>{{ $employment->start_year }}</td>
                                <td>{{ $employment->is_current ? 'Current' : $employment->end_year }}</td>
                                <td>{{ $employment->employer }}</td>
                                <td>{{ $employment->position->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Employment Section -->

            <!-- Begin Activities Section -->
            @if($include_activities)
            <div class="mt-15" id="professor-activities">
                <div class="d-flex align-items-center">
                    <h3>OUTSIDE PROFESSIONAL ACTIVITIES</h3>
                </div>
                <div id="activities-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>EMPLOYER</th>
                                <th>POSITION</th>
                            </tr>
                        </thead>
                        <tbody id="activities-table-body">
                            @foreach($filteredActivities as $activity)
                            <tr data-type="activity" data-start-year="{{ $activity->start_year }}" data-end-year="{{ $activity->end_year }}" data-id="{{ $activity->id }}">
                                <td>{{ $activity->start_year }}</td>
                                <td>{{ $activity->is_current ? 'Current' : $activity->end_year }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{ $activity->activityService->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Activities Section -->

            <!-- Begin Honors Section -->
            @if($include_honors)
            <div class="mt-15" id="professor-honors">
                <div class="d-flex align-items-center">
                    <h3>HONORS AND AWARDS</h3>
                </div>
                <div id="honors-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>ORGANIZATION</th>
                                <th>TITLE</th>
                            </tr>
                        </thead>
                        <tbody id="honors-table-body">
                            @foreach($filteredHonors as $honor)
                            <tr data-type="honor" data-start-year="{{ $honor->start_year }}" data-end-year="{{ $honor->end_year }}" data-id="{{ $honor->id }}">
                                <td>{{ $honor->start_year }}</td>
                                <td>{{ $honor->is_ongoing ? 'Current' : $honor->end_year }}</td>
                                <td>{{ $honor->honorOrganization->name }}</td>
                                <td>{{ $honor->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Honors Section -->

            <!-- Begin Academic Activities Section -->
            @if($include_academic_activities)
            <div class="mt-15" id="professor-academic-activities">
                <div class="d-flex align-items-center">
                    <h3>SCHOLARLY AND PROFESSIONAL ACADEMIC ACTIVITIES</h3>
                </div>
                <div id="academic-activities-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>ACTIVITY</th>
                            </tr>
                        </thead>
                        <tbody id="academic-activities-table-body">
                            @foreach($filteredAcademicActivities as $activity)
                            <tr data-type="academic_activity" data-start-year="{{ $activity->start_year }}" data-end-year="{{ $activity->end_year }}" data-id="{{ $activity->id }}">
                                <td>{{ $activity->start_year }}</td>
                                <td>{{ $activity->is_current ? 'Current' : $activity->end_year }}</td>
                                <td>{{ $activity->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Academic Activities Section -->

            <!-- Begin Graduate Supervision Section -->
            @if($include_supervisions)
            <div class="mt-15" id="professor-supervisions">
                <div class="d-flex align-items-center">
                    <h3>GRADUATE SUPERVISION</h3>
                </div>
                <div id="supervisions-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody id="supervisions-table-body">
                            @foreach($filteredSupervisions as $supervision)
                            <tr data-type="supervision" data-start-year="{{ $supervision->start_year }}" data-end-year="{{ $supervision->end_year }}" data-id="{{ $supervision->id }}">
                                <td>{{ $supervision->start_year }} {{ ucfirst($supervision->start_month) }}</td>
                                <td>{{ $supervision->end_year ? $supervision->end_year . ' ' . ucfirst($supervision->end_month) : '-' }}</td>
                                <td>{{ $supervision->studentFullName() }} ({{ $supervision->student_program_name }}), {{ $supervision->student_program_area }}, {{ $supervision->supervisionRole->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Graduate Supervision Section -->

            <!-- Begin Graduate Courses Taught Section -->
            @if($include_courses)
            <div class="mt-15" id="professor-courses">
                <div class="d-flex align-items-center">
                    <h3>GRADUATE COURSES TAUGHT</h3>
                </div>
                <div id="courses-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>COURSE TITLE</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody id="courses-table-body">
                            @foreach($filteredCourses as $course)
                            <tr data-type="course" data-created-at="{{ $course->created_at }}" data-id="{{ $course->id }}">
                                <td>{{ $course->title }}</td>
                                <td>
                                    <strong>Course Code:</strong> {{ $course->code }}<br>
                                    <strong>Course Program:</strong> {{ $course->courseProgram->name }}<br>
                                    <strong>Course Level:</strong> {{ $course->courseLevel->name }}<br>
                                    <strong>Course Type:</strong> {{ $course->courseType->name }}<br>
                                    <strong>Course Credit:</strong> {{ $course->courseCredit->name }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Graduate Courses Taught Section -->

            <!-- Begin Outside Graduate Courses Taught Section -->
            @if($include_outside_courses)
            <div class="mt-15" id="professor-outside-courses">
                <div class="d-flex align-items-center">
                    <h3>OUTSIDE GRADUATE COURSES TAUGHT</h3>
                </div>
                <div id="outside-courses-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>COURSE TITLE</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody id="outside-courses-table-body">
                            @foreach($filteredOutsideCourses as $course)
                            <tr data-type="outside_course" data-created-at="{{ $course->created_at }}" data-id="{{ $course->id }}">
                                <td>{{ $course->name }}</td>
                                <td>
                                    <strong>Institution:</strong> {{ $course->institution }}<br>
                                    <strong>Year:</strong> {{ $course->year }}<br>
                                    <strong>Country:</strong> {{ $course->country->name }}<br>
                                    <strong>Language:</strong> {{ $course->language->name }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Outside Graduate Courses Taught Section -->

            <!-- Begin External Research Grants Section -->
            @if($include_grants)
            <div class="mt-15" id="professor-grants">
                <div class="d-flex align-items-center">
                    <h3>EXTERNAL RESEARCH GRANTS</h3>
                </div>
                <div id="grants-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM - TO</th>
                                <th>SOURCE</th>
                                <th>TITLE</th>
                                <th>PURPOSE *</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody id="grants-table-body">
                            @foreach($filteredGrants as $grant)
                            <tr data-type="grant" data-start-date="{{ $grant->start_date }}" data-end-date="{{ $grant->end_date }}" data-id="{{ $grant->id }}">
                                <td>{{ $grant->start_date }} - {{ $grant->end_date ?? '-' }}</td>
                                <td>{{ $grant->fundingSource?->name }}</td>
                                <td>{{ $grant->name }}</td>
                                <td>{{ $grant->grantType->code }}</td>
                                <td>{{ $grant->amount }} {{ $grant->currency->code }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End External Research Grants Section -->

            <!-- Begin Internal Research Grants Section -->
            @if($include_internal_grants)
            <div class="mt-15" id="professor-internal-grants">
                <div class="d-flex align-items-center">
                    <h3>INTERNAL RESEARCH GRANTS</h3>
                </div>
                <div id="internal-grants-content">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>FROM - TO</th>
                                <th>SOURCE</th>
                                <th>TITLE</th>
                                <th>PURPOSE *</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody id="internal-grants-table-body">
                            @foreach($filteredInternalGrants as $grant)
                            <tr data-type="internal_grant" data-start-date="{{ $grant->start_date }}" data-end-date="{{ $grant->end_date }}" data-id="{{ $grant->id }}">
                                <td>{{ $grant->start_date }} - {{ $grant->end_date ?? '-' }}</td>
                                <td>{{ $grant->fundingSource?->name }}</td>
                                <td>{{ $grant->name }}</td>
                                <td>{{ $grant->grantType?->code }}</td>
                                <td>{{ $grant->amount }} {{ $grant->currency?->code }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Internal Research Grants Section -->

            <!-- Begin Publications Summary Section -->
            @if($include_publications_summary)
            <div class="mt-15" id="professor-publications-summary">
                <div class="d-flex align-items-center">
                    <h3>PUBLICATIONS SUMMARY</h3>
                </div>
                <div id="publications-summary-content">
                    <table class="table table-bordered mt-3">
                        <tbody>
                            <tr>
                                <td><strong>Books Authored</strong></td>
                                <td>{{ $professor->books->count() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Chapters in Books</strong></td>
                                <td>{{ $professor->bookChapters->count() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Papers in Journals</strong></td>
                                <td>{{ $professor->journalArticles->count() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Papers in Proceedings</strong></td>
                                <td>{{ $professor->proceedings->count() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Technical Reports</strong></td>
                                <td>{{ $professor->technicalReports->count() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Working Papers</strong></td>
                                <td>{{ $professor->workingPapers->count() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Other Publications</strong></td>
                                <td>{{ $professor->articles->count() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!-- End Publications Summary Section -->

            <!-- Begin Books Authored Section -->
            @if($include_books)
            <div class="mt-15" id="professor-books">
                <div class="d-flex align-items-center">
                    <h3>BOOKS AUTHORED</h3>
                </div>
                <div id="books-content">
                    <ul>
                        @foreach($filteredBooks as $book)
                        @if(!in_array($book->publication_status_id, [2, 4]))
                        <li data-type="book" data-year="{{ $book->year }}" data-id="{{ $book->id }}">
                            <strong>{{ $book->name }}</strong> — {{$book->type->name}}, {{ $book->year }} {{ ucfirst($book->month) }}, {{ $book->publisher->name }}, {{ $book->researchArea?->name }} — <strong>Publication Status:</strong> {{$book->publicationStatus->name}}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Books Authored Section -->

            <!-- Begin Books (Forthcoming – in press or submitted) Section -->
            @if($include_forthcoming_books)
            <div class="mt-15" id="professor-forthcoming-books">
                <div class="d-flex align-items-center">
                    <h3>BOOKS (FORTHCOMING – IN PRESS OR SUBMITTED)</h3>
                </div>
                <div id="forthcoming-books-content">
                    <ul>
                        @foreach($filteredForthcomingBooks as $book)
                        @if(in_array($book->publication_status_id, [2, 4]))
                        <li data-type="forthcoming_book" data-year="{{ $book->year }}" data-id="{{ $book->id }}">
                            <strong>{{ $book->name }}</strong> — {{$book->type->name}}, {{ $book->year }} {{ ucfirst($book->month) }}, {{ $book->publisher->name }}, {{ $book->researchArea?->name }} — <strong>Publication Status:</strong> {{$book->publicationStatus->name}}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Books (Forthcoming – in press or submitted) Section -->

            <!-- Begin Chapters in Books Section -->
            @if($include_chapters_in_books)
            <div class="mt-15" id="professor-chapters-in-books">
                <div class="d-flex align-items-center">
                    <h3>CHAPTERS IN BOOKS</h3>
                </div>
                <div id="chapters-in-books-content">
                    <ul>
                        @foreach($filteredChaptersInBooks as $chapter)
                        @if(!in_array($chapter->publication_status_id, [2, 4]))
                        <li data-type="chapter" data-year="{{ $chapter->published_year }}" data-id="{{ $chapter->id }}">
                            <strong>Book Title: {{ $chapter->book_name }}, Author: {{$chapter->author_name}}</strong> - {{ $chapter->chapter_title }}, {{$chapter->volume}}, {{ $chapter->published_year }} {{ ucfirst($chapter->published_month) }}, {{ $chapter->publisher->name }} — <strong>Publication Status:</strong> {{ $chapter->publicationStatus->name }}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Chapters in Books Section -->

            <!-- Begin Chapters in Books (Forthcoming – in press or submitted) Section -->
            @if($include_forthcoming_chapters_in_books)
            <div class="mt-15" id="professor-forthcoming-chapters-in-books">
                <div class="d-flex align-items-center">
                    <h3>CHAPTERS IN BOOKS (FORTHCOMING – IN PRESS OR SUBMITTED)</h3>
                </div>
                <div id="forthcoming-chapters-in-books-content">
                    <ul>
                        @foreach($filteredForthcomingChaptersInBooks as $chapter)
                        @if(in_array($chapter->publication_status_id, [2, 4]))
                        <li data-type="forthcoming_chapter" data-year="{{ $chapter->published_year }}" data-id="{{ $chapter->id }}">
                            <strong>Book Title: {{ $chapter->book_name }}, Author: {{$chapter->author_name}}</strong> - {{ $chapter->chapter_title }}, {{$chapter->volume}}, {{ $chapter->published_year }} {{ ucfirst($chapter->published_month) }}, {{ $chapter->publisher->name }} — <strong>Publication Status:</strong> {{ $chapter->publicationStatus->name }}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Chapters in Books (Forthcoming – in press or submitted) Section -->

            <!-- Begin Papers in Journals Section -->
            @if($include_papers_in_journals)
            <div class="mt-15" id="professor-papers-in-journals">
                <div class="d-flex align-items-center">
                    <h3>PAPERS IN REFEREED JOURNALS</h3>
                </div>
                <div id="papers-in-journals-content">
                    <ul>
                        @foreach($filteredPapersInJournals as $paper)
                        @if(!in_array($paper->publication_status_id, [2, 4]))
                        <li data-type="paper" data-year="{{ $paper->year }}" data-id="{{ $paper->id }}">
                            <strong>{{ $paper->title }}</strong> - {{ $paper->type->name }}, {{ $paper->year }} {{ ucfirst($paper->month) }}, {{$paper->issue}} {{ $paper->volume }}, Pages: {{$paper->pages}} — <strong>Publication Status:</strong> {{$paper->status->name}}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Papers in Journals Section -->

            <!-- Begin Papers in Journals (Forthcoming – in press or submitted) Section -->
            @if($include_forthcoming_papers_in_journals)
            <div class="mt-15" id="professor-forthcoming-papers-in-journals">
                <div class="d-flex align-items-center">
                    <h3>PAPERS IN JOURNALS (FORTHCOMING – IN PRESS OR SUBMITTED)</h3>
                </div>
                <div id="forthcoming-papers-in-journals-content">
                    <ul>
                        @foreach($filteredForthcomingPapersInJournals as $paper)
                        @if(in_array($paper->publication_status_id, [2, 4]))
                        <li data-type="forthcoming_paper" data-year="{{ $paper->year }}" data-id="{{ $paper->id }}">
                            <strong>{{ $paper->title }}</strong> - {{ $paper->type->name }}, {{ $paper->year }} {{ ucfirst($paper->month) }}, {{$paper->issue}} {{ $paper->volume }}, Pages: {{$paper->pages}} — <strong>Publication Status:</strong> {{$paper->status->name}}
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Papers in Journals (Forthcoming – in press or submitted) Section -->

            <!-- Begin Papers in Conference Proceedings Section -->
            @if($include_papers_in_conference_proceedings)
            <div class="mt-15" id="professor-papers-in-conference-proceedings">
                <div class="d-flex align-items-center">
                    <h3>PAPERS IN CONFERENCE PROCEEDINGS</h3>
                </div>
                <div id="papers-in-conference-proceedings-content">
                    <ul>
                        @foreach($filteredPapersInConferenceProceedings as $presentation)
                        <li data-type="presentation" data-year="{{ $presentation->year }}" data-id="{{ $presentation->id }}">
                            <strong>{{$presentation->event_name}}:</strong> {{ $presentation->name }} - {{ $presentation->year }} {{ ucfirst($presentation->month) }}, {{ $presentation->country->name }}, Days: {{ $presentation->days}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Papers in Conference Proceedings Section -->

            <!-- Begin Major Invited Contributions and/or Technical Reports Section -->
            @if($include_technical_reports)
            <div class="mt-15" id="professor-technical-reports">
                <div class="d-flex align-items-center">
                    <h3>MAJOR INVITED CONTRIBUTIONS AND/OR TECHNICAL REPORTS</h3>
                </div>
                <div id="technical-reports-content">
                    <ul>
                        @foreach($filteredTechnicalReports as $report)
                        <li data-type="technical_report" data-year="{{ $report->year }}" data-id="{{ $report->id }}">
                            {{ $report->workClassification->name }} <strong>{{ $report->identifying_number }}</strong> - {{ $report->year }} {{ ucfirst($report->month) }}, {{ $report->publisher->name }}, {{ $report->researchArea->name }}, {{ $report->volume }}, {{ $report->pages }} pages, {{ $report->intellectualContribution->name }} — <strong>Publication Status: </strong> {{$report->publicationStatus->name}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Major Invited Contributions and/or Technical Reports Section -->

            <!-- Begin Working Papers Section -->
            @if($include_working_papers)
            <div class="mt-15" id="professor-working-papers">
                <div class="d-flex align-items-center">
                    <h3>WORKING PAPERS</h3>
                </div>
                <div id="working-papers-content">
                    <ul>
                        @foreach($filteredWorkingPapers as $paper)
                        <li data-type="working_paper" data-year="{{ $paper->year }}" data-id="{{ $paper->id }}">
                            <strong>{{ $paper->name }}, {{$paper->identifying_number}} </strong> - {{ $paper->year }}, {{ $paper->department->name }}, {{ $paper->intellectualContribution->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Working Papers Section -->

            <!-- Begin Articles in Magazines Section -->
            @if($include_articles_in_magazines)
            <div class="mt-15" id="professor-articles-in-magazines">
                <div class="d-flex align-items-center">
                    <h3>ARTICLES IN MAGAZINES</h3>
                </div>
                <div id="articles-in-magazines-content">
                    <ul>
                        @foreach($filteredArticlesInMagazines as $article)
                        <li data-type="magazine_article" data-year="{{ $article->year }}" data-id="{{ $article->id }}">
                            <strong>{{ $article->title }}</strong> - {{ $article->publisher_name }}, {{ $article->year }} {{ ucfirst($article->month)}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Articles in Magazines Section -->

            <!-- Begin Articles in Newspapers Section -->
            @if($include_articles_in_newspapers)
            <div class="mt-15" id="professor-articles-in-newspapers">
                <div class="d-flex align-items-center">
                    <h3>ARTICLES IN NEWSPAPERS</h3>
                </div>
                <div id="articles-in-newspapers-content">
                    <ul>
                        @foreach($filteredArticlesInNewspapers as $article)
                        <li data-type="newspaper_article" data-year="{{ $article->year }}" data-id="{{ $article->id }}">
                            <strong>{{ $article->title }}</strong> - {{ $article->publisher_name }}, {{ $article->year }} {{ ucfirst($article->month)}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Articles in Newspapers Section -->

            <!-- Begin Articles in Newsletters Section -->
            @if($include_articles_in_newsletters)
            <div class="mt-15" id="professor-articles-in-newsletters">
                <div class="d-flex align-items-center">
                    <h3>ARTICLES IN NEWSLETTERS</h3>
                </div>
                <div id="articles-in-newsletters-content">
                    <ul>
                        @foreach($filteredArticlesInNewsletters as $article)
                        <li data-type="newsletter_article" data-year="{{ $article->year }}" data-id="{{ $article->id }}">
                            <strong>{{ $article->title }}</strong> - {{ $article->publisher_name }}, {{ $article->year }} {{ ucfirst($article->month)}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Articles in Newsletters Section -->

            <!-- Begin Letters to Editor Section -->
            @if($include_letters_to_editor)
            <div class="mt-15" id="professor-letters-to-editor">
                <div class="d-flex align-items-center">
                    <h3>LETTERS TO EDITOR</h3>
                </div>
                <div id="letters-to-editor-content">
                    <ul>
                        @foreach($filteredLettersToEditor as $article)
                        <li data-type="letter_to_editor" data-year="{{ $article->year }}" data-id="{{ $article->id }}">
                            <strong>{{ $article->title }}</strong> - {{ $article->publisher_name }}, {{ $article->year }} {{ ucfirst($article->month)}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Letters to Editor Section -->

            <!-- Begin Book Reviews Section -->
            @if($include_book_reviews)
            <div class="mt-15" id="professor-book-reviews">
                <div class="d-flex align-items-center">
                    <h3>BOOK REVIEWS</h3>
                </div>
                <div id="book-reviews-content">
                    <ul>
                        @foreach($filteredBookReviews as $review)
                        <li data-type="book_review" data-year="{{ $review->year }}" data-id="{{ $review->id }}">
                            <strong>{{ $review->name }} - {{$review->reviewedMedium->name}}</strong> - {{ $review->periodical_title }}, {{ $review->year }} {{ ucfirst($review->month) }}, {{ $review->reviewed_work_authors }}, {{ $review->intellectualContribution?->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <!-- End Book Reviews Section -->
        </div>
        <div class="card-footer">
            <div class="signature mt-15">
                <p>______________________________</p>
                <h6 class="mt-2 fs-5">Generated on: {{Carbon\Carbon::now()->format('d/m/Y')}}</h6>
            </div>
        </div>
    </div>
</div>
</div>