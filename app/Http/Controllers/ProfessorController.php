<?php

namespace App\Http\Controllers;

use App\DataTables\ProfessorDegreesDataTable;
use App\Models\Address;
use App\Models\Professor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\ProfessorEducationsDataTable;

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

    public function showLanguages()
    {
        $professor = Auth::user()->professor;
        return view('pages/professors.my-profile-languages', compact('professor'));
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
