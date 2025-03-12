<?php

namespace App\Http\Controllers;

use App\DataTables\ProfessorActivitiesDataTable;
use App\DataTables\ProfessorArticlesDataTable;
use App\DataTables\ProfessorBookChaptersDataTable;
use App\DataTables\ProfessorBookReviewsDataTable;
use App\DataTables\ProfessorBooksDataTable;
use App\DataTables\ProfessorCasesDataTable;
use App\DataTables\ProfessorCoursesDataTable;
use App\DataTables\ProfessorDegreesDataTable;
use App\DataTables\ProfessorElectronicMediaDataTable;
use App\DataTables\ProfessorLanguagesDataTable;
use App\DataTables\ProfessorTeachingInterestsDataTable;
use App\Models\Address;
use App\Models\Professor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\ProfessorEmploymentHistoryDataTable;
use App\DataTables\ProfessorExpertiseAreasDataTable;
use App\DataTables\ProfessorGraduateSupervisionsDataTable;
use App\DataTables\ProfessorGrantsDataTable;
use App\DataTables\ProfessorHonorsDataTable;
use App\DataTables\ProfessorInterviewsDataTable;
use App\DataTables\ProfessorJournalArticlesDataTable;
use App\DataTables\ProfessorLettersToEditorsDataTable;
use App\DataTables\ProfessorMagazineArticlesDataTable;
use App\DataTables\ProfessorNewsletterArticlesDataTable;
use App\DataTables\ProfessorNewspaperArticlesDataTable;
use App\DataTables\ProfessorOutsideCoursesDataTable;
use App\DataTables\ProfessorPresentationsDataTable;
use App\DataTables\ProfessorResearchInterestsDataTable;
use App\DataTables\ProfessorTechnicalReportsDataTable;
use App\DataTables\ProfessorWorkingPapersDataTable;
use App\Models\Country;
use App\Models\ExpertiseArea;
use App\Models\Language;
use App\Models\ResearchArea;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $professor = $this->createProfessorData($data);
        $address = $this->createAddressData($data, $professor);
        $professor->update(['address_id' => $address->id]);

        $languages = $this->createLanguageData($data, $professor);
        $employments = $this->createEmploymentsData($data, $professor);
        $educations = $this->createEducationsData($data, $professor);
        $teachingInterests = $this->createTeachingInterestsData($data, $professor);
        $expertiseAreas = $this->createExpertiseAreasData($data, $professor);

        return redirect()->route('dashboard');
    }

    public function showDirectory()
    {
        // Get all professors
        $professors = Professor::with('address.country', 'employments.position')->paginate(12);

        // Get all countries
        $countries = Country::all();

        // Get all languages
        $languages = Language::all();

        // Get all research areas
        $researchAreas = ResearchArea::all();

        // Get all expertise areas
        $expertiseAreas = ExpertiseArea::all();

        return view('pages/professors.directory.index', compact('professors', 'countries', 'languages', 'researchAreas', 'expertiseAreas'));
    }

    public function searchDirectory(Request $request)
    {
        $query = Professor::query();
    
        // Filter by search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
    
        // Filter by research areas
        if ($request->filled('research_areas')) {
            $query->whereHas('researchInterests', function ($q) use ($request) {
                $q->whereIn('research_area_id', [$request->input('research_areas')]);
            });
        }
    
        // Filter by expertise areas
        if ($request->filled('expertise_areas')) {
            $query->whereHas('expertiseAreas', function ($q) use ($request) {
                $q->whereIn('expertise_area_id', [$request->input('expertise_areas')]);
            });
        }
    
        // // Filter by country
        if ($request->filled('country')) {
            $query->whereHas('address', function ($q) use ($request) {
                $q->where('country_id', $request->input('country'));
            });
        }
    
        // Filter by languages
        if ($request->filled('languages')) {
            $query->whereHas('languages', function ($q) use ($request) {
                $q->whereIn('language_id', [$request->input('languages')]);
            });
        }
    
        // Pagination pour Load More
        $perPage = 12;
        $professors = $query->paginate($perPage);
    
        return response()->json([
            'html' => view('pages.professors.directory.partials.list', compact('professors'))->render(),
            'hasMore' => $professors->hasMorePages(),
        ]);
    }

    public function showDirectoryProfile(Professor $professor)
    {
        // Get professor's address
        $professor->load('address.country');

        // Get professor's employments
        $professor->load('employments.position');

        // Get professor's degrees
        $professor->load('degrees.degree', 'degrees.discipline', 'degrees.department');

        // Get professor's activities
        $professor->load('activities.activityService');

        // Get professor's courses
        $professor->load('courses');

        return view('pages/professors.directory.profile', compact('professor'));
    }

    public function showCVBuilder()
    {
        $professor = Auth::user()->professor;
        $ranges = ['lifetime', '8_years', '3_years', '12_months'];
        $formats = ['pdf', 'docx'];
        return view('pages/professors.cv-builder.index', compact('professor', 'ranges', 'formats'));
    }

    public function submitBuild(Request $request)
    {
        $professor = Auth::user()->professor;
        try {
           $pdf = $this->generatePdf($professor, $request->all(), $request);
           return $pdf;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while generating the PDF.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function showOverview()
    {
        $professor = Auth::user()->professor;
        return view('pages/professors.my-profile-overview', compact('professor'));
    }

    public function showEducations(ProfessorDegreesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.educations.my-profile-educations', compact('professor', 'user_id'));
    }

    public function showLanguages(ProfessorLanguagesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.languages.my-profile-languages', compact('professor', 'user_id'));
    }

    public function showTeachingInterests(ProfessorTeachingInterestsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.teaching-interests.my-profile-teaching-interests', compact('professor', 'user_id'));
    }

    public function showTechnicalReports(ProfessorTechnicalReportsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.technical-reports.my-profile-technical-reports', compact('professor', 'user_id'));
    }

    public function showExpertiseAreas(ProfessorExpertiseAreasDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.expertise-areas.my-profile-expertise-areas', compact('professor', 'user_id'));
    }

    public function showOutsideCourses(ProfessorOutsideCoursesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.outside-courses.my-profile-outside-courses', compact('professor', 'user_id'));
    }

    public function showGrants(ProfessorGrantsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.grants.my-profile-grants', compact('professor', 'user_id'));
    }

    public function showMagazineArticles(ProfessorMagazineArticlesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.magazine-articles.my-profile-magazine-articles', compact('professor', 'user_id'));
    }

    public function showCaseArticles(ProfessorCasesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.case-articles.my-profile-cases', compact('professor', 'user_id'));
    }

    public function showNewsletters(ProfessorNewsletterArticlesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.newsletter-articles.my-profile-newsletter-articles', compact('professor', 'user_id'));
    }

    public function showNewspaperArticles(ProfessorNewspaperArticlesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.newspaper-articles.my-profile-newspaper-articles', compact('professor', 'user_id'));
    }

    public function showSupervisions(ProfessorGraduateSupervisionsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.supervisions.my-profile-graduate-supervisions', compact('professor', 'user_id'));
    }

    public function showHonors(ProfessorHonorsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.honors.my-profile-honors', compact('professor', 'user_id'));
    }

    public function showOtherArticles(ProfessorArticlesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.articles.my-profile-articles', compact('professor', 'user_id'));
    }

    public function showJournalArticles(ProfessorJournalArticlesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.journal-articles.my-profile-journal-articles', compact('professor', 'user_id'));
    }

    public function showCourses(ProfessorCoursesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.courses.my-profile-courses', compact('professor', 'user_id'));
    }

    public function showPresentations(ProfessorPresentationsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.presentations.my-profile-presentations', compact('professor', 'user_id'));
    }

    public function showLTEArticles(ProfessorLettersToEditorsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.letters-to-editor.my-profile-letters-to-editor', compact('professor', 'user_id'));
    }

    public function showBooks(ProfessorBooksDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.books.my-profile-books', compact('professor', 'user_id'));
    }

    public function showInterviews(ProfessorInterviewsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.interviews.my-profile-interviews', compact('professor', 'user_id'));
    }

    public function showElectronicMedia(ProfessorElectronicMediaDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.electronic-media.my-profile-electronic-media', compact('professor', 'user_id'));
    }


    public function showBookChapters(ProfessorBookChaptersDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.book-chapters.my-profile-book-chapters', compact('professor', 'user_id'));
    }

    public function showBookReviews(ProfessorBookReviewsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.book-reviews.my-profile-book-reviews', compact('professor', 'user_id'));
    }

    public function showWorkingPapers(ProfessorWorkingPapersDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.working-papers.my-profile-working-papers', compact('professor', 'user_id'));
    }

    public function showActivities(ProfessorActivitiesDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.activities.my-profile-activities', compact('professor', 'user_id'));
    }

    public function showRInterests(ProfessorResearchInterestsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.research-interests.my-profile-research-interests', compact('professor', 'user_id'));
    }

    public function showEmploymentHistory(ProfessorEmploymentHistoryDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.employment-history.my-profile-employment-history', compact('professor', 'user_id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professor $professor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        //
    }

    private function createProfessorData($data)
    {
        $professor = new Professor();
        $professor->workspace_id = Auth::user()->workspace_id;
        $professor->user_id = Auth::user()->id;
        $professor->first_name = $data['first_name'];
        $professor->middle_name = isset($data['middle_name']) ? $data['middle_name'] : '';
        $professor->last_name = $data['last_name'];
        $professor->birth_date = Carbon::parse($data['date_of_birth']);
        $professor->gender = $data['gender'];
        $professor->country_id = $data['country_id'];
        $professor->email = Auth::user()->email;
        $professor->office_email = $data['office_email'];
        $professor->website = isset($data['website']) ? $data['website'] : '';
        $professor->save();

        return $professor;
    }

    private function createAddressData($data, $professor)
    {
        $address = new Address();
        $address->user_id = $professor->user_id;
        $address->address_line_1 = $data['address_line_1'];
        $address->address_line_2 = isset($data['address_line_2']) ? $data['address_line_2'] : '';
        $address->city = $data['city'];
        $address->postal_code = $data['postcode'];
        $address->state = $data['state'];
        $address->country = $data['country_of_residence'];
        $address->save();

        return $address;
    }

    private function createLanguageData($data, $professor)
    {
        foreach ($data['languages_repeater'] as $languageData) {
            $professor->languages()->attach($languageData['language'], [
                'spoken_language_level_id' => $languageData['spoken_level'],
                'written_language_level_id' => $languageData['written']
            ]);
        }

        return $professor->languages();
    }

    private function createEmploymentsData($data, $professor)
    {
        foreach ($data['employments_repeater'] as $employmentData) {
            $professor->employments()->create([
                'employer' => $employmentData['employer_name'],
                'country_id' => $employmentData['emp_country_id'],
                'start_year' => $employmentData['start_year'],
                'position_id' => $employmentData['position_id'],
                'end_year' => $employmentData['end_year'],
                'is_current' => isset($employmentData['is_current']) ? 1 : 0,
                'is_full_time' => isset($employmentData['is_fulltime']) ? 1 : 0,
            ]);
        }

        return $professor->employments();
    }

    private function createEducationsData($data, $professor)
    {
        foreach ($data['educations_repeater'] as $educationData) {
            $professor->degrees()->create([
                'degree_id' => $educationData['degree_id'],
                'discipline_id' => $educationData['discipline_id'],
                'department_id' => $educationData['department_id'],
                'year' => $educationData['year'],
            ]);
        }

        return $professor->degrees();
    }

    private function createTeachingInterestsData($data, $professor)
    {
        foreach ($data['teaching_interests_repeater'] as $teachingInterestData) {
            $professor->teachingInterests()->create([
                'teaching_interest_id' => $teachingInterestData['teaching_interest_id'],
                'is_current' => isset($teachingInterestData['is_current']) ? 1 : 0,
            ]);
        }

        return $professor->teachingInterests();
    }

    private function createExpertiseAreasData($data, $professor)
    {
        foreach ($data['expertise_areas_repeater'] as $expertiseAreaData) {
            $professor->expertiseAreas()->create([
                'expertise_area_id' => $expertiseAreaData['expertise_area_id'],
                'is_current' => isset($expertiseAreaData['is_current']) ? 1 : 0,
            ]);
        }

        return $professor->expertiseAreas();
    }


    private function generatePdf($professor, $data, $request)
    {
        $include_degrees = $request->has('include_degrees');
        $include_employments = $request->has('include_employments');
        $include_activities = $request->has('include_activities');
        $include_honors = $request->has('include_honors');
        $include_academic_activities = $request->has('include_academic_activities');
        $include_supervisions = $request->has('include_supervisions');
        $include_courses = $request->has('include_courses');
        $include_outside_courses = $request->has('include_outside_courses');
        $include_grants = $request->has('include_grants');
        $include_internal_grants = $request->has('include_internal_grants');
        $include_publications_summary = $request->has('include_publications_summary');
        $include_books = $request->has('include_books');
        $include_forthcoming_books = $request->has('include_forthcoming_books');
        $include_chapters_in_books = $request->has('include_chapters_in_books');
        $include_forthcoming_chapters_in_books = $request->has('include_forthcoming_chapters_in_books');
        $include_papers_in_journals = $request->has('include_papers_in_journals');
        $include_forthcoming_papers_in_journals = $request->has('include_forthcoming_papers_in_journals');
        $include_papers_in_conference_proceedings = $request->has('include_papers_in_conference_proceedings');
        $include_technical_reports = $request->has('include_technical_reports');
        $include_working_papers = $request->has('include_working_papers');
        $include_articles_in_magazines = $request->has('include_articles_in_magazines');
        $include_articles_in_newspapers = $request->has('include_articles_in_newspapers');
        $include_articles_in_newsletters = $request->has('include_articles_in_newsletters');
        $include_letters_to_editor = $request->has('include_letters_to_editor');
        $include_book_reviews = $request->has('include_book_reviews');

        $range = $data['range'];
        $currentYear = Carbon::now()->year;

        $filteredDegrees = $professor->degrees;
        $filteredEmployments = $professor->employments;
        $filteredActivities = $professor->activities;
        $filteredHonors = $professor->honors;
        $filteredAcademicActivities = $professor->activities->whereIn('activity_service_id', [1, 2]);
        $filteredSupervisions = $professor->graduateSupervisions;
        $filteredCourses = $professor->courses;
        $filteredOutsideCourses = $professor->outsideCourses;
        $filteredGrants = $professor->grants->where('is_external', 1);
        $filteredInternalGrants = $professor->grants->where('is_external', 0);
        $filteredBooks = $professor->books;
        $filteredForthcomingBooks = $professor->books;
        $filteredChaptersInBooks = $professor->bookChapters;
        $filteredForthcomingChaptersInBooks = $professor->bookChapters;
        $filteredPapersInJournals = $professor->journalArticles;
        $filteredForthcomingPapersInJournals = $professor->journalArticles;
        $filteredPapersInConferenceProceedings = $professor->proceedings;
        $filteredTechnicalReports = $professor->technicalReports;
        $filteredWorkingPapers = $professor->workingPapers;
        $filteredArticlesInMagazines = $professor->magazineArticles;
        $filteredArticlesInNewspapers = $professor->newspaperArticles;
        $filteredArticlesInNewsletters = $professor->newsletterArticles;
        $filteredLettersToEditor = $professor->letterToEditorArticles;
        $filteredBookReviews = $professor->bookReviews;

        if ($range !== 'lifetime') {
            $years = [
                '8_years' => 8,
                '3_years' => 3,
                '12_months' => 1,
            ];

            $filteredDegrees = $filteredDegrees->filter(function ($degree) use ($currentYear, $years, $range) {
                return $currentYear - $degree->year <= $years[$range];
            });

            $filteredEmployments = $filteredEmployments->filter(function ($employment) use ($currentYear, $years, $range) {
                return $currentYear - $employment->start_year <= $years[$range] || ($employment->end_year && $currentYear - $employment->end_year <= $years[$range]) || $employment->is_current;
            });

            $filteredActivities = $filteredActivities->filter(function ($activity) use ($currentYear, $years, $range) {
                return $currentYear - $activity->start_year <= $years[$range] || ($activity->end_year && $currentYear - $activity->end_year <= $years[$range]);
            });

            $filteredHonors = $filteredHonors->filter(function ($honor) use ($currentYear, $years, $range) {
                return $currentYear - $honor->start_year <= $years[$range] || ($honor->end_year && $currentYear - $honor->end_year <= $years[$range]);
            });

            $filteredAcademicActivities = $filteredAcademicActivities->filter(function ($activity) use ($currentYear, $years, $range) {
                return $currentYear - $activity->start_year <= $years[$range] || ($activity->end_year && $currentYear - $activity->end_year <= $years[$range]);
            });

            $filteredSupervisions = $filteredSupervisions->filter(function ($supervision) use ($currentYear, $years, $range) {
                return $currentYear - $supervision->start_year <= $years[$range] || ($supervision->end_year && $currentYear - $supervision->end_year <= $years[$range]);
            });

            $filteredCourses = $filteredCourses->filter(function ($course) use ($currentYear, $years, $range) {
                return $currentYear - $course->created_at->year <= $years[$range];
            });

            $filteredOutsideCourses = $filteredOutsideCourses->filter(function ($course) use ($currentYear, $years, $range) {
                return $currentYear - $course->created_at->year <= $years[$range];
            });

            $filteredGrants = $filteredGrants->filter(function ($grant) use ($currentYear, $years, $range) {
                return $currentYear - Carbon::parse($grant->start_date)->year <= $years[$range] || ($grant->end_date && $currentYear - Carbon::parse($grant->end_date)->year <= $years[$range]);
            });

            $filteredInternalGrants = $filteredInternalGrants->filter(function ($grant) use ($currentYear, $years, $range) {
                return $currentYear - Carbon::parse($grant->start_date)->year <= $years[$range] || ($grant->end_date && $currentYear - Carbon::parse($grant->end_date)->year <= $years[$range]);
            });

            $filteredBooks = $filteredBooks->filter(function ($book) use ($currentYear, $years, $range) {
                return $currentYear - $book->year <= $years[$range];
            });

            $filteredForthcomingBooks = $filteredForthcomingBooks->filter(function ($book) use ($currentYear, $years, $range) {
                return $currentYear - $book->year <= $years[$range];
            });

            $filteredChaptersInBooks = $filteredChaptersInBooks->filter(function ($chapter) use ($currentYear, $years, $range) {
                return $currentYear - $chapter->published_year <= $years[$range];
            });

            $filteredForthcomingChaptersInBooks = $filteredForthcomingChaptersInBooks->filter(function ($chapter) use ($currentYear, $years, $range) {
                return $currentYear - $chapter->published_year <= $years[$range];
            });

            $filteredPapersInJournals = $filteredPapersInJournals->filter(function ($paper) use ($currentYear, $years, $range) {
                return $currentYear - $paper->year <= $years[$range];
            });

            $filteredForthcomingPapersInJournals = $filteredForthcomingPapersInJournals->filter(function ($paper) use ($currentYear, $years, $range) {
                return $currentYear - $paper->year <= $years[$range];
            });

            $filteredPapersInConferenceProceedings = $filteredPapersInConferenceProceedings->filter(function ($presentation) use ($currentYear, $years, $range) {
                return $currentYear - $presentation->year <= $years[$range];
            });

            $filteredTechnicalReports = $filteredTechnicalReports->filter(function ($report) use ($currentYear, $years, $range) {
                return $currentYear - $report->year <= $years[$range];
            });

            $filteredWorkingPapers = $filteredWorkingPapers->filter(function ($paper) use ($currentYear, $years, $range) {
                return $currentYear - $paper->year <= $years[$range];
            });

            $filteredArticlesInMagazines = $filteredArticlesInMagazines->filter(function ($article) use ($currentYear, $years, $range) {
                return $currentYear - $article->year <= $years[$range];
            });

            $filteredArticlesInNewspapers = $filteredArticlesInNewspapers->filter(function ($article) use ($currentYear, $years, $range) {
                return $currentYear - $article->year <= $years[$range];
            });

            $filteredArticlesInNewsletters = $filteredArticlesInNewsletters->filter(function ($article) use ($currentYear, $years, $range) {
                return $currentYear - $article->year <= $years[$range];
            });

            $filteredLettersToEditor = $filteredLettersToEditor->filter(function ($article) use ($currentYear, $years, $range) {
                return $currentYear - $article->year <= $years[$range];
            });

            $filteredBookReviews = $filteredBookReviews->filter(function ($review) use ($currentYear, $years, $range) {
                return $currentYear - $review->year <= $years[$range];
            });
        }

        // Exclude entries based on request data
        $exclude_degrees = $request->input('exclude_degree', []);
        $exclude_employments = $request->input('exclude_employment', []);
        $exclude_activities = $request->input('exclude_activity', []);
        $exclude_honors = $request->input('exclude_honor', []);
        $exclude_academic_activities = $request->input('exclude_academic_activity', []);
        $exclude_supervisions = $request->input('exclude_supervision', []);
        $exclude_courses = $request->input('exclude_course', []);
        $exclude_outside_courses = $request->input('exclude_outside_course', []);
        $exclude_grants = $request->input('exclude_grant', []);
        $exclude_internal_grants = $request->input('exclude_internal_grant', []);
        $exclude_books = $request->input('exclude_book', []);
        $exclude_forthcoming_books = $request->input('exclude_forthcoming_book', []);
        $exclude_chapters = $request->input('exclude_chapter', []);
        $exclude_forthcoming_chapters = $request->input('exclude_forthcoming_chapter', []);
        $exclude_papers = $request->input('exclude_paper', []);
        $exclude_forthcoming_papers = $request->input('exclude_forthcoming_paper', []);
        $exclude_presentations = $request->input('exclude_presentation', []);
        $exclude_technical_reports = $request->input('exclude_technical_report', []);
        $exclude_working_papers = $request->input('exclude_working_paper', []);
        $exclude_articles_in_magazines = $request->input('exclude_magazine_article', []);
        $exclude_articles_in_newspapers = $request->input('exclude_newspaper_article', []);
        $exclude_articles_in_newsletters = $request->input('exclude_newsletter_article', []);
        $exclude_letters_to_editor = $request->input('exclude_letter_to_editor', []);
        $exclude_book_reviews = $request->input('exclude_book_review', []);

        $filteredDegrees = $filteredDegrees->whereNotIn('id', $exclude_degrees);
        $filteredEmployments = $filteredEmployments->whereNotIn('id', $exclude_employments);
        $filteredActivities = $filteredActivities->whereNotIn('id', $exclude_activities);
        $filteredHonors = $filteredHonors->whereNotIn('id', $exclude_honors);
        $filteredAcademicActivities = $filteredAcademicActivities->whereNotIn('id', $exclude_academic_activities);
        $filteredSupervisions = $filteredSupervisions->whereNotIn('id', $exclude_supervisions);
        $filteredCourses = $filteredCourses->whereNotIn('id', $exclude_courses);
        $filteredOutsideCourses = $filteredOutsideCourses->whereNotIn('id', $exclude_outside_courses);
        $filteredGrants = $filteredGrants->whereNotIn('id', $exclude_grants);
        $filteredInternalGrants = $filteredInternalGrants->whereNotIn('id', $exclude_internal_grants);
        $filteredBooks = $filteredBooks->whereNotIn('id', $exclude_books);
        $filteredForthcomingBooks = $filteredForthcomingBooks->whereNotIn('id', $exclude_forthcoming_books);
        $filteredChaptersInBooks = $filteredChaptersInBooks->whereNotIn('id', $exclude_chapters);
        $filteredForthcomingChaptersInBooks = $filteredForthcomingChaptersInBooks->whereNotIn('id', $exclude_forthcoming_chapters);
        $filteredPapersInJournals = $filteredPapersInJournals->whereNotIn('id', $exclude_papers);
        $filteredForthcomingPapersInJournals = $filteredForthcomingPapersInJournals->whereNotIn('id', $exclude_forthcoming_papers);
        $filteredPapersInConferenceProceedings = $filteredPapersInConferenceProceedings->whereNotIn('id', $exclude_presentations);
        $filteredTechnicalReports = $filteredTechnicalReports->whereNotIn('id', $exclude_technical_reports);
        $filteredWorkingPapers = $filteredWorkingPapers->whereNotIn('id', $exclude_working_papers);
        $filteredArticlesInMagazines = $filteredArticlesInMagazines->whereNotIn('id', $exclude_articles_in_magazines);
        $filteredArticlesInNewspapers = $filteredArticlesInNewspapers->whereNotIn('id', $exclude_articles_in_newspapers);
        $filteredArticlesInNewsletters = $filteredArticlesInNewsletters->whereNotIn('id', $exclude_articles_in_newsletters);
        $filteredLettersToEditor = $filteredLettersToEditor->whereNotIn('id', $exclude_letters_to_editor);
        $filteredBookReviews = $filteredBookReviews->whereNotIn('id', $exclude_book_reviews);

        $pdf = Pdf::loadView('pages/professors.cv-builder.pdf-templates.cv-template', [
            'professor' => $professor,
            'include_degrees' => $include_degrees,
            'include_employments' => $include_employments,
            'include_activities' => $include_activities,
            'include_honors' => $include_honors,
            'include_academic_activities' => $include_academic_activities,
            'include_supervisions' => $include_supervisions,
            'include_courses' => $include_courses,
            'include_outside_courses' => $include_outside_courses,
            'include_grants' => $include_grants,
            'include_internal_grants' => $include_internal_grants,
            'include_publications_summary' => $include_publications_summary,
            'include_books' => $include_books,
            'include_forthcoming_books' => $include_forthcoming_books,
            'include_chapters_in_books' => $include_chapters_in_books,
            'include_forthcoming_chapters_in_books' => $include_forthcoming_chapters_in_books,
            'include_papers_in_journals' => $include_papers_in_journals,
            'include_forthcoming_papers_in_journals' => $include_forthcoming_papers_in_journals,
            'include_papers_in_conference_proceedings' => $include_papers_in_conference_proceedings,
            'include_technical_reports' => $include_technical_reports,
            'include_working_papers' => $include_working_papers,
            'include_articles_in_magazines' => $include_articles_in_magazines,
            'include_articles_in_newspapers' => $include_articles_in_newspapers,
            'include_articles_in_newsletters' => $include_articles_in_newsletters,
            'include_letters_to_editor' => $include_letters_to_editor,
            'include_book_reviews' => $include_book_reviews,
            'filteredDegrees' => $filteredDegrees,
            'filteredEmployments' => $filteredEmployments,
            'filteredActivities' => $filteredActivities,
            'filteredHonors' => $filteredHonors,
            'filteredAcademicActivities' => $filteredAcademicActivities,
            'filteredSupervisions' => $filteredSupervisions,
            'filteredCourses' => $filteredCourses,
            'filteredOutsideCourses' => $filteredOutsideCourses,
            'filteredGrants' => $filteredGrants,
            'filteredInternalGrants' => $filteredInternalGrants,
            'filteredBooks' => $filteredBooks,
            'filteredForthcomingBooks' => $filteredForthcomingBooks,
            'filteredChaptersInBooks' => $filteredChaptersInBooks,
            'filteredForthcomingChaptersInBooks' => $filteredForthcomingChaptersInBooks,
            'filteredPapersInJournals' => $filteredPapersInJournals,
            'filteredForthcomingPapersInJournals' => $filteredForthcomingPapersInJournals,
            'filteredPapersInConferenceProceedings' => $filteredPapersInConferenceProceedings,
            'filteredTechnicalReports' => $filteredTechnicalReports,
            'filteredWorkingPapers' => $filteredWorkingPapers,
            'filteredArticlesInMagazines' => $filteredArticlesInMagazines,
            'filteredArticlesInNewspapers' => $filteredArticlesInNewspapers,
            'filteredArticlesInNewsletters' => $filteredArticlesInNewsletters,
            'filteredLettersToEditor' => $filteredLettersToEditor,
            'filteredBookReviews' => $filteredBookReviews,
        ]);

        $rangeLabels = [
            'lifetime' => 'Lifetime',
            '8_years' => '8Y',
            '3_years' => '3Y',
            '12_months' => '12Mo',
        ];

        $pdfName = 'CV_' . $rangeLabels[$range] . '_'. ucfirst($professor->first_name) . ucfirst($professor->last_name) . '_' . Carbon::now()->format('Y_m_d')  . '.pdf';
        return $pdf->download($pdfName);
    }
}
