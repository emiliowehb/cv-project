<x-default-layout>
    @section('title')
    {{ __('messages.cv_builder') }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard.professors.cv-builder', $professor) }}
    @endsection

    <form action="{{ route('professors.cv-builder.submit') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('messages.cv_builder') }}</h3>
            </div>
            <div class="card-body">
                <!-- Begin Options -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="range" class="form-label">{{ __('messages.range') }}</label>
                        <select id="range" name="range" class="form-select" onchange="filterAllSections();">
                            @foreach($ranges as $range)
                            <option value="{{ $range }}">{{ __('messages.' . $range) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="format" class="form-label">{{ __('messages.format') }}</label>
                        <select id="format" name="format" class="form-select">
                            @foreach($formats as $format)
                            <option value="{{ $format }}">{{ __('messages.' . $format) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- End Options -->
                <!-- Begin Sections -->
                <div class="preview-container mt-15">
                    <div class="card card-no-radius">
                        <div class="card-body">
                            <h5 class="card-title fs-1 mb-5">LOGO HERE</h5>
                            <h6 class="card-subtitle text-muted fs-4">CURRICULUM VITAE</h6>
                            <h6 class="mt-2">{{Carbon\Carbon::now()->format('d/m/Y')}}</h6>

                            <!-- Begin Professor name and address -->
                            <div class="mt-15">
                                <h5 class="fs-3">{{ $professor->fullName() }}</h5>
                                <p>{{$professor->formattedAddress()}}</p>
                            </div>
                            <!-- End professor name and address -->

                            <!-- Begin Degrees Section -->
                            <div class="mt-15" id="professor-degrees">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-degrees" name="include_degrees" checked>
                                        <label class="form-check-label fs-3" for="include-degrees">DEGREES</label>
                                    </div>
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
                                            @foreach($professor->degrees as $degree)
                                            <tr data-year="{{ $degree->year }}" data-id="{{ $degree->id }}" data-type="degree">
                                                <td>{{ $degree->degree->name }}</td>
                                                <td>{{ $degree->institution_name }}</td>
                                                <td>{{ $degree->discipline->name }}</td>
                                                <td>{{ $degree->year }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('degree', {{ $degree->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Degrees Section -->

                            <!-- Begin Employment Section -->
                            <div class="mt-15" id="professor-employments">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-employments" name="include_employments" checked>
                                        <label class="form-check-label fs-3" for="include-employments">EMPLOYMENTS</label>
                                    </div>
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
                                            @foreach($professor->employments->sortByDesc('start_year') as $employment)
                                            <tr data-start-year="{{ $employment->start_year }}" data-end-year="{{ $employment->end_year }}" data-type="employment" data-id="{{ $employment->id }}">
                                                <td>{{ $employment->start_year }}</td>
                                                <td>{{ $employment->is_current ? 'Current' : $employment->end_year }}</td>
                                                <td>{{ $employment->employer }}</td>
                                                <td>{{ $employment->position->name }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('employment', {{ $employment->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Employment Section -->

                            <!-- Begin Activities Section -->
                            <div class="mt-15" id="professor-activities">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-activities" name="include_activities" checked>
                                        <label class="form-check-label fs-3" for="include-activities">OUTSIDE PROFESSIONAL ACTIVITIES</label>
                                    </div>
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
                                            @foreach($professor->activities->whereNotIn('activity_service_id', [1, 2])->sortByDesc('start_year') as $activity)
                                            <tr data-start-year="{{ $activity->start_year }}" data-end-year="{{ $activity->end_year }}" data-type="employment" data-id="{{ $activity->id }}">
                                                <td>{{ $activity->start_year }}</td>
                                                <td>{{ $activity->is_current ? 'Current' : $activity->end_year }}</td>
                                                <td>{{ $activity->name }}</td>
                                                <td>{{ $activity->activityService->name }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('activity', {{ $activity->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Activities Section -->

                            <!-- Begin Honors Section -->
                            <div class="mt-15" id="professor-honors">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-honors" name="include_honors" checked>
                                        <label class="form-check-label fs-3" for="include-honors">HONORS AND AWARDS</label>
                                    </div>
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
                                            @foreach($professor->honors->sortByDesc('start_year') as $honor)
                                            <tr data-start-year="{{ $honor->start_year }}" data-end-year="{{ $honor->end_year }}" data-type="honor" data-id="{{ $honor->id }}">
                                                <td>{{ $honor->start_year }}</td>
                                                <td>{{ $honor->is_ongoing ? 'Current' : $honor->end_year }}</td>
                                                <td>{{ $honor->honorOrganization->name }}</td>
                                                <td>{{ $honor->name }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('honor', {{ $honor->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Honors Section -->

                            <!-- Begin Academic Activities Section -->
                            <div class="mt-15" id="professor-academic-activities">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-academic-activities" name="include_academic_activities" checked>
                                        <label class="form-check-label fs-3" for="include-academic-activities">SCHOLARLY AND PROFESSIONAL ACADEMIC ACTIVITIES</label>
                                    </div>
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
                                            @foreach($professor->activities->whereIn('activity_service_id', [1, 2])->sortByDesc('start_year') as $activity)
                                            <tr data-start-year="{{ $activity->start_year }}" data-end-year="{{ $activity->end_year }}" data-type="academic_activity" data-id="{{ $activity->id }}">
                                                <td>{{ $activity->start_year }}</td>
                                                <td>{{ $activity->is_current ? 'Current' : $activity->end_year }}</td>
                                                <td>{{ $activity->name }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('academic_activity', {{ $activity->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Academic Activities Section -->

                            <!-- Begin Graduate Supervision Section -->
                            <div class="mt-15" id="professor-supervisions">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-supervisions" name="include_supervisions" checked>
                                        <label class="form-check-label fs-3" for="include-supervisions">GRADUATE SUPERVISION</label>
                                    </div>
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
                                            @foreach($professor->graduateSupervisions->sortByDesc('start_year') as $supervision)
                                            <tr data-start-year="{{ $supervision->start_year }}" data-end-year="{{ $supervision->end_year }}" data-type="supervision" data-id="{{ $supervision->id }}">
                                                <td>{{ $supervision->start_year }} {{ ucfirst($supervision->start_month) }}</td>
                                                <td>{{ $supervision->end_year ? $supervision->end_year . ' ' . ucfirst($supervision->end_month) : '-' }}</td>
                                                <td>{{ $supervision->studentFullName() }} ({{ $supervision->student_program_name }}), {{ $supervision->student_program_area }}, {{ $supervision->supervisionRole->name }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('supervision', {{ $supervision->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Graduate Supervision Section -->

                            <!-- Begin Graduate Courses Taught Section -->
                            <div class="mt-15" id="professor-courses">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-courses" name="include_courses" checked>
                                        <label class="form-check-label fs-3" for="include-courses">GRADUATE COURSES TAUGHT</label>
                                    </div>
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
                                            @foreach($professor->courses->sortByDesc('created_at') as $course)
                                            <tr data-created-at="{{ $course->created_at }}" data-type="course" data-id="{{ $course->id }}">
                                                <td>{{ $course->title }}</td>
                                                <td>
                                                    <strong>Course Code:</strong> {{ $course->code }}<br>
                                                    <strong>Course Program:</strong> {{ $course->courseProgram->name }}<br>
                                                    <strong>Course Level:</strong> {{ $course->courseLevel->name }}<br>
                                                    <strong>Course Type:</strong> {{ $course->courseType->name }}<br>
                                                    <strong>Course Credit:</strong> {{ $course->courseCredit->name }}
                                                </td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('course', {{ $course->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Graduate Courses Taught Section -->

                            <!-- Begin Outside Graduate Courses Taught Section -->
                            <div class="mt-15" id="professor-outside-courses">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-outside-courses" name="include_outside_courses" checked>
                                        <label class="form-check-label fs-3" for="include-outside-courses">OUTSIDE GRADUATE COURSES TAUGHT</label>
                                    </div>
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
                                            @foreach($professor->outsideCourses->sortByDesc('created_at') as $course)
                                            <tr data-created-at="{{ $course->created_at }}" data-type="outside_course" data-id="{{ $course->id }}">
                                                <td>{{ $course->name }}</td>
                                                <td>
                                                    <strong>Institution:</strong> {{ $course->institution }}<br>
                                                    <strong>Year:</strong> {{ $course->year }}<br>
                                                    <strong>Country:</strong> {{ $course->country->name }}<br>
                                                    <strong>Language:</strong> {{ $course->language->name }}
                                                </td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('outside_course', {{ $course->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Outside Graduate Courses Taught Section -->

                            <!-- Begin External Research Grants Section -->
                            <div class="mt-15" id="professor-grants">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-grants" name="include_grants" checked>
                                        <label class="form-check-label fs-3" for="include-grants">EXTERNAL RESEARCH GRANTS</label>
                                    </div>
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
                                            @foreach($professor->grants->where('is_external', 1)->sortByDesc('start_date') as $grant)
                                            <tr data-start-date="{{ $grant->start_date }}" data-end-date="{{ $grant->end_date }}" data-type="grant" data-id="{{ $grant->id }}">
                                                <td>{{ $grant->start_date }} - {{ $grant->end_date ?? '-' }}</td>
                                                <td>{{ $grant->fundingSource?->name }}</td>
                                                <td>{{ $grant->name }}</td>
                                                <td>{{ $grant->grantType->code }}</td>
                                                <td>{{ $grant->amount }} {{ $grant->currency->code }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('grant', {{ $grant->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p>* Purpose = C : Contract (R and D), E : Equipment Grant, R : Research Grant, T : Travel Grant, S : Support Award,
                                        P: Pedagogical Grant, O: Other, U : Unknown</p>
                                </div>
                            </div>
                            <!-- End External Research Grants Section -->

                            <!-- Begin Internal Research Grants Section -->
                            <div class="mt-15" id="professor-internal-grants">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-internal-grants" name="include_internal_grants" checked>
                                        <label class="form-check-label fs-3" for="include-internal-grants">INTERNAL RESEARCH GRANTS</label>
                                    </div>
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
                                            @foreach($professor->grants->where('is_external', 0)->sortByDesc('start_date') as $grant)
                                            <tr data-start-date="{{ $grant->start_date }}" data-end-date="{{ $grant->end_date }}" data-type="internal_grant" data-id="{{ $grant->id }}">
                                                <td>{{ $grant->start_date }} - {{ $grant->end_date ?? '-' }}</td>
                                                <td>{{ $grant->fundingSource?->name }}</td>
                                                <td>{{ $grant->name }}</td>
                                                <td>{{ $grant->grantType?->code }}</td>
                                                <td>{{ $grant->amount }} {{ $grant->currency?->code }}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="excludeEntry('internal_grant', {{ $grant->id }})">-</button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <p>* Purpose = C : Contract (R and D), E : Equipment Grant, R : Research Grant, T : Travel Grant, S : Support Award,
                                        P: Pedagogical Grant, O: Other, U : Unknown</p>
                                </div>
                            </div>
                            <!-- End Internal Research Grants Section -->
                            <!-- Begin Publications Summary -->
                            <div class="mt-15" id="professor-publications-summary">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-publications-summary" name="include_publications_summary" checked>
                                        <label class="form-check-label fs-3" for="include-publications-summary">PUBLICATIONS SUMMARY</label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <table class="table table-bordered mt-3">
                                        <tbody id="professor-publications-summary-content">
                                            <tr>
                                                <td><strong>Books Authored</strong></td>
                                                <td>{{$professor->books->count()}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Chapters in Books</strong></td>
                                                <td>{{$professor->bookChapters->count()}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Papers in Journals</strong></td>
                                                <td>{{$professor->journalArticles->count()}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Papers in Proceedings</strong></td>
                                                <td>{{$professor->proceedings->count()}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Technical Reports</strong></td>
                                                <td>{{$professor->technicalReports->count()}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Working Papers</strong></td>
                                                <td>{{$professor->workingPapers->count()}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Other Publications</strong></td>
                                                <td>{{$professor->articles->count()}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Publications Summary -->

                            <!-- Begin Books Authored Section -->
                            <div class="mt-15" id="professor-books">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-books" name="include_books" checked>
                                        <label class="form-check-label fs-3" for="include-books">BOOKS AUTHORED</label>
                                    </div>
                                </div>
                                <div id="books-content">
                                    <ul>
                                        @foreach($professor->books as $book)
                                        @if(!in_array($book->publication_status_id, [2, 4]))
                                        <li data-year="{{ $book->year }}" data-type="book" data-id="{{ $book->id }}">
                                            <strong>{{ $book->name }}</strong> - {{ $book->year }} {{ ucfirst($book->month) }}, {{ $book->publisher->name }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('book', {{ $book->id }})">-</button>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Books Authored Section -->

                            <!-- Begin Books (Forthcoming – in press or submitted) Section -->
                            <div class="mt-15" id="professor-forthcoming-books">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-forthcoming-books" name="include_forthcoming_books" checked>
                                        <label class="form-check-label fs-3" for="include-forthcoming-books">BOOKS (FORTHCOMING – IN PRESS OR SUBMITTED)</label>
                                    </div>
                                </div>
                                <div id="forthcoming-books-content">
                                    <ul>
                                        @foreach($professor->books as $book)
                                        @if(in_array($book->publication_status_id, [2, 4]))
                                        <li data-year="{{ $book->year }}" data-type="forthcoming_book" data-id="{{ $book->id }}">
                                            <strong>{{ $book->name }}</strong> - <span data-year="{{$book->year}}">{{ $book->year }}</span> {{ ucfirst($book->month) }}, {{ $book->publisher->name }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('forthcoming_book', {{ $book->id }})">-</button>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Books (Forthcoming – in press or submitted) Section -->

                            <!-- Begin Chapters in Books Section -->
                            <div class="mt-15" id="professor-chapters-in-books">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-chapters-in-books" name="include_chapters_in_books" checked>
                                        <label class="form-check-label fs-3" for="include-chapters-in-books">CHAPTERS IN BOOKS</label>
                                    </div>
                                </div>
                                <div id="chapters-in-books-content">
                                    <ul>
                                        @foreach($professor->bookChapters as $chapter)
                                        @if(!in_array($chapter->publication_status_id, [2, 4]))
                                        <li data-year="{{ $chapter->published_year }}" data-type="chapter" data-id="{{ $chapter->id }}">
                                            <strong>{{ $chapter->chapter_title }}</strong> - {{ $chapter->book_name }}, {{ $chapter->published_year }} {{ ucfirst($chapter->published_month) }}, {{ $chapter->publisher->name }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('chapter', {{ $chapter->id }})">-</button>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Chapters in Books Section -->

                            <!-- Begin Chapters in Books (Forthcoming – in press or submitted) Section -->
                            <div class="mt-15" id="professor-forthcoming-chapters-in-books">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-forthcoming-chapters-in-books" name="include_forthcoming_chapters_in_books" checked>
                                        <label class="form-check-label fs-3" for="include-forthcoming-chapters-in-books">CHAPTERS IN BOOKS (FORTHCOMING – IN PRESS OR SUBMITTED)</label>
                                    </div>
                                </div>
                                <div id="forthcoming-chapters-in-books-content">
                                    <ul>
                                        @foreach($professor->bookChapters as $chapter)
                                        @if(in_array($chapter->publication_status_id, [2, 4]))
                                        <li data-year="{{ $chapter->published_year }}" data-type="forthocoming_chapter" data-id="{{ $chapter->id }}">
                                            <strong>{{ $chapter->chapter_title }}</strong> - {{ $chapter->book_name }}, {{ $chapter->published_year }} {{ ucfirst($chapter->published_month) }}, {{ $chapter->publisher->name }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('forthcoming_chapter', {{ $chapter->id }})">-</button>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Chapters in Books (Forthcoming – in press or submitted) Section -->

                            <!-- Begin Papers in Journals Section -->
                            <div class="mt-15" id="professor-papers-in-journals">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-papers-in-journals" name="include_papers_in_journals" checked>
                                        <label class="form-check-label fs-3" for="include-papers-in-journals">PAPERS IN REFEREED JOURNALS</label>
                                    </div>
                                </div>
                                <div id="papers-in-journals-content">
                                    <ul>
                                        @foreach($professor->journalArticles as $paper)
                                        @if(!in_array($paper->publication_status_id, [2, 4]))
                                        <li data-year="{{ $paper->year }}" data-type="paper" data-id="{{ $paper->id }}">
                                            <strong>{{ $paper->title }}</strong> - {{ $paper->type->name }}, {{ $paper->year }} {{ ucfirst($paper->month) }}, <strong>Publication Status:</strong> {{$paper->status->name}}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('paper', {{ $paper->id }})">-</button>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Papers in Journals Section -->

                            <!-- Begin Papers in Journals (Forthcoming – in press or submitted) Section -->
                            <div class="mt-15" id="professor-forthcoming-papers-in-journals">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-forthcoming-papers-in-journals" name="include_forthcoming_papers_in_journals" checked>
                                        <label class="form-check-label fs-3" for="include-forthcoming-papers-in-journals">PAPERS IN JOURNALS (FORTHCOMING – IN PRESS OR SUBMITTED)</label>
                                    </div>
                                </div>
                                <div id="forthcoming-papers-in-journals-content">
                                    <ul>
                                        @foreach($professor->journalArticles as $paper)
                                        @if(in_array($paper->publication_status_id, [2, 4]))
                                        <li data-year="{{ $paper->year }}" data-type="forthcoming_paper" data-id="{{ $paper->id }}">
                                            <strong>{{ $paper->title }}</strong> - {{ $paper->type->name }}, {{ $paper->year }} {{ ucfirst($paper->month) }}, <strong>Publication Status:</strong> {{$paper->status->name}}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('forthcoming_paper', {{ $paper->id }})">-</button>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Papers in Journals (Forthcoming – in press or submitted) Section -->

                            <!-- Begin Papers in Conference Proceedings Section -->
                            <div class="mt-15" id="professor-papers-in-conference-proceedings">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-papers-in-conference-proceedings" name="include_papers_in_conference_proceedings" checked>
                                        <label class="form-check-label fs-3" for="include-papers-in-conference-proceedings">PAPERS IN CONFERENCE PROCEEDINGS</label>
                                    </div>
                                </div>
                                <div id="papers-in-conference-proceedings-content">
                                    <ul>
                                        @foreach($professor->proceedings as $presentation)
                                        <li data-year="{{ $presentation->year }}" data-type="presentation" data-id="{{ $presentation->id }}">
                                            <strong>{{ $presentation->name }}</strong> - {{ $presentation->year }}, {{ $presentation->country->name }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('presentation', {{ $presentation->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Papers in Conference Proceedings Section -->

                            <!-- Begin Major Invited Contributions and/or Technical Reports Section -->
                            <div class="mt-15" id="professor-technical-reports">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-technical-reports" name="include_technical_reports" checked>
                                        <label class="form-check-label fs-3" for="include-technical-reports">MAJOR INVITED CONTRIBUTIONS AND/OR TECHNICAL REPORTS</label>
                                    </div>
                                </div>
                                <div id="technical-reports-content">
                                    <ul>
                                        @foreach($professor->technicalReports as $report)
                                        <li data-year="{{ $report->year }}" data-type="technical_report" data-id="{{ $report->id }}">
                                            <strong>{{ $report->identifying_number }}</strong> - {{ $report->year }}, {{ $report->publisher->name }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('technical_report', {{ $report->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Major Invited Contributions and/or Technical Reports Section -->

                            <!-- Begin Working Papers Section -->
                            <div class="mt-15" id="professor-working-papers">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-working-papers" name="include_working_papers" checked>
                                        <label class="form-check-label fs-3" for="include-working-papers">WORKING PAPERS</label>
                                    </div>
                                </div>
                                <div id="working-papers-content">
                                    <ul>
                                        @foreach($professor->workingPapers as $paper)
                                        <li data-year="{{ $paper->year }}" data-type="working_paper" data-id="{{ $paper->id }}">
                                            <strong>{{ $paper->name }}</strong> - {{ $paper->year }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('working_paper', {{ $paper->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Working Papers Section -->
                             <!-- Start Other Publications Section -->
                              <div class="mt-15" id="other-publications">
                                 <label class="form-check-label fs-3" for="include-working-papers">OTHER PUBLICATIONS</label>
                                    
                              </div>
                            <!-- End Other Publications Section -->
                            <!-- Begin Articles in Magazines Section -->
                            <div class="mt-15" id="professor-articles-in-magazines">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-articles-in-magazines" name="include_articles_in_magazines" checked>
                                        <label class="form-check-label fs-3" for="include-articles-in-magazines">ARTICLES IN MAGAZINES</label>
                                    </div>
                                </div>
                                <div id="articles-in-magazines-content">
                                    <ul>
                                        @foreach($professor->magazineArticles as $article)
                                        <li data-year="{{ $article->year }}" data-type="magazine_article" data-id="{{ $article->id }}">
                                            <strong>{{ $article->title }}</strong> - {{ $article->magazine_name }}, {{ $article->year }} {{ ucfirst($article->month) }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('magazine_article', {{ $article->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Articles in Magazines Section -->

                            <!-- Begin Articles in Newspapers Section -->
                            <div class="mt-15" id="professor-articles-in-newspapers">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-articles-in-newspapers" name="include_articles_in_newspapers" checked>
                                        <label class="form-check-label fs-3" for="include-articles-in-newspapers">ARTICLES IN NEWSPAPERS</label>
                                    </div>
                                </div>
                                <div id="articles-in-newspapers-content">
                                    <ul>
                                        @foreach($professor->newspaperArticles as $article)
                                        <li data-year="{{ $article->year }}" data-type="newspaper_article" data-id="{{ $article->id }}">
                                            <strong>{{ $article->title }}</strong> - {{ $article->newspaper_name }}, {{ $article->year }} {{ ucfirst($article->month) }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('newspaper_article', {{ $article->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Articles in Newspapers Section -->

                            <!-- Begin Articles in Newsletters Section -->
                            <div class="mt-15" id="professor-articles-in-newsletters">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-articles-in-newsletters" name="include_articles_in_newsletters" checked>
                                        <label class="form-check-label fs-3" for="include-articles-in-newsletters">ARTICLES IN NEWSLETTERS</label>
                                    </div>
                                </div>
                                <div id="articles-in-newsletters-content">
                                    <ul>
                                        @foreach($professor->newsletterArticles as $article)
                                        <li data-year="{{ $article->year }}" data-type="newsletter_article" data-id="{{ $article->id }}">
                                            <strong>{{ $article->title }}</strong> - {{ $article->newsletter_name }}, {{ $article->year }} {{ ucfirst($article->month) }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('newsletter_article', {{ $article->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Articles in Newsletters Section -->

                            <!-- Begin Letters to Editor Section -->
                            <div class="mt-15" id="professor-letters-to-editor">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-letters-to-editor" name="include_letters_to_editor" checked>
                                        <label class="form-check-label fs-3" for="include-letters-to-editor">LETTERS TO EDITOR</label>
                                    </div>
                                </div>
                                <div id="letters-to-editor-content">
                                    <ul>
                                        @foreach($professor->letterToEditorArticles as $article)
                                        <li data-year="{{ $article->year }}" data-type="letter_to_editor" data-id="{{ $article->id }}">
                                            <strong>{{ $article->title }}</strong> - {{ $article->publisher_name }}, {{ $article->year }} {{ ucfirst($article->month) }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('letter_to_editor', {{ $article->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Letters to Editor Section -->

                            <!-- Begin Book Reviews Section -->
                            <div class="mt-15" id="professor-book-reviews">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg">
                                        <input class="form-check-input" type="checkbox" id="include-book-reviews" name="include_book_reviews" checked>
                                        <label class="form-check-label fs-3" for="include-book-reviews">BOOK REVIEWS</label>
                                    </div>
                                </div>
                                <div id="book-reviews-content">
                                    <ul>
                                        @foreach($professor->bookReviews as $review)
                                        <li data-year="{{ $review->year }}" data-type="book_review" data-id="{{ $review->id }}">
                                            <strong>{{ $review->name }}</strong> - {{ $review->periodical_title }}, {{ $review->year }} {{ ucfirst($review->month) }}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="excludeEntry('book_review', {{ $review->id }})">-</button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End Book Reviews Section -->
                        </div>
                    </div>
                </div>
                <!-- End Sections -->

                <!-- Begin Submit Button -->
                <div class="text-end pt-15">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('messages.create') }}</span>
                        <span class="indicator-progress" style="display: none;">
                            {{ __('messages.please_wait') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!-- End Submit Button -->
            </div>
        </div>
    </form>
    <script>
        document.getElementById('include-degrees').addEventListener('change', function() {
            const degreesContent = document.getElementById('degrees-content');
            if (this.checked) {
                degreesContent.classList.remove('disabled');
            } else {
                degreesContent.classList.add('disabled');
            }
        });

        document.getElementById('include-employments').addEventListener('change', function() {
            const employmentsContent = document.getElementById('employments-content');
            if (this.checked) {
                employmentsContent.classList.remove('disabled');
            } else {
                employmentsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-activities').addEventListener('change', function() {
            const activitiesContent = document.getElementById('activities-content');
            if (this.checked) {
                activitiesContent.classList.remove('disabled');
            } else {
                activitiesContent.classList.add('disabled');
            }
        });

        document.getElementById('include-honors').addEventListener('change', function() {
            const honorsContent = document.getElementById('honors-content');
            if (this.checked) {
                honorsContent.classList.remove('disabled');
            } else {
                honorsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-academic-activities').addEventListener('change', function() {
            const academicActivitiesContent = document.getElementById('academic-activities-content');
            if (this.checked) {
                academicActivitiesContent.classList.remove('disabled');
            } else {
                academicActivitiesContent.classList.add('disabled');
            }
        });

        document.getElementById('include-supervisions').addEventListener('change', function() {
            const supervisionsContent = document.getElementById('supervisions-content');
            if (this.checked) {
                supervisionsContent.classList.remove('disabled');
            } else {
                supervisionsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-courses').addEventListener('change', function() {
            const coursesContent = document.getElementById('courses-content');
            if (this.checked) {
                coursesContent.classList.remove('disabled');
            } else {
                coursesContent.classList.add('disabled');
            }
        });

        document.getElementById('include-outside-courses').addEventListener('change', function() {
            const outsideCoursesContent = document.getElementById('outside-courses-content');
            if (this.checked) {
                outsideCoursesContent.classList.remove('disabled');
            } else {
                outsideCoursesContent.classList.add('disabled');
            }
        });

        document.getElementById('include-grants').addEventListener('change', function() {
            const grantsContent = document.getElementById('grants-content');
            if (this.checked) {
                grantsContent.classList.remove('disabled');
            } else {
                grantsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-internal-grants').addEventListener('change', function() {
            const internalGrantsContent = document.getElementById('internal-grants-content');
            if (this.checked) {
                internalGrantsContent.classList.remove('disabled');
            } else {
                internalGrantsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-publications-summary').addEventListener('change', function() {
            const publicationsSummary = document.getElementById('professor-publications-summary-content');
            if (this.checked) {
                publicationsSummary.classList.remove('disabled');
            } else {
                publicationsSummary.classList.add('disabled');
            }
        });

        document.getElementById('include-working-papers').addEventListener('change', function() {
            const workingPapersContent = document.getElementById('working-papers-content');
            if (this.checked) {
                workingPapersContent.classList.remove('disabled');
            } else {
                workingPapersContent.classList.add('disabled');
            }
        });

        document.getElementById('include-articles-in-magazines').addEventListener('change', function() {
            const articlesInMagazinesContent = document.getElementById('articles-in-magazines-content');
            if (this.checked) {
                articlesInMagazinesContent.classList.remove('disabled');
            } else {
                articlesInMagazinesContent.classList.add('disabled');
            }
        });

        document.getElementById('include-books').addEventListener('change', function() {
            const booksContent = document.getElementById('books-content');
            if (this.checked) {
                booksContent.classList.remove('disabled');
            } else {
                booksContent.classList.add('disabled');
            }
        });

        document.getElementById('include-forthcoming-books').addEventListener('change', function() {
            const forthcomingBooksContent = document.getElementById('forthcoming-books-content');
            if (this.checked) {
                forthcomingBooksContent.classList.remove('disabled');
            } else {
                forthcomingBooksContent.classList.add('disabled');
            }
        });

        document.getElementById('include-chapters-in-books').addEventListener('change', function() {
            const chaptersInBooksContent = document.getElementById('chapters-in-books-content');
            if (this.checked) {
                chaptersInBooksContent.classList.remove('disabled');
            } else {
                chaptersInBooksContent.classList.add('disabled');
            }
        });

        document.getElementById('include-forthcoming-chapters-in-books').addEventListener('change', function() {
            const forthcomingChaptersInBooksContent = document.getElementById('forthcoming-chapters-in-books-content');
            if (this.checked) {
                forthcomingChaptersInBooksContent.classList.remove('disabled');
            } else {
                forthcomingChaptersInBooksContent.classList.add('disabled');
            }
        });

        document.getElementById('include-papers-in-journals').addEventListener('change', function() {
            const papersInJournalsContent = document.getElementById('papers-in-journals-content');
            if (this.checked) {
                papersInJournalsContent.classList.remove('disabled');
            } else {
                papersInJournalsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-forthcoming-papers-in-journals').addEventListener('change', function() {
            const forthcomingPapersInJournalsContent = document.getElementById('forthcoming-papers-in-journals-content');
            if (this.checked) {
                forthcomingPapersInJournalsContent.classList.remove('disabled');
            } else {
                forthcomingPapersInJournalsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-papers-in-conference-proceedings').addEventListener('change', function() {
            const papersInConferenceProceedingsContent = document.getElementById('papers-in-conference-proceedings-content');
            if (this.checked) {
                papersInConferenceProceedingsContent.classList.remove('disabled');
            } else {
                papersInConferenceProceedingsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-technical-reports').addEventListener('change', function() {
            const technicalReportsContent = document.getElementById('technical-reports-content');
            if (this.checked) {
                technicalReportsContent.classList.remove('disabled');
            } else {
                technicalReportsContent.classList.add('disabled');
            }
        });

        document.getElementById('include-articles-in-newspapers').addEventListener('change', function() {
            const articlesInNewspapersContent = document.getElementById('articles-in-newspapers-content');
            if (this.checked) {
                articlesInNewspapersContent.classList.remove('disabled');
            } else {
                articlesInNewspapersContent.classList.add('disabled');
            }
        });

        document.getElementById('include-articles-in-newsletters').addEventListener('change', function() {
            const articlesInNewslettersContent = document.getElementById('articles-in-newsletters-content');
            if (this.checked) {
                articlesInNewslettersContent.classList.remove('disabled');
            } else {
                articlesInNewslettersContent.classList.add('disabled');
            }
        });

        document.getElementById('include-letters-to-editor').addEventListener('change', function() {
            const lettersToEditorContent = document.getElementById('letters-to-editor-content');
            if (this.checked) {
                lettersToEditorContent.classList.remove('disabled');
            } else {
                lettersToEditorContent.classList.add('disabled');
            }
        });

        document.getElementById('include-book-reviews').addEventListener('change', function() {
            const bookReviewsContent = document.getElementById('book-reviews-content');
            if (this.checked) {
                bookReviewsContent.classList.remove('disabled');
            } else {
                bookReviewsContent.classList.add('disabled');
            }
        });

        function filterAllSections() {
            filterDegrees();
            filterEmployments();
            filterActivities();
            filterHonors();
            filterAcademicActivities();
            filterSupervisions();
            filterCourses();
            filterOutsideCourses();
            filterGrants();
            filterInternalGrants();
            filterBooks();
            filterForthcomingBooks();
            filterChaptersInBooks();
            filterForthcomingChaptersInBooks();
            filterPapersInJournals();
            filterForthcomingPapersInJournals();
            filterPapersInConferenceProceedings();
            filterTechnicalReports();
            filterWorkingPapers();
            filterArticlesInMagazines();
            filterArticlesInNewspapers();
            filterArticlesInNewsletters();
            filterLettersToEditor();
            filterBookReviews();
        }

        function filterDegrees() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const degreesTableBody = document.getElementById('degrees-table-body');
            const rows = degreesTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const year = parseInt(row.getAttribute('data-year'));
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - year <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterEmployments() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const employmentsTableBody = document.getElementById('employments-table-body');
            const rows = employmentsTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startYear = parseInt(row.getAttribute('data-start-year'));
                const endYear = row.getAttribute('data-end-year') ? parseInt(row.getAttribute('data-end-year')) : currentYear;
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startYear <= 8 || currentYear - endYear <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startYear <= 3 || currentYear - endYear <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startYear <= 1 || currentYear - endYear <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterActivities() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const activitiesTableBody = document.getElementById('activities-table-body');
            const rows = activitiesTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startYear = parseInt(row.getAttribute('data-start-year'));
                const endYear = row.getAttribute('data-end-year') ? parseInt(row.getAttribute('data-end-year')) : currentYear;
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startYear <= 8 || currentYear - endYear <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startYear <= 3 || currentYear - endYear <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startYear <= 1 || currentYear - endYear <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterHonors() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const honorsTableBody = document.getElementById('honors-table-body');
            const rows = honorsTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startYear = parseInt(row.getAttribute('data-start-year'));
                const endYear = row.getAttribute('data-end-year') ? parseInt(row.getAttribute('data-end-year')) : currentYear;
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startYear <= 8 || currentYear - endYear <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startYear <= 3 || currentYear - endYear <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startYear <= 1 || currentYear - endYear <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterAcademicActivities() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const academicActivitiesTableBody = document.getElementById('academic-activities-table-body');
            const rows = academicActivitiesTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startYear = parseInt(row.getAttribute('data-start-year'));
                const endYear = row.getAttribute('data-end-year') ? parseInt(row.getAttribute('data-end-year')) : currentYear;
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startYear <= 8 || currentYear - endYear <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startYear <= 3 || currentYear - endYear <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startYear <= 1 || currentYear - endYear <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterSupervisions() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const supervisionsTableBody = document.getElementById('supervisions-table-body');
            const rows = supervisionsTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startYear = parseInt(row.getAttribute('data-start-year'));
                const endYear = row.getAttribute('data-end-year') ? parseInt(row.getAttribute('data-end-year')) : currentYear;
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startYear <= 8 || currentYear - endYear <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startYear <= 3 || currentYear - endYear <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startYear <= 1 || currentYear - endYear <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterCourses() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const coursesTableBody = document.getElementById('courses-table-body');
            const rows = coursesTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const createdAt = new Date(row.getAttribute('data-created-at'));
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - createdAt.getFullYear() <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - createdAt.getFullYear() <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - createdAt.getFullYear() <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterOutsideCourses() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const outsideCoursesTableBody = document.getElementById('outside-courses-table-body');
            const rows = outsideCoursesTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const createdAt = new Date(row.getAttribute('data-created-at'));
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - createdAt.getFullYear() <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - createdAt.getFullYear() <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - createdAt.getFullYear() <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterGrants() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const grantsTableBody = document.getElementById('grants-table-body');
            const rows = grantsTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startDate = new Date(row.getAttribute('data-start-date'));
                const endDate = row.getAttribute('data-end-date') ? new Date(row.getAttribute('data-end-date')) : new Date();
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startDate.getFullYear() <= 8 || currentYear - endDate.getFullYear() <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startDate.getFullYear() <= 3 || currentYear - endDate.getFullYear() <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startDate.getFullYear() <= 1 || currentYear - endDate.getFullYear() <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterInternalGrants() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const internalGrantsTableBody = document.getElementById('internal-grants-table-body');
            const rows = internalGrantsTableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const startDate = new Date(row.getAttribute('data-start-date'));
                const endDate = row.getAttribute('data-end-date') ? new Date(row.getAttribute('data-end-date')) : new Date();
                let showRow = false;

                switch (range) {
                    case 'lifetime':
                        showRow = true;
                        break;
                    case '8_years':
                        showRow = currentYear - startDate.getFullYear() <= 8 || currentYear - endDate.getFullYear() <= 8;
                        break;
                    case '3_years':
                        showRow = currentYear - startDate.getFullYear() <= 3 || currentYear - endDate.getFullYear() <= 3;
                        break;
                    case '12_months':
                        showRow = currentYear - startDate.getFullYear() <= 1 || currentYear - endDate.getFullYear() <= 1;
                        break;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }

        function filterBooks() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const booksContent = document.getElementById('books-content');
            const items = booksContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterForthcomingBooks() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const forthcomingBooksContent = document.getElementById('forthcoming-books-content');
            const items = forthcomingBooksContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterChaptersInBooks() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const chaptersInBooksContent = document.getElementById('chapters-in-books-content');
            const items = chaptersInBooksContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterForthcomingChaptersInBooks() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const forthcomingChaptersInBooksContent = document.getElementById('forthcoming-chapters-in-books-content');
            const items = forthcomingChaptersInBooksContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterPapersInJournals() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const papersInJournalsContent = document.getElementById('papers-in-journals-content');
            const items = papersInJournalsContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterForthcomingPapersInJournals() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const forthcomingPapersInJournalsContent = document.getElementById('forthcoming-papers-in-journals-content');
            const items = forthcomingPapersInJournalsContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterPapersInConferenceProceedings() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const papersInConferenceProceedingsContent = document.getElementById('papers-in-conference-proceedings-content');
            const items = papersInConferenceProceedingsContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterTechnicalReports() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const technicalReportsContent = document.getElementById('technical-reports-content');
            const items = technicalReportsContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterWorkingPapers() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const workingPapersContent = document.getElementById('working-papers-content');
            const items = workingPapersContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterArticlesInMagazines() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const articlesInMagazinesContent = document.getElementById('articles-in-magazines-content');
            const items = articlesInMagazinesContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterArticlesInNewspapers() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const articlesInNewspapersContent = document.getElementById('articles-in-newspapers-content');
            const items = articlesInNewspapersContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterArticlesInNewsletters() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const articlesInNewslettersContent = document.getElementById('articles-in-newsletters-content');
            const items = articlesInNewslettersContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterLettersToEditor() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const lettersToEditorContent = document.getElementById('letters-to-editor-content');
            const items = lettersToEditorContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function filterBookReviews() {
            const range = document.getElementById('range').value;
            const currentYear = new Date().getFullYear();
            const bookReviewsContent = document.getElementById('book-reviews-content');
            const items = bookReviewsContent.getElementsByTagName('li');

            for (let item of items) {
                const year = parseInt(item.getAttribute('data-year'));
                let showItem = false;

                switch (range) {
                    case 'lifetime':
                        showItem = true;
                        break;
                    case '8_years':
                        showItem = currentYear - year <= 8;
                        break;
                    case '3_years':
                        showItem = currentYear - year <= 3;
                        break;
                    case '12_months':
                        showItem = currentYear - year <= 1;
                        break;
                }

                item.style.display = showItem ? '' : 'none';
            }
        }

        function excludeEntry(type, id) {
            const entry = document.querySelector(`[data-type="${type}"][data-id="${id}"]`);
            if (entry) {
                entry.style.display = 'none';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `exclude_${type}[]`;
                input.value = id;
                document.querySelector('form').appendChild(input);
            }
        }
    </script>
</x-default-layout>