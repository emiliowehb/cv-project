<?php

namespace App\Http\Controllers;

use App\DataTables\BookChapterReviewableDataTable;
use App\DataTables\BookReviewableDataTable;
use App\DataTables\CaseArticleReviewableDataTable;
use App\DataTables\JournalArticleReviewableDataTable;
use App\DataTables\MagazineArticleReviewableDataTable;
use App\DataTables\NewsletterReviewableDataTable;
use App\DataTables\NewspaperReviewableDataTable;
use App\Models\Reviewable;
use Illuminate\Http\Request;

class ReviewableController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reviewable $reviewable)
    {
        //
    }

    public function showBookSubmissions(BookReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.books.professor-book-submissions');
    }

    public function showBookChaptersSubmissions(BookChapterReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.book-chapters.professor-book-chapter-submissions');
    }

    public function showJournalArticlesSubmissions(JournalArticleReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.journal-articles.professor-journal-article-submissions');
    }

    public function showMagazineArticlesSubmissions(MagazineArticleReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.magazine-articles.professor-magazine-article-submissions');
    }

    public function showCaseArticlesSubmissions(CaseArticleReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.case-articles.professor-case-article-submissions');
    }

    public function showNewsletterArticlesSubmissions(NewsletterReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.newsletter-articles.professor-newsletter-article-submissions');
    }

    public function showNewspaperArticlesSubmissions(NewspaperReviewableDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.professor-submissions.newspaper-articles.professor-newspaper-article-submissions');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reviewable $reviewable)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reviewable $reviewable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviewable $reviewable)
    {
        //
    }
}
