<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id','address_id')->with('country');
    }

    public function languages() {
        return $this->belongsToMany(Language::class, 'professor_languages', 'professor_id', 'language_id')
            ->withPivot('spoken_language_level_id', 'written_language_level_id');
    }

    public function employments() {
        return $this->hasMany(Employment::class);
    }

    public function degrees() {
        return $this->hasMany(ProfessorDegree::class);
    }

    public function teachingInterests() {
        return $this->hasMany(ProfessorTeachingInterest::class);
    }

    public function researchInterests() {
        return $this->hasMany(ProfessorResearchInterest::class);
    }

    public function expertiseAreas() {
        return $this->hasMany(ProfessorExpertiseArea::class);
    }

    public function fullName() {
        return $this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name;
    }

    public function activities()
    {
        return $this->hasMany(ProfessorActivity::class);
    }

    public function honors()
    {
        return $this->hasMany(ProfessorHonor::class);
    }

    public function graduateSupervisions()
    {
        return $this->hasMany(ProfessorGraduateSupervision::class);
    }

    public function courses()
    {
        return $this->hasMany(ProfessorCourse::class);
    }

    public function outsideCourses()
    {
        return $this->hasMany(ProfessorOutsideCourse::class);
    }

    public function grants()
    {
        return $this->hasManyThrough(Grant::class, ProfessorGrant::class, 'professor_id', 'id', 'id', 'grant_id');
    }

    public function books()
    {
        return $this->hasMany(ProfessorBook::class);
    }

    public function bookChapters()
    {
        return $this->hasMany(ProfessorBookChapter::class);
    }

    public function journalArticles()
    {
        return $this->hasMany(ProfessorJournalArticle::class);
    }

    public function proceedings()
    {
        return $this->hasMany(ProfessorPresentation::class);
    }

    public function technicalReports()
    {
        return $this->hasMany(ProfessorTechnicalReport::class);
    }

    public function workingPapers()
    {
        return $this->hasMany(ProfessorWorkingPaper::class);
    }

    public function articles()
    {
        return $this->hasMany(ProfessorArticle::class);
    }

    public function magazineArticles()
    {
        return $this->hasMany(ProfessorArticle::class)->where('article_type_id', 2);
    }

    public function newspaperArticles()
    {
        return $this->hasMany(ProfessorArticle::class)->where('article_type_id', 3);
    }

    public function newsletterArticles()
    {
        return $this->hasMany(ProfessorArticle::class)->where('article_type_id', 4);
    }

    public function letterToEditorArticles()
    {
        return $this->hasMany(ProfessorArticle::class)->where('article_type_id', 5);
    }

    public function bookReviews()
    {
        return $this->hasMany(ProfessorBookReview::class);
    }

    public function formattedAddress()
    {
        $address = $this->address;
        if (!$address) {
            return null;
        }

        $formattedAddress = $address->address_line_1;

        if ($address->address_line_2) {
            $formattedAddress .= ', ' . $address->address_line_2;
        }
        
        $formattedAddress .= ', ' . $address->city;
        $formattedAddress .= ', ' . $address->state;
        $formattedAddress .= ' ' . $address->postal_code;

        $formattedAddress .= ', ' . Country::find($address->country_id)->name;

        return $formattedAddress;
    }
}
