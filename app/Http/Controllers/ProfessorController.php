<?php

namespace App\Http\Controllers;

use App\DataTables\ProfessorActivitiesDataTable;
use App\DataTables\ProfessorArticlesDataTable;
use App\DataTables\ProfessorBookChaptersDataTable;
use App\DataTables\ProfessorBookReviewsDataTable;
use App\DataTables\ProfessorBooksDataTable;
use App\DataTables\ProfessorCasesDataTable;
use App\DataTables\ProfessorDegreesDataTable;
use App\DataTables\ProfessorElectronicMediaDataTable;
use App\DataTables\ProfessorLanguagesDataTable;
use App\DataTables\ProfessorTeachingInterestsDataTable;
use App\Models\Address;
use App\Models\Professor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\ProfessorEmploymentHistoryDataTable;
use App\DataTables\ProfessorGraduateSupervisionsDataTable;
use App\DataTables\ProfessorGrantsDataTable;
use App\DataTables\ProfessorInterviewsDataTable;
use App\DataTables\ProfessorJournalArticlesDataTable;
use App\DataTables\ProfessorMagazineArticlesDataTable;
use App\DataTables\ProfessorNewsletterArticlesDataTable;
use App\DataTables\ProfessorResearchInterestsDataTable;
use App\DataTables\ProfessorWorkingPapersDataTable;

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

    public function showSupervisions(ProfessorGraduateSupervisionsDataTable $dataTable)
    {
        $professor = Auth::user()->professor;
        $user_id = Auth::user()->id;

        return $dataTable->render('pages/professors.supervisions.my-profile-graduate-supervisions', compact('professor', 'user_id'));
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

    private function createProfessorData($data) {
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

    private function createAddressData($data, $professor) {
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

    private function createLanguageData($data, $professor) {
        foreach ($data['languages_repeater'] as $languageData) {
            $professor->languages()->attach($languageData['language'], [
            'spoken_language_level_id' => $languageData['spoken_level'],
            'written_language_level_id' => $languageData['written']
            ]);
        }

        return $professor->languages();
    }

    private function createEmploymentsData($data, $professor) {
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

    private function createEducationsData($data, $professor) {
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

    private function createTeachingInterestsData($data, $professor) {
        foreach ($data['teaching_interests_repeater'] as $teachingInterestData) {
            $professor->teachingInterests()->create([
                'teaching_interest_id' => $teachingInterestData['teaching_interest_id'],
                'is_current' => isset($teachingInterestData['is_current']) ? 1 : 0,
            ]);
        }

        return $professor->teachingInterests();
    }

    private function createExpertiseAreasData($data, $professor) {
        foreach ($data['expertise_areas_repeater'] as $expertiseAreaData) {
            $professor->expertiseAreas()->create([
                'expertise_area_id' => $expertiseAreaData['expertise_area_id'],
                'is_current' => isset($expertiseAreaData['is_current']) ? 1 : 0,
            ]);
        }

        return $professor->expertiseAreas();
    }
    
}
